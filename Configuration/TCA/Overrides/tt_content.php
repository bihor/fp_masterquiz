<?php
/**
 * Register plugins, flexform and remove unused fields
 */
foreach (['list', 'show', 'showbytag', 'intro', 'closure', 'result', 'highscore'] as $plugin) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'FpMasterquiz',
        ucfirst($plugin),
        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:template.' . $plugin,
        'EXT:fp_masterquiz/ext_icon.gif',
        'fpmasterquiz'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fpmasterquiz_' . $plugin] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        'fpmasterquiz_' . $plugin,
        'FILE:EXT:fp_masterquiz/Configuration/FlexForms/flexform_pi1.xml'
    );

    // $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['plainfaq_' . $plugin] = 'layout,select_key,pages,recursive';
}