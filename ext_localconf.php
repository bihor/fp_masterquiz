<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Fixpunkt.FpMasterquiz',
            'Pi1',
            [
                'Quiz' => 'list, default, show, showAjax'
            ],
            // non-cacheable actions
            [
                'Quiz' => 'default, show, showAjax'
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
			['source' => 'EXT:fp_masterquiz/ext_icon.gif']
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
	// Add CSV-import task (sheduler)
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Fixpunkt\\FpMasterquiz\\Task\\DeleteParticipantTask'] = array(
			'extension' => 'fp_masterquiz',
			'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.title',
			'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.description',
			'additionalFields' => 'Fixpunkt\\FpMasterquiz\\Task\\DeleteParticipantAdditionalFieldProvider'
	);
}