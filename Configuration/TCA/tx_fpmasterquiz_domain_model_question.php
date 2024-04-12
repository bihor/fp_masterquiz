<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'searchFields' => 'title,bodytext,explanation',
        'iconfile' => 'EXT:fp_masterquiz/Resources/Public/Icons/tx_fpmasterquiz_domain_model_question.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, title, qmode, image, bodytext, explanation, tag, span, optional, answers,
         --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime, closed,
         --div--;LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tabs.categories, categories'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_fpmasterquiz_domain_model_question',
                'foreign_table_where' => 'AND {#tx_fpmasterquiz_domain_model_question}.{#pid}=###CURRENT_PID### AND {#tx_fpmasterquiz_domain_model_question}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
    	'sorting' => [
    		'label' => 'sorting',
    		'config' => [
    			'type' => 'passthrough'
    		]
    	],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'qmode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.0', 'value' => 0],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.1', 'value' => 1],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.2', 'value' => 2],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.3', 'value' => 3],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.4', 'value' => 4],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.5', 'value' => 5],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.6', 'value' => 6],
					['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.7', 'value' => 7],
                    ['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.8', 'value' => 8]
                ],
                'size' => 1,
                'maxitems' => 1,
                'default' => 0,
                'eval' => ''
            ],
        ],
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.image',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types'
            ],
        ],
        'bodytext' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.bodytext',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            
        ],
        'explanation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.explanation',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'tag' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.tag',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '','value' => 0],
                ],
                'foreign_table' => 'tx_fpmasterquiz_domain_model_tag',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1
            ],
        ],
        'span' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.span',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled']
                ],
                'default' => 0
            ]
        ],
        'optional' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.optional',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled']
                ],
                'default' => 0
            ]
        ],
        'closed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.closed',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled']
                ],
                'default' => 0
            ]
        ],
        'answers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.answers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_answer',
                'foreign_field' => 'question',
                'foreign_sortby' => 'sorting',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'useSortable' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'quiz' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'categories' => [
            'config' => [
                'type' => 'category',
            ],
        ],
    ],
];