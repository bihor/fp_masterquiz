<?php

use Fixpunkt\FpMasterquiz\Controller\QuizController;
use Fixpunkt\FpMasterquiz\Controller\QuestionController;
use Fixpunkt\FpMasterquiz\Controller\ParticipantController;

/**
 * Definitions for modules provided by EXT:examples
 */
return [
    'fp_masterquiz' => [
        'parent' => 'web',
        'position' => ['after' => '*'],
        'access' => 'user',
        'workspaces' => 'live',
        'iconIdentifier' => 'fp_masterquiz-mod1',
        'path' => '/module/page/masterquiz',
        'labels' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_mod1.xlf',
        'extensionName' => 'FpMasterquiz',
        'controllerActions' => [
            QuizController::class => 'index,detail,charts',
            QuestionController::class => 'move',
            ParticipantController::class => 'list,detail,delete'
        ],
    ],
];
