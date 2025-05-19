<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

call_user_func(
    function()
    {

        ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'List',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'list, show, showAjax'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax'
            ]
        );
        ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Show',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax'
            ]
        );
        ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Showbytag',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'showByTag'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'showByTag'
            ]
        );
        ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Intro',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'intro, show, showAjax, showByTag'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'show, showAjax, showByTag'
            ]
        );
        ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Closure',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'closure'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'closure'
            ]
        );
        ExtensionUtility::configurePlugin(
            'FpMasterquiz',
            'Result',
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'result'
            ],
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'result'
            ]
        );
        ExtensionUtility::configurePlugin(
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
        if ((new Typo3Version())->getMajorVersion() < 13) {
            // @extensionScannerIgnoreLine
            ExtensionManagementUtility::addPageTSConfig('@import \'EXT:fp_masterquiz/Configuration/TSconfig/ContentElementWizard.tsconfig\'');

            // Register switchableControllerActions plugin migrator
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['switchableControllerActionsPluginUpdaterFpQuiz']
                = \Fixpunkt\FpMasterquiz\Updates\SwitchableControllerActionsPluginUpdater::class;
        }

        // register statistics tables for garbage collection
        // see https://docs.typo3.org/c/typo3/cms-scheduler/main/en-us/Installation/BaseTasks/Index.html#table-garbage-collection-task-example
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('scheduler')) {
            // Add deletion task (sheduler)
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Fixpunkt\FpMasterquiz\Task\DeleteParticipantTask::class] = [
                'extension' => 'fp_masterquiz',
                'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.title',
                'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.description',
                'additionalFields' => \Fixpunkt\FpMasterquiz\Task\DeleteParticipantAdditionalFieldProvider::class
            ];
            // CSV-export task
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Fixpunkt\FpMasterquiz\Task\CsvExportTask::class] = [
                'extension' => 'fp_masterquiz',
                'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.exportTitle',
                'description' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.exportDescription',
                'additionalFields' => \Fixpunkt\FpMasterquiz\Task\CsvExportAdditionalFieldProvider::class
            ];
        }
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
