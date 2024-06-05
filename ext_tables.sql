#
# Table structure for table 'tx_fpmasterquiz_domain_model_quiz'
#
CREATE TABLE tx_fpmasterquiz_domain_model_quiz (

	name varchar(255) DEFAULT '' NOT NULL,
	about text,
	qtype int(11) DEFAULT '0' NOT NULL,
    timeperiod int(11) DEFAULT '0' NOT NULL,
	media int(11) unsigned NOT NULL default '0',
	questions int(11) unsigned DEFAULT '0' NOT NULL,
	evaluations int(11) unsigned DEFAULT '0' NOT NULL,
    closed smallint(5) unsigned DEFAULT '0' NOT NULL,
	path_segment varchar(2048),

	KEY path_segment (path_segment(185),uid)

);

#
# Table structure for table 'tx_fpmasterquiz_domain_model_question'
#
CREATE TABLE tx_fpmasterquiz_domain_model_question (

	quiz int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	qmode int(11) DEFAULT '0' NOT NULL,
	image int(11) unsigned NOT NULL default '0',
	bodytext text,
	explanation text,
    tag int(11) unsigned DEFAULT '0',
    span smallint(5) unsigned DEFAULT '0' NOT NULL,
    optional smallint(5) unsigned DEFAULT '0' NOT NULL,
    closed smallint(5) unsigned DEFAULT '0' NOT NULL,
	answers int(11) unsigned DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_fpmasterquiz_domain_model_answer'
#
CREATE TABLE tx_fpmasterquiz_domain_model_answer (

	question int(11) unsigned DEFAULT '0' NOT NULL,

	title text,
	points int(11) DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_fpmasterquiz_domain_model_evaluation'
#
CREATE TABLE tx_fpmasterquiz_domain_model_evaluation (

	quiz int(11) unsigned DEFAULT '0' NOT NULL,

	evaluate smallint(5) unsigned DEFAULT '0' NOT NULL,
	minimum double(11,2) DEFAULT '0.00' NOT NULL,
	maximum double(11,2) DEFAULT '0.00' NOT NULL,
	bodytext text,
	image int(11) DEFAULT '0' NOT NULL,
	ce int(11) DEFAULT '0' NOT NULL,
	page int(11) DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_fpmasterquiz_domain_model_participant'
#
CREATE TABLE tx_fpmasterquiz_domain_model_participant (

	name varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	homepage varchar(255) DEFAULT '' NOT NULL,
	user int(11) DEFAULT '0' NOT NULL,
	ip varchar(255) DEFAULT '' NOT NULL,
	session varchar(255) DEFAULT '' NOT NULL,
    sessionstart int(11) DEFAULT '0' NOT NULL,
    randompages varchar(255) DEFAULT '' NOT NULL,
	points int(11) DEFAULT '0' NOT NULL,
	maximum1 int(11) DEFAULT '0' NOT NULL,
	maximum2 int(11) DEFAULT '0' NOT NULL,
	completed smallint(5) unsigned DEFAULT '0' NOT NULL,
	page int(11) DEFAULT '0' NOT NULL,
	quiz int(11) unsigned DEFAULT '0',
	selections int(11) unsigned DEFAULT '0' NOT NULL,

	KEY tokenses (session)

);

#
# Table structure for table 'tx_fpmasterquiz_domain_model_selected'
#
CREATE TABLE tx_fpmasterquiz_domain_model_selected (

	participant int(11) unsigned DEFAULT '0' NOT NULL,

	points int(11) DEFAULT '0' NOT NULL,
	entered text,
	question int(11) unsigned DEFAULT '0',
	answers int(11) unsigned DEFAULT '0' NOT NULL,

	KEY frage (participant,question)

);

#
# Table structure for table 'tx_fpmasterquiz_domain_model_tag'
#
CREATE TABLE tx_fpmasterquiz_domain_model_tag (

    name varchar(255) DEFAULT '' NOT NULL,
    timeperiod int(11) DEFAULT '0' NOT NULL

);


CREATE TABLE tx_fpmasterquiz_domain_model_quiz (
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_fpmasterquiz_domain_model_question (
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_fpmasterquiz_domain_model_answer (
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_fpmasterquiz_domain_model_evaluation (
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_fpmasterquiz_domain_model_participant (
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_fpmasterquiz_domain_model_selected (
    categories int(11) unsigned DEFAULT '0' NOT NULL
);


#
# Table structure for table 'tx_fpmasterquiz_selected_answer_mm'
#
CREATE TABLE tx_fpmasterquiz_selected_answer_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
