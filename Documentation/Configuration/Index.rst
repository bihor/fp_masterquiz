.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration Reference
=======================

Configuration is possible via TypoScript, FlexForms and some points can be configured at the quiz in the list view.

Here I will describe the **TypoScript** settings only.


.. _configuration-typoscript:

TypoScript Reference
--------------------

The TypoScript settings can be changed via the TypoScript-Object-Browser. tx_fpmasterquiz.view, tx_fpmasterquiz.persistence
and persistence.features are like in other extensions. Here is only a list of the tx_fpmasterquiz.settings.


Properties
^^^^^^^^^^

.. container:: ts-properties

	=========================== =========== ============================================== ==========================
	Property                    Data type   Description                                    Default
	=========================== =========== ============================================== ==========================
	startPageUid                integer     UID of the page where the quiz beginns.        1
	defaultQuizUid              integer     UID of the quiz to show.                       1
	showAnswerPage              boolean     Show an answer page after every submit?        1
	showAnswersAtFinalPage      boolean     Show solutions at the final page?              0
	showOwnAnswers              boolean     Show the answers of the quiz taker?            1
	showCorrectAnswers          boolean     Show the correct answers?                      1
	showAllAnswers              boolean     Show finally all answers (no. of choices)?     0
	showPoints                  boolean     Show the possible/reached points?              1
	allowHtml                   boolean     Allow HTML at question-answers from the BE?    0
	ajax                        boolean     Enable the AJAX-version* of the quiz?          0
	user.ipSave                 boolean     Save the IP-address of a user?                 1
	user.ipAnonymous            boolean     Anonymize the IP-address?                      1
	user.askForData             boolean     Ask for user data at the first page of a quiz? 0
	user.defaultName            string      Default user name ({TIME} will be replaced).   default {TIME}
	user.defaultEmail           string      Default user email.
	user.defaultHomepage        string      Default user homepage.
	pagebrowser.itemsPerPage    integer     Number of questions on a page.                 1
	pagebrowser.insertAbove     boolean     You don´t need this.                           0
	pagebrowser.insertBelow     boolean     You don´t need this.                           0
	pagebrowser.maximumNum...   integer     You don´t need this.                           50
	template.colText            string      Class for a question with answers.             col-md-8
	template.colImage           string      Class for the image of a question.             col-md-4
	template.wrapQuizTitle1     string      Wrap for the quiz title.                       <h2>
	template.wrapQuizTitle2     string      Wrap for the quiz title.                       </h2>
	template.wrapQuizDesc1      string      Wrap for the quiz description.                 <h3>
	template.wrapQuizDesc2      string      Wrap for the quiz description.                 </h3>
	template.wrapQuestionTitle1 string      Wrap for the question title.                   <div class="mx-auto"><h4>
	template.wrapQuestionTitle2 string      Wrap for the question title.                   </h4></div>
	template.wrapQuestionDesc1  string      Wrap for the question description.             <div class="mx-auto">
	template.wrapQuestionDesc2  string      Wrap for the question description.             </div>
	template.wrapDone1          string      Wrap for the done-msg at the final page.       <h4>
	template.wrapDone2          string      Wrap for the done-msg at the final page.       </h4>
	templateLayout              integer     See in chapter PageTSconfig.
	overrideFlexformSettings... string      Fields that should be overwritten if empty.    startPageUid,...
	debug                       boolean     Show debug data at the page.                   0
	typeNum                     integer     Type of the AJAX-call. Don´t change it.        190675
	=========================== =========== ============================================== ==========================

AJAX*) If you enable AJAX, you should know this:

  - The FlexForms will be ignored, because the AJAX-call does not know the plugin.

  - **Configure the quiz only by TypoScript**.

  - The AJAX-call calls an normal action and not an eID-script. Therefore it is necessary to set this TypoScript: 
    plugin.tx_fpmasterquiz.features.requireCHashArgumentForActionArguments = 0 
    This is set by default. You can change the value to 1, if you do not use the AJAX-version.
    If it is still not working, you can disable the cHash-check in the install tool: 
    [FE][pageNotFoundOnCHashError] = false


Examples:
^^^^^^^^^

.. only:: html

	.. contents::
		:local:
		:depth: 1


.. _pagebrowser.itemsPerPage:

itemsPerPage
""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.pagebrowser.itemsPerPage = 2`

Show 2 questions per page.


.. _user.defaultName:

defaultName
"""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.user.defaultName = User {TIME}`

Every quiz-taker gets a name in the database. If "user.askForData=0" then this name will be used. {TIME} will
be replaced by date and time.


.. _showAnswerPage:

showAnswerPage
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.showAnswerPage = 0`

No answer page will be shown after every submit.


.. _Poll:

Poll
""""

With this TypoScript you can configure a simple poll with a pie chart as result::

  plugin.tx_fpmasterquiz.persistence.storagePid = 279
  plugin.tx_fpmasterquiz.settings.startPageUid = 279
  plugin.tx_fpmasterquiz.settings.defaultQuizUid = 9
  plugin.tx_fpmasterquiz.settings.showAnswerPage = 0
  plugin.tx_fpmasterquiz.settings.showAnswersAtFinalPage = 1
  plugin.tx_fpmasterquiz.settings.showCorrectAnswers = 0
  plugin.tx_fpmasterquiz.settings.showAllAnswers = 1
  plugin.tx_fpmasterquiz.settings.showPoints = 0
  plugin.tx_fpmasterquiz.settings.templateLayout = 1
  plugin.tx_fpmasterquiz.settings.template.wrapDone1 = <div class="hidden">
  plugin.tx_fpmasterquiz.settings.template.wrapDone2 = </div>

.. _configuration-faq:

FAQ
---

- What about the evaluation of a quiz?

  This can be configured at every quiz.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   PageTSconfig/Index
