<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Fixpunkt.FpMasterquiz',
            'Pi1',
            'Master-Quiz'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'Fixpunkt.FpMasterquiz',
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
                'icon'   => 'EXT:fp_masterquiz/Resources/Public/Icons/user_mod_mod1.gif',
                'labels' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_mod1.xlf'
            ]
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_quiz', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_quiz.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_quiz');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_question', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_question.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_question');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_answer', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_answer.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_answer');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_evaluation', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_evaluation.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_evaluation');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_participant', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_participant.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_participant');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_selected', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_selected.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_selected');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fpmasterquiz_domain_model_tag', 'EXT:fp_masterquiz/Resources/Private/Language/locallang_csh_tx_fpmasterquiz_domain_model_tag.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fpmasterquiz_domain_model_tag');

    }
);