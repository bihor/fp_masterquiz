<?php

namespace Fixpunkt\FpMasterquiz\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Hook to display verbose information about pi1 plugin in Web>Page module
 *
 */
class PageLayoutView
{

    /**
     * Extension key
     *
     * @var string
     */
    const KEY = 'fpmasterquiz';

    /**
     * Path to the locallang file
     *
     * @var string
     */
    const LLPATH = 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:';

    /**
     * Max shown settings
     */
    const SETTINGS_IN_PREVIEW = 10;

    /**
     * Table information
     *
     * @var array
     */
    public $tableData = [];

    /**
     * Flexform information
     *
     * @var array
     */
    public $flexformData = [];

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    /**
     * Returns information about this extension's pi1 plugin
     *
     * @param array $params Parameters to the hook
	 * @param	object		$pObj	A reference to calling object
     * @return string Information about pi1 plugin
     */
    public function getExtensionSummary($params, &$pObj)
    {
        $actionTranslationKey = $result = '';

        $header = '<strong>' . $this->getLanguageService()->sL(self::LLPATH . 'pagelayoutview') . '</strong>';

        if ($params['row']['list_type'] == self::KEY . '_pi1') {
            $this->flexformData = GeneralUtility::xml2array($params['row']['pi_flexform']);
            $this->tableData = [];

            // if flexform data is found
            $actions = $this->getFieldFromFlexform('switchableControllerActions');
            if (!empty($actions)) {
                $actionList = GeneralUtility::trimExplode(';', $actions);
                $actionList2 = GeneralUtility::trimExplode('>', $actionList[0]);

                // 1. action
                $actionTranslationKey = $actionList2[1];
                $actionTranslation = $this->getLanguageService()->sL(self::LLPATH . 'template.' . $actionTranslationKey);
                $actionTranslation = ($actionTranslation) ? htmlspecialchars($actionTranslation) : $actionTranslationKey;

                $th = $this->getLanguageService()->sL(self::LLPATH . 'template');
                $td = $actionTranslation;
            } else {
                $th = $this->generateCallout($this->getLanguageService()->sL(self::LLPATH . 'template.not_configured'));
                $td = '';
            }
            $this->tableData[] = [
            		$th,
            		$td
            ];

            $this->getStartingPoint($params['row']['pages']);

            if (is_array($this->flexformData)) {
               $startPageUid = (int)$this->getFieldFromFlexform('settings.startPageUid');
               if ($startPageUid > 0) {
                   $content = $this->getRecordData($startPageUid);
               	   $this->tableData[] = [
               			$this->getLanguageService()->sL(self::LLPATH . 'settings.startPageUid'),
               			$content
               	   ];
               }
               $showPageUid = (int)$this->getFieldFromFlexform('settings.showPageUid');
               if ($showPageUid > 0) {
                   $content = $this->getRecordData($showPageUid);
               	   $this->tableData[] = [
               			$this->getLanguageService()->sL(self::LLPATH . 'settings.showPageUid'),
               			$content
               	   ];
               }
               $resultPageUid = (int)$this->getFieldFromFlexform('settings.resultPageUid');
               if ($resultPageUid > 0) {
               	$content = $this->getRecordData($resultPageUid);
               	$this->tableData[] = [
               		$this->getLanguageService()->sL(self::LLPATH . 'settings.resultPageUid'),
               		$content
               	];
               }
                $closurePageUid = (int)$this->getFieldFromFlexform('settings.closurePageUid');
                if ($closurePageUid > 0) {
                    $content = $this->getRecordData($closurePageUid);
                    $this->tableData[] = [
                        $this->getLanguageService()->sL(self::LLPATH . 'settings.closurePageUid'),
                        $content
                    ];
                }
               $defaultQuizUid = (int)$this->getFieldFromFlexform('settings.defaultQuizUid');
               if ($defaultQuizUid > 0) {
                   $content = $this->getRecordData($defaultQuizUid, 'tx_fpmasterquiz_domain_model_quiz');
               	   $this->tableData[] = [
               			$this->getLanguageService()->sL(self::LLPATH . 'settings.defaultQuizUid'),
               			$content
               	   ];
               }
               $itemsPerPage = (int)$this->getFieldFromFlexform('settings.pagebrowser.itemsPerPage');
               if ($itemsPerPage > 0) {
                   $this->tableData[] = [
                       $this->getLanguageService()->sL(self::LLPATH . 'settings.itemsPerPage'),
                       $itemsPerPage
                   ];
               }
               $yesno = (int)$this->getFieldFromFlexform('settings.showAnswerPage');
               $this->tableData[] = [
                   $this->getLanguageService()->sL(self::LLPATH . 'settings.showAnswerPage'),
                   (($yesno) ? $this->getLanguageService()->sL(self::LLPATH . 'settings.yes') : $this->getLanguageService()->sL(self::LLPATH . 'settings.no'))
               ];
               $yesno = (int)$this->getFieldFromFlexform('settings.allowEdit');
               $this->tableData[] = [
                   $this->getLanguageService()->sL(self::LLPATH . 'settings.allowEdit'),
                   (($yesno) ? $this->getLanguageService()->sL(self::LLPATH . 'settings.yes') : $this->getLanguageService()->sL(self::LLPATH . 'settings.no'))
               ];
               $yesno = (int)$this->getFieldFromFlexform('settings.ajax');
               $this->tableData[] = [
                   $this->getLanguageService()->sL(self::LLPATH . 'settings.ajax'),
                   (($yesno) ? $this->getLanguageService()->sL(self::LLPATH . 'settings.yes') : $this->getLanguageService()->sL(self::LLPATH . 'settings.no'))
               ];
               if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['fp_masterquiz']['Quizpalme\\fp_masterquiz\\Hooks\\PageLayoutView']['extensionSummary'])
                   && is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['fp_masterquiz']['Quizpalme\\fp_masterquiz\\Hooks\\PageLayoutView']['extensionSummary'])) {
                    $params = [
                        'action' => $actionTranslationKey
                    ];
                    foreach ($GLOBALS['TYPO3_CONF_VARS']['EXT']['fp_masterquiz']['Quizpalme\\fp_masterquiz\\Hooks\\PageLayoutView']['extensionSummary'] as $reference) {
                        GeneralUtility::callUserFunction($reference, $params, $this);
                    }
               }
               $result = $this->renderSettingsAsTable($header, $params['row']['uid']);
            }
        }

        return $result;
    }

    /**
     * Get the rendered page title including onclick menu
     *
     * @param int $id
     * @param string $table
     * @return string
     */
    public function getRecordData($id, $table = 'pages')
    {
        $record = BackendUtilityCore::getRecord($table, $id);

        if (is_array($record)) {
            $data = '<span data-toggle="tooltip" data-placement="top" data-title="id=' . $record['uid'] . '">'
                . $this->iconFactory->getIconForRecord($table, $record, Icon::SIZE_SMALL)->render()
                . '</span> ';
            $content = BackendUtilityCore::wrapClickMenuOnIcon($data, $table, $record['uid'], true, '',
                '+info,edit,history');

            $linkTitle = htmlspecialchars(BackendUtilityCore::getRecordTitle($table, $record));

            if ($table === 'pages') {
                $id = $record['uid'];
                $currentPageId = (int)GeneralUtility::_GET('id');
                $link = htmlspecialchars($this->getEditLink($record, $currentPageId));
                $switchLabel = $this->getLanguageService()->sL(self::LLPATH . 'pagemodule.switchToPage');
                $content .= ' <a href="#" data-toggle="tooltip" data-placement="top" data-title="' . $switchLabel . '" onclick=\'top.jump("' . $link . '", "web_layout", "web", ' . $id . ');return false\'>' . $linkTitle . '</a>';
            } else {
                $content .= $linkTitle;
            }
        } else {
            $text = sprintf($this->getLanguageService()->sL(self::LLPATH . 'pagemodule.pageNotAvailable'),
                $id);
            $content = $this->generateCallout($text);
        }

        return $content;
    }

    /**
     * Get the startingpoint
     *
     * @param string $pids
     * @return void
     */
    public function getStartingPoint($pids)
    {
        if (!empty($pids)) {
            $pageIds = GeneralUtility::intExplode(',', $pids, true);
            $pagesOut = [];

            foreach ($pageIds as $id) {
                $pagesOut[] = $this->getRecordData($id, 'pages');
            }

            $recursiveLevel = (int)$this->getFieldFromFlexform('settings.recursive');
            $recursiveLevelText = '';
            if ($recursiveLevel === 250) {
                $recursiveLevelText = $this->getLanguageService()->sL('LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:recursive.I.5');
            } elseif ($recursiveLevel > 0) {
                $recursiveLevelText = $this->getLanguageService()->sL('LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:recursive.I.' . $recursiveLevel);
            }

            if (!empty($recursiveLevelText)) {
                $recursiveLevelText = '<br />' .
                    $this->getLanguageService()->sL(self::LLPATH . 'recursive') . ' ' .  $recursiveLevelText;
            }

            $this->tableData[] = [
                $this->getLanguageService()->sL(self::LLPATH . 'startingpoint'),
                implode(', ', $pagesOut) . $recursiveLevelText
            ];
        }
    }

    /**
     * Render an alert box
     *
     * @param string $text
     * @return string
     */
    protected function generateCallout($text)
    {
        return '<div class="alert alert-warning">' . htmlspecialchars($text) . '</div>';
    }

    /**
     * Render the settings as table for Web>Page module
     * System settings are displayed in mono font
     *
     * @param string $header
     * @param int $recordUid
     * @return string
     */
    protected function renderSettingsAsTable($header = '', $recordUid = 0)
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:fp_masterquiz/Resources/Private/Backend/Templates/PageLayoutView.html'));
        $view->assignMultiple([
            'header' => $header,
            'rows' => [
                'above' => array_slice($this->tableData, 0, self::SETTINGS_IN_PREVIEW),
                'below' => array_slice($this->tableData, self::SETTINGS_IN_PREVIEW)
            ],
            'id' => $recordUid
        ]);

        return $view->render();
    }

    /**
     * Get field value from flexform configuration,
     * including checks if flexform configuration is available
     *
     * @param string $key name of the key
     * @param string $sheet name of the sheet
     * @return string|NULL if nothing found, value if found
     */
    public function getFieldFromFlexform($key, $sheet = 'sDEF')
    {
        $flexform = $this->flexformData;
        if (isset($flexform['data'])) {
            $flexform = $flexform['data'];
            if (isset($flexform) && isset($flexform[$sheet]) && isset($flexform[$sheet]['lDEF'])
                && isset($flexform[$sheet]['lDEF'][$key]) && isset($flexform[$sheet]['lDEF'][$key]['vDEF'])
            ) {
                return $flexform[$sheet]['lDEF'][$key]['vDEF'];
            }
        }

        return null;
    }

    /**
     * Build a backend edit link based on given record.
     *
     * @param array $row Current record row from database.
     * @param int $currentPageUid current page uid
     * @return string Link to open an edit window for record.
     * @see \TYPO3\CMS\Backend\Utility\BackendUtilityCore::readPageAccess()
     */
    protected function getEditLink($row, $currentPageUid)
    {
        $editLink = '';
        $uriBuilder = GeneralUtility::makeInstance('TYPO3\CMS\Backend\Routing\UriBuilder');
        $localCalcPerms = $GLOBALS['BE_USER']->calcPerms(BackendUtilityCore::getRecord('pages', $row['uid']));
        $permsEdit = $localCalcPerms & Permission::PAGE_EDIT;
        if ($permsEdit) {
            $returnUrl = $uriBuilder->buildUriFromRoute('web_layout', ['id' => $currentPageUid]);
            $editLink = $uriBuilder->buildUriFromRoute('web_layout', [
                'id' => $row['uid'],
                'returnUrl' => $returnUrl
            ]);
        }
        return $editLink;
    }

    /**
     * Return language service instance
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    public function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
