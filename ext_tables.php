<?php

defined('TYPO3') or die();

call_user_func(
    function()
    {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'FpMasterquiz',
            'web', // Make module a submodule of 'web'
            'mod1', // Submodule key
            '', // Position
            [
                \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'index,detail,charts',
                \Fixpunkt\FpMasterquiz\Controller\QuestionController::class => 'move',
                \Fixpunkt\FpMasterquiz\Controller\ParticipantController::class => 'list,detail,delete'
            ],
            [
                'access' => 'user,group',
                'iconIdentifier' => 'fp_masterquiz-mod1',
                'labels' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_mod1.xlf'
            ]
        );

        $versionInformation = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
        if ($versionInformation->getMajorVersion() < 12) {
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_quiz');

            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_question');

            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_answer');

            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_evaluation');

            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_participant');

            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_selected');

            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_tag');
        }

    }
);