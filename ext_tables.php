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

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fp_masterquiz', 'Configuration/TypoScript', 'Master-Quiz');

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

    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder