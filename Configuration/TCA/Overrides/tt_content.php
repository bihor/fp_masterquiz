<?php
// Einbindung Flexform
$pluginSignature = 'fpmasterquiz_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue( $pluginSignature, 'FILE:EXT:fp_masterquiz/Configuration/FlexForms/flexform_pi1.xml' );
?>