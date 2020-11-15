<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Fixpunkt.FpMasterquiz',
            'Pi1',
            [
                'Quiz' => 'list, default, show, showAjax, random, defaultres, result'
            ],
            // non-cacheable actions
            [
                'Quiz' => 'default, show, showAjax, random, defaultres, result'
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

// Page module hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['fpmasterquiz_pi1']['fp_masterquiz'] =
\Fixpunkt\FpMasterquiz\Hooks\PageLayoutView::class . '->getExtensionSummary';

if (TYPO3_MODE === 'BE') {
	// Add deletion task (sheduler)
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Fixpunkt\\FpMasterquiz\\Task\\DeleteParticipantTask'] = array(
			'extension' => 'fp_masterquiz',
			'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.title',
			'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.description',
			'additionalFields' => 'Fixpunkt\\FpMasterquiz\\Task\\DeleteParticipantAdditionalFieldProvider'
	);
	// Add myquizpoll-import task (sheduler)
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Fixpunkt\\FpMasterquiz\\Task\\ImportQuizTask'] = array(
			'extension' => 'fp_masterquiz',
			'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.titleImport',
			'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.descriptionImport',
			'additionalFields' => 'Fixpunkt\\FpMasterquiz\\Task\\ImportQuizAdditionalFieldProvider'
	);
	// CSV-import task ist noch nicht fertig, kommt aber später hierhin
}