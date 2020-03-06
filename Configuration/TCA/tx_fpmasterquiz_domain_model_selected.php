<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_selected',
        'label' => 'answers',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'points,entered,question,answers',
        'iconfile' => 'EXT:fp_masterquiz/Resources/Public/Icons/tx_fpmasterquiz_domain_model_selected.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, points, entered, question, answers',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, points, entered, question, answers'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_fpmasterquiz_domain_model_selected',
                'foreign_table_where' => 'AND tx_fpmasterquiz_domain_model_selected.pid=###CURRENT_PID### AND tx_fpmasterquiz_domain_model_selected.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],

        'points' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_selected.points',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'entered' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_selected.entered',
        	'config' => [
        		'type' => 'text',
        		'cols' => 40,
        		'rows' => 5,
        		'eval' => 'trim',
        	],
        ],
        'question' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_selected.question',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_question',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'answers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_selected.answers',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_answer',
                'foreign_table_where' => 'AND question = ###REC_FIELD_question###',
                'MM' => 'tx_fpmasterquiz_selected_answer_mm',
            ],
            
        ],
    
        'participant' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
