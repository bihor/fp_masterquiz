<?php
declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Backend\EventListener;

use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent;

final class PreviewEventListener
{
    /**
     * Extension key
     *
     * @var string
     */
    public const KEY = 'fpmasterquiz';

    /**
     * Path to the locallang file
     *
     * @var string
     */
    public const LLPATH = 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:';

    /**
     * Max shown settings
     */
    public const SETTINGS_IN_PREVIEW = 10;

    protected $recordMapping = [
        'startPageUid' => [
            'table' => 'pages',
            'multiValue' => false,
        ],
        'showPageUid' => [
            'table' => 'pages',
            'multiValue' => false,
        ],
        'resultPageUid' => [
            'table' => 'pages',
            'multiValue' => false,
        ],
        'closurePageUid' => [
            'table' => 'pages',
            'multiValue' => false,
        ],
        'defaultQuizUid' => [
            'table' => 'tx_fpmasterquiz_domain_model_quiz',
            'multiValue' => false,
        ],
        'pagebrowser.itemsPerPage' => [
            'table' => '',
            'multiValue' => false,
        ],
        'showAnswerPage' => [
            'table' => '',
            'multiValue' => false,
        ],
        'showOwnAnswers' => [
            'table' => '',
            'multiValue' => false,
        ],
        'showCorrectAnswers' => [
            'table' => '',
            'multiValue' => false,
        ],
        'showEveryAnswer' => [
            'table' => '',
            'multiValue' => false,
        ],
        'allowEdit' => [
            'table' => '',
            'multiValue' => false,
        ],
        'ajax' => [
            'table' => '',
            'multiValue' => false,
        ]
    ];

    /**
     * pi-Dinger
     *
     * @var array
     */
    protected $pis = ['fpmasterquiz_list', 'fpmasterquiz_show', 'fpmasterquiz_showbytag', 'fpmasterquiz_intro', 'fpmasterquiz_closure', 'fpmasterquiz_result', 'fpmasterquiz_highscore'];

    /**
     * Table information
     *
     * @var array
     */
    protected $tableData = [];

    /**
     * Flexform information
     *
     * @var array
     */
    protected $flexformData = [];

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    public function __invoke(PageContentPreviewRenderingEvent $event): void
    {
        if ($event->getTable() !== 'tt_content') {
            return;
        }

        if ($event->getRecord()['CType'] === 'list' && in_array($event->getRecord()['list_type'], $this->pis)) {
            $pi = substr((string) $event->getRecord()['list_type'], strpos((string) $event->getRecord()['list_type'], '_')+1);
            $header = '<strong>' . htmlspecialchars((string) $this->getLanguageService()->sL(self::LLPATH . 'template.' . $pi)) . '</strong>';
            $this->flexformData = GeneralUtility::xml2array($event->getRecord()['pi_flexform']);

            $this->getStartingPoint($event->getRecord()['pages']);

            if (is_array($this->flexformData)) {
                foreach ($this->recordMapping as $fieldName => $fieldConfiguration) {
                    $value = $this->getFieldFromFlexform('settings.' . $fieldName);
                    if (isset($value) && (!$fieldConfiguration['table'] || $value)) {
                        if ($fieldConfiguration['table']) {
                            $content = $this->getRecordData($value, $fieldConfiguration['table']);
                        } else {
                            $content = $value;
                        }
                        if ($fieldName == 'pagebrowser.itemsPerPage') {
                            $fieldName = 'itemsPerPage';
                        }
                        $this->tableData[] = [
                            $this->getLanguageService()->sL(self::LLPATH . 'settings.' . $fieldName),
                            $content
                        ];
                    }
                }
            }
            $event->setPreviewContent($this->renderSettingsAsTable($header, $event->getRecord()['uid']));
        }
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
                . '</span> &nbsp;';
            $content = BackendUtilityCore::wrapClickMenuOnIcon($data, $table, $record['uid'], true, '',
                '+info,edit,history');
            $content .= htmlspecialchars(BackendUtilityCore::getRecordTitle($table, $record));
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
     * Return language service instance
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    public function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}