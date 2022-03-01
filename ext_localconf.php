<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Pi1',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'list, intro, default, show, showAjax, showByTag, closure, defaultres, result, highscore'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'default, show, showAjax, showByTag, closure, defaultres, result, highscore'
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        masterquiz {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.name
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_pi1
                            }
                        }
                    }
                    show = *
                }
           }'
        );
        
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		$iconRegistry->registerIcon(
			'fp_masterquiz-plugin-pi1',
		    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
			['source' => 'EXT:fp_masterquiz/Resources/Public/Icons/user_plugin_pi1.gif']
		);
		$iconRegistry->registerIcon(
		    'ext-fpmasterquiz-folder-icon',
		    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		    ['source' => 'EXT:fp_masterquiz/Resources/Public/Icons/ext-fpmasterquiz-folder-icon.svg']
		);
		
    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

if (TYPO3_MODE === 'BE') {
    // Page module hook
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['fpmasterquiz_pi1']['fp_masterquiz'] =
        \Fixpunkt\FpMasterquiz\Hooks\PageLayoutView::class . '->getExtensionSummary';

	// Add deletion task (sheduler)
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Fixpunkt\\FpMasterquiz\\Task\\DeleteParticipantTask'] = array(
			'extension' => 'fp_masterquiz',
			'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.title',
			'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.description',
			'additionalFields' => 'Fixpunkt\\FpMasterquiz\\Task\\DeleteParticipantAdditionalFieldProvider'
	);
	// CSV-export task
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Fixpunkt\\FpMasterquiz\\Task\\CsvExportTask'] = array(
        'extension' => 'fp_masterquiz',
        'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.exportTitle',
        'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.exportDescription',
        'additionalFields' => 'Fixpunkt\\FpMasterquiz\\Task\\CsvExportAdditionalFieldProvider'
    );
}