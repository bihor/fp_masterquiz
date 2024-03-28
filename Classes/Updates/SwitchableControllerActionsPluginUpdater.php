<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "plain_faq" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Fixpunkt\FpMasterquiz\Updates;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class SwitchableControllerActionsPluginUpdater implements UpgradeWizardInterface
{
    private const MIGRATION_SETTINGS = [
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->list;Quiz->show;Quiz->showAjax',
            'targetListType' => 'fpmasterquiz_list',
        ],
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->default;Quiz->show;Quiz->showAjax',
            'targetListType' => 'fpmasterquiz_show',
        ],
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->showByTag',
            'targetListType' => 'fpmasterquiz_showbytag',
        ],
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->intro;Quiz->show;Quiz->showAjax;Quiz->showByTag',
            'targetListType' => 'fpmasterquiz_intro',
        ],
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->closure',
            'targetListType' => 'fpmasterquiz_closure',
        ],
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->defaultres;Quiz->result',
            'targetListType' => 'fpmasterquiz_result',
        ],
        [
            'sourceListType' => 'fpmasterquiz_pi1',
            'switchableControllerActions' => 'Quiz->highscore',
            'targetListType' => 'fpmasterquiz_highscore',
        ],
    ];

    protected FlexFormService $flexFormService;

    public function __construct()
    {
        $this->flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
    }

    public function getIdentifier(): string
    {
        return 'switchableControllerActionsPluginUpdaterFpQuiz';
    }

    public function getTitle(): string
    {
        return 'Migrates plugin and settings of existing Masterquiz plugins using switchableControllerActions';
    }

    public function getDescription(): string
    {
        $description = 'The old fp_masterquiz plugin using switchableControllerActions has been split into separate plugins. ';
        $description .= 'This update wizard migrates all existing plugin settings and changes the Plugin (list_type) ';
        $description .= 'to use the new plugins available.';
        return $description;
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    public function updateNecessary(): bool
    {
        return $this->checkIfWizardIsRequired();
    }

    public function executeUpdate(): bool
    {
        return $this->performMigration();
    }

    public function checkIfWizardIsRequired(): bool
    {
        return count($this->getMigrationRecords()) > 0;
    }

    public function performMigration(): bool
    {
        $records = $this->getMigrationRecords();

        foreach ($records as $record) {
            $flexFormData = GeneralUtility::xml2array($record['pi_flexform']);
            $flexForm = $this->flexFormService->convertFlexFormContentToArray($record['pi_flexform']);
            $targetListType = $this->getTargetListType(
                $record['list_type'],
                $flexForm['switchableControllerActions']
            );
            $allowedSettings = $this->getAllowedSettingsFromFlexForm($targetListType);

            // Remove flexform data which do not exist in flexform of new plugin
            foreach ($flexFormData['data'] as $sheetKey => $sheetData) {
                foreach ($sheetData['lDEF'] as $settingName => $setting) {
                    if (!in_array($settingName, $allowedSettings, true)) {
                        unset($flexFormData['data'][$sheetKey]['lDEF'][$settingName]);
                    }
                }

                // Remove empty sheets
                if (!count($flexFormData['data'][$sheetKey]['lDEF']) > 0) {
                    unset($flexFormData['data'][$sheetKey]);
                }
            }

            if (count($flexFormData['data']) > 0) {
                $newFlexform = $this->array2xml($flexFormData);
            } else {
                $newFlexform = '';
            }

            $this->updateContentElement($record['uid'], $targetListType, $newFlexform);
        }

        return true;
    }

    protected function getMigrationRecords(): array
    {
        $checkListTypes = array_unique(array_column(self::MIGRATION_SETTINGS, 'sourceListType'));

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder
            ->select('uid', 'list_type', 'pi_flexform')
            ->from('tt_content')->where($queryBuilder->expr()->in(
            'list_type',
            $queryBuilder->createNamedParameter($checkListTypes, Connection::PARAM_STR_ARRAY)
        ))->executeQuery()
            ->fetchAll();
    }

    protected function getTargetListType(string $sourceListType, string $switchableControllerActions): string
    {
        foreach (self::MIGRATION_SETTINGS as $setting) {
            if ($setting['sourceListType'] === $sourceListType &&
                $setting['switchableControllerActions'] === $switchableControllerActions
            ) {
                return $setting['targetListType'];
            }
        }

        return '';
    }

    protected function getAllowedSettingsFromFlexForm(string $listType): array
    {
        $settings = [];
        $flexFormFile = $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds'][$listType . ',list'];
        if ($flexFormFile) {
            $flexFormContent = file_get_contents(GeneralUtility::getFileAbsFileName(substr(trim((string) $flexFormFile), 5)));
            $flexFormData = GeneralUtility::xml2array($flexFormContent);

            // Iterate each sheet and extract all settings
            foreach ($flexFormData['sheets'] as $sheet) {
                foreach ($sheet['ROOT']['el'] as $setting => $tceForms) {
                    $settings[] = $setting;
                }
            }
        }
        return $settings;
    }

    /**
     * Updates list_type and pi_flexform of the given content element UID
     */
    protected function updateContentElement(int $uid, string $newListType, string $flexform): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->update('tt_content')
            ->set('list_type', $newListType)
            ->set('pi_flexform', $flexform)->where($queryBuilder->expr()->in(
            'uid',
            $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)
        ))->executeStatement();
    }

    /**
     * Transforms the given array to FlexForm XML
     *
     * @return string
     */
    protected function array2xml(array $input = []): string
    {
        $options = [
            'parentTagMap' => [
                'data' => 'sheet',
                'sheet' => 'language',
                'language' => 'field',
                'el' => 'field',
                'field' => 'value',
                'field:el' => 'el',
                'el:_IS_NUM' => 'section',
                'section' => 'itemType',
            ],
            'disableTypeAttrib' => 2,
        ];
        $spaceInd = 4;
        $output = GeneralUtility::array2xml($input, '', 0, 'T3FlexForms', $spaceInd, $options);
        $output = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . LF . $output;
        return $output;
    }
}