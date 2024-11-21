<?php

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'fp_masterquiz-plugin-pi1' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:fp_masterquiz/Resources/Public/Icons/user_plugin_pi1.gif'
    ],
    'fp_masterquiz-mod1' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:fp_masterquiz/Resources/Public/Icons/user_mod_mod1.gif'
    ],
    'ext-fpmasterquiz-folder-icon' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:fp_masterquiz/Resources/Public/Icons/ext-fpmasterquiz-folder-icon.svg'
    ]
];
