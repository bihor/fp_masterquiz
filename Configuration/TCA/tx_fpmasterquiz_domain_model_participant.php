<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'searchFields' => 'name,email,homepage,user,ip,session,points,maximum1,maximum2,quiz,selections',
        'iconfile' => 'EXT:fp_masterquiz/Resources/Public/Icons/tx_fpmasterquiz_domain_model_participant.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, email, homepage, user, ip, session, sessionstart, randompages, points, maximum1, maximum2, page, completed, quiz, selections,
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
                'foreign_table' => 'tx_fpmasterquiz_domain_model_participant',
                'foreign_table_where' => 'AND {#tx_fpmasterquiz_domain_model_participant}.{#pid}=###CURRENT_PID### AND {#tx_fpmasterquiz_domain_model_participant}.{#sys_language_uid} IN (-1,0)',
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

        'tstamp' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'homepage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.homepage',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'user' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.user',
            'config' => [
				'type' => 'group',	
				'allowed' => 'fe_users',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
                'default' => 0
			],
        ],
        'ip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.ip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'session' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.session',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'sessionstart' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.sessionstart',
            'config' => [
                'type' => 'number',
                'size' => 4
            ]
        ],
        'randompages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.randompages',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'points' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.points',
            'config' => [
                'type' => 'number',
                'size' => 4
            ]
        ],
        'maximum1' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.maximum1',
            'config' => [
                'type' => 'number',
                'size' => 4
            ]
        ],
        'maximum2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.maximum2',
            'config' => [
                'type' => 'number',
                'size' => 4
            ]
        ],
    	'page' => [
    		'exclude' => true,
    		'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.page',
    		'config' => [
    			'type' => 'number',
    			'size' => 4
    		]
    	],
        'completed' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.completed',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0
            ]
        ],
        'quiz' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.quiz',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_quiz',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0
            ],
        ],
        'selections' => [
            'exclude' => true,
            'label' => 'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_db.xlf:tx_fpmasterquiz_domain_model_participant.selections',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_fpmasterquiz_domain_model_selected',
                'foreign_field' => 'participant',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'categories' => [
            'config' => [
                'type' => 'category',
            ],
        ],
    ],
];