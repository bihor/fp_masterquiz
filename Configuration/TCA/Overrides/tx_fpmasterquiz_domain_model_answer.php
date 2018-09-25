<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
   'fp_masterquiz',
   'tx_fpmasterquiz_domain_model_answer'
);
