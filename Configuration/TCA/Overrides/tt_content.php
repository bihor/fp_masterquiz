<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Register plugins, flexform and remove unused fields
 */
foreach (['list', 'show', 'showbytag', 'intro', 'closure', 'result', 'highscore'] as $plugin) {
    $pluginSignature = ExtensionUtility::registerPlugin(
        'FpMasterquiz',
        ucfirst($plugin),
        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.' . $plugin,
        'fp_masterquiz-mod1',
        'Masterquiz',
        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fp_masterquiz_pi1.description'
    );

    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--div--;Configuration,pi_flexform,pages',
        $pluginSignature,
        'after:subheader'
    );
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:fp_masterquiz/Configuration/FlexForms/flexform_pi1.xml',
        $pluginSignature   // = 'fpmasterquiz_' . $plugin
    );
    /*
    $GLOBALS['TCA']['tt_content']['types']['fpmasterquiz_' . $plugin]['showitem'] = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
            pi_flexform,
            pages, recursive,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ';
    */
}
