<?php

defined('TYPO3') or die();

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'List',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'list, show, showAjax'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Show',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Showbytag',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'showByTag'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'showByTag'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Intro',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'intro, show, showAjax, showByTag'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax, showByTag'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Closure',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'closure'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'closure'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Result',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'result'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'result'
            ]
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Highscore',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'highscore'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'highscore'
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.masterquiz {
                    header = Masterquiz
                    elements {
                        fpmasterquiz_list {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.list
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_list
                            }
                        }
                        fpmasterquiz_show {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.show
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_show
                            }
                        }
                        fpmasterquiz_showbytag {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.showbytag
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_showbytag
                            }
                        }
                        fpmasterquiz_intro {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.intro
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_intro
                            }
                        }
                        fpmasterquiz_closure {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.closure
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_closure
                            }
                        }
                        fpmasterquiz_result {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.result
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_result
                            }
                        }
                        fpmasterquiz_highscore {
                            iconIdentifier = fp_masterquiz-plugin-pi1
                            title = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.highscore
                            description = LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = fpmasterquiz_highscore
                            }
                        }
                    }
                    show = *
                }
           }'
        );

        // Add deletion task (sheduler)
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Fixpunkt\FpMasterquiz\Task\DeleteParticipantTask::class] = array(
            'extension' => 'fp_masterquiz',
            'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.title',
            'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.description',
            'additionalFields' => \Fixpunkt\FpMasterquiz\Task\DeleteParticipantAdditionalFieldProvider::class
        );
        // CSV-export task
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Fixpunkt\FpMasterquiz\Task\CsvExportTask::class] = array(
            'extension' => 'fp_masterquiz',
            'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.exportTitle',
            'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.exportDescription',
            'additionalFields' => \Fixpunkt\FpMasterquiz\Task\CsvExportAdditionalFieldProvider::class
        );

        // Register switchableControllerActions plugin migrator
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['switchableControllerActionsPluginUpdaterFpQuiz']
            = \Fixpunkt\FpMasterquiz\Updates\SwitchableControllerActionsPluginUpdater::class;
        // Fix faulty image references
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['fixImageReferencesFpQuiz']
            = \Fixpunkt\FpMasterquiz\Updates\FixImageReferencesUpgradeWizard::class;

        // Custom Logger
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['Fixpunkt']['FpMasterquiz']['Controller']['writerConfiguration'] = [
            // Configuration including all levels with higher severity
            \Psr\Log\LogLevel::DEBUG => [
                \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                    'logFileInfix' => 'fpmasterquiz',
                ],
            ],
        ];
    }
);
