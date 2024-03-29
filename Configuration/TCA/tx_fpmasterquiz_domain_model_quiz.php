<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz',
        'label' => 'name',
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
        'searchFields' => 'name,about,questions,evaluations',
        'iconfile' => 'EXT:fp_masterquiz/Resources/Public/Icons/tx_fpmasterquiz_domain_model_quiz.gif'
    ],
    'types' => [
        '1' => ['showitem' =>
            'sys_language_uid, l10n_parent, l10n_diffsource, name, path_segment, about, timeperiod, media, qtype,
         --div--;LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tabs.questions, questions,
         --div--;LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tabs.evaluations, evaluations,
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
                'foreign_table' => 'tx_fpmasterquiz_domain_model_quiz',
                'foreign_table_where' => 'AND {#tx_fpmasterquiz_domain_model_quiz}.{#pid}=###CURRENT_PID### AND {#tx_fpmasterquiz_domain_model_quiz}.{#sys_language_uid} IN (-1,0)',
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
        
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'path_segment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['name'],
                    'replacements' => [
                        '/' => '-',
						'[' => '',
                        ']' => '',
                        '(' => '',
                        ')' => ''
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'unique',
                'default' => ''
            ]
        ],
        'about' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.about',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 4,
                'eval' => 'trim'
            ]
        ],
        'timeperiod' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.timeperiod',
            'config' => [
                'type' => 'number',
                'size' => 4
            ]
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.media',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types'
            ],
        ],
        'qtype' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.qtype',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.qtype.0', 'value' => 0],
                    ['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.qtype.1', 'value' => 1],
                    ['label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.qtype.2', 'value' => 2]
                ],
                'size' => 1,
                'maxitems' => 1,
                'default' => 0,
                'eval' => ''
            ],
        ],
        'questions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.questions',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_question',
                'foreign_field' => 'quiz',
                'foreign_sortby' => 'sorting',
                'maxitems' => 999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'useSortable' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'evaluations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.evaluations',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_evaluation',
                'foreign_field' => 'quiz',
                'maxitems' => 999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'closed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_quiz.closed',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled']
                ],
                'default' => 0
            ]
        ],
        'categories' => [
            'config' => [
                'type' => 'category',
            ],
        ],
    ],
];