<?php
defined('TYPO3') or die('Access denied.');

// Override icon
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'Master-Quiz',
    1 => 'fpquiz',
    2 => 'ext-fpmasterquiz-folder-icon'
];

$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-fpquiz'] = 'ext-fpmasterquiz-folder-icon';