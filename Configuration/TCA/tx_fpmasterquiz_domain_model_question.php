<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
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
        'searchFields' => 'title,qmode,image,bodytext,explanation,answers',
        'iconfile' => 'EXT:fp_masterquiz/Resources/Public/Icons/tx_fpmasterquiz_domain_model_question.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, qmode, image, bodytext, explanation, tag, optional, answers, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
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
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
                'eval' => 'trim,required'
            ],
        ],
        'qmode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.0', 0],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.1', 1],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.2', 2],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.3', 3],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.4', 4],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.5', 5],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.6', 6],
					['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.7', 7],
                    ['LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.qmode.8', 8]
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
                    ['',0],
                ],
                'foreign_table' => 'tx_fpmasterquiz_domain_model_tag',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1
            ],
        ],
        'optional' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_question.optional',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled']
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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_fpmasterquiz_domain_model_question', 'categories');