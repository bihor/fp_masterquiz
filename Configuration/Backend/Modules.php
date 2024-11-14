<?php
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
            \Fixpunkt\FpMasterquiz\Controller\QuizController::class => 'index,detail,charts',
            \Fixpunkt\FpMasterquiz\Controller\QuestionController::class => 'move',
            \Fixpunkt\FpMasterquiz\Controller\ParticipantController::class => 'list,detail,delete'
        ],
    ],
];