<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Register plugins, flexform and remove unused fields
 */
foreach (['list', 'show', 'showbytag', 'intro', 'closure', 'result', 'highscore'] as $plugin) {
    ExtensionUtility::registerPlugin(
        'FpMasterquiz',
        ucfirst($plugin),
        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.' . $plugin,
        'fp_masterquiz-mod1',
        'Masterquiz',
        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fpmasterquiz_' . $plugin] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        'fpmasterquiz_' . $plugin,
        'FILE:EXT:fp_masterquiz/Configuration/FlexForms/flexform_pi1.xml'
    );

    // $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['plainfaq_' . $plugin] = 'layout,select_key,pages,recursive';
}
