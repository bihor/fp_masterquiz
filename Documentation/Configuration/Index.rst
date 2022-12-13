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
If values 0, 1 and 2 are possible, 1 means: enable this feature, 2 means: enable this feature, but not on the final page.


Properties
^^^^^^^^^^

.. container:: ts-properties

============================ =========== =============================================== ===========================
Property                     Data type   Description                                     Default
============================ =========== =============================================== ===========================
startPageUid                 integer     UID of the page where to restart (listPid).     -
showPageUid                  integer     UID of the single-page of a quiz (detailPid).   -
closurePageUid               integer     UID of a closure-page of a quiz.                -
resultPageUid                integer     UID of the page where to show quiz results.     -
highscorePageUid             integer     UID of the page where to show a highscore.      -
defaultQuizUid               integer     UID of the quiz to show.                        -
introContentUid              integer     Content element for the intro page.             -
introNextAction              string      Action after the intro page: show or showByTag. show
showAnswerPage               boolean     Show an answer page after every submit?         1
showOwnAnswers               integer     Show the answers of the quiz taker? 0,1 or 2.   2
showCorrectAnswers           integer     Show the correct answers? 0, 1 or 2.            1
showEveryAnswer              integer     Show every answer? 0, 1 or 2 (see below).       0
showAnswersAtFinalPage       boolean     Show answers with solutions at the final page?  1
showAllAnswers               boolean     Show finally all answers (no. of choices)?      1
showPoints                   boolean     Show the possible/reached points if maximum>0?  1
showPageNo                   boolean     Show the page number / number of pages?         1
showQuestionNo               boolean     Show the question no. / no. of questions?       0
showDetailedCategoryEval     boolean     Show detailed category evaluation if available? 0
checkAllStars                boolean     Check all stars on star rating by default?      0
highscoreLimit               integer     Number of entries in the highscore              10
noFormCheck                  boolean     Don´t check for answered questions at all?      0
phpFormCheck                 boolean     Enable check for answered questions with PHP?   0
allowEdit                    boolean     Show links to pages and allow to edit answers?  0
allowHtml                    boolean     Allow HTML at question-answers from the BE?     0
random                       boolean     Enable a random mode? Works only with tags.     0
joker                        boolean     Enable a joker-button? Works only with AJAX.    0
ajax                         boolean     Enable the AJAX-version* of the quiz?           0
ajaxType                     string      POST or GET                                     GET
setMetatags                  boolean     Set some metatags and change the title?         0
includeRatingCSS             boolean     Include the RatingStar.css via f:asset?         1
user.ipSave                  boolean     Save the IP-address of a user?                  1
user.ipAnonymous             boolean     Anonymize the IP-address?                       1
user.useCookie               integer     Save the session in a cookie too? See below.    0
user.useQuizPid              boolean     Use automatically the pid from the quiz?        0
user.checkFEuser             boolean     Check if a FEuser has already participated?     0
user.askForData              integer     Ask for user data? 0, 1, 2 or 3 (see below).    0
user.defaultName             string      Default user name ({TIME} will be replaced).    default {TIME}
user.defaultEmail            string      Default user email.                             -
user.defaultHomepage         string      Default user homepage.                          -
email.fromEmail              string      Your email-address.                             -
email.fromName               string      Your name.                                      -
email.adminEmail             string      Admin email-address.                            -
email.adminName              string      Admin name.                                     -
email.adminSubject           string      Subject of the admin-email.                     New poll/quiz-result
email.userSubject            string      Subject of the email to the user.               Your poll/quiz-result
email.sendToAdmin            boolean     Send an email to the admin at the final page?   0
email.sendToUser             boolean     Send an email to the user at the final page?    0
email.specific               string      Send email to specific admins (see below)?      -
email.likeFinalPage          boolean     Handle the email like a final page?             0
pagebrowser.itemsPerPage     integer     Number of questions on a page.                  1
pagebrowser.insertAbove      boolean     You don´t need this.                            0
pagebrowser.insertBelow      boolean     You don´t need this.                            0
pagebrowser.maximumNum...    integer     You don´t need this.                            50
template.colText             string      Class for a question with answers.              col-md-8
template.colImage            string      Class for the image of a question.              col-md-4
template.col12               string      Class for the text of a question; if no image.  col-12
template.wrapQuizTitle1      string      Wrap for the quiz title.                        <h2>
template.wrapQuizTitle2      string      Wrap for the quiz title.                        </h2>
template.wrapQuizDesc1       string      Wrap for the quiz description.                  <h3>
template.wrapQuizDesc2       string      Wrap for the quiz description.                  </h3>
template.wrapTagName1        string      Wrap for the tag name.                          <h4>
template.wrapTagName2        string      Wrap for the tag name.                          </h4>
template.wrapQuestionTitle1  string      Wrap for the question title.                    <div class="mx-auto"><h4>
template.wrapQuestionTitle2  string      Wrap for the question title.                    </h4></div>
template.wrapQuestionDesc1   string      Wrap for the question description.              <div class="mx-auto">
template.wrapQuestionDesc2   string      Wrap for the question description.              </div>
template.wrapDone1           string      Wrap for the done-msg at the final page.        <h4>
template.wrapDone2           string      Wrap for the done-msg at the final page.        </h4>
template.optionalMark        string      You can define a string for optional questions. -
chart.type                   string      You can choose between: pie, donut or bar.      pie
chart.width                  integer     Width of the chart.                             492
templateLayout               integer     See in chapter PageTSconfig**.                  -
overrideFlexformSettings...  string      Fields that should be overwritten if empty.     startPageUid,...
debug                        boolean     Show debug data at the page.                    0
typeNum                      integer     Type of the AJAX-call. Don´t change it.         190675
============================ =========== =============================================== ===========================

AJAX*) If you enable AJAX, you should know this:

- The FlexForms will be ignored, because the AJAX-call does not know the plugin.

- **Configure the quiz only by TypoScript**.
  You need to set the persistence.storagePid too!

- The AJAX-solution is currently not supported in the action "show by tag".

- The AJAX-call calls an normal action and not an eID-script. Therefore it is necessary to set this TypoScript:
  plugin.tx_fpmasterquiz.features.requireCHashArgumentForActionArguments = 0
  This is set by default. You can change the value to 1, if you do not use the AJAX-version.
  If it is still not working, you can disable the cHash-check in the install tool:
  [FE][pageNotFoundOnCHashError] = false
  
- You have still problems? Then read the chapter "Known problems".

Layout**) If you use template layout 1, you should know this:

- The charts settings will be ignored if you use another layout.

- The ApexCharts will be used automatically. More information: https://apexcharts.com/

Note: if you enable a cookie or FEuser check, then an user cannot vote again, if he had already voted/participated.
The participant will see his result of a poll/quiz instead of the checkboxes/radio buttons.

Note: read the chapter "User manual" for more informations about this properties/settings.

Note: the pagebrowser-settings will be ignored if you use the "show by tag" action.

Note: - means: no default value.

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
be replaced by date and time. If "user.checkFEuser=1" then the name of the FE-user will be used.


.. _showAnswerPage:

showAnswerPage
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.showAnswerPage = 0`

No answers-page will be shown after every submit. The next question(s) will be shown.


.. _showEveryAnswer:

showEveryAnswer
"""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.showEveryAnswer = 2`

At an answers-page (after every submit) all answers are shown like on the page before.
Additionally the correct answers are marked green and wrong answered answers are marked red.
If set to 2, this answers are not shown at the final page.
Otherwise they are displayed at the final page too if showAnswersAtFinalPage is set to 1.
Note: this is tested only with checkboxes and radio buttons!


.. _allowEdit:

allowEdit
"""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.allowEdit = 1`

If you enable this feature, links to all pages of a quiz are shown, so user can edit their answers.
Note: this works only for the action "show by tag" and questions of type radio, checkbox or text.
Note: this feature disables the answer-page!


.. _random:

random
""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.random = 1`

If you enable this feature, the tags will be shuffled. The changed order will be saved in the DB too.
Note: this works only for the action "show by tag", because tags and not questions are randomized.


.. _noFormCheck:

noFormCheck
"""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.noFormCheck = 1`

Normally every question needs to be answered before the page can be send. You can disable this check generally.
Since version 3.2.0 you can define at each question if it should be optional or not.
Note: only question of type radio, checkbox, select-box, input-field and textarea are checked. All answers to other type of
questions are optional (they will not be checked).


.. _joker:

joker
"""""

:typoscript:`plugin.tx_fpmasterquiz.settings.joker = 1`

A 50:50 joker can be enabled with this setting. This works only, if you set "ajax = 1" too.
The joker will use all answers with points greater than 0. The rest of the answers will be selected randomly by the joker.
You can not set in the backend, which answers the joker should show. If the number of answers is odd, than it works like this:
with 5 answers 3 answers will be disabled by the joker / the joker will hide 2 wrong answers randomly.
The disabled answers will be hidden by setting the class "d-none". You could change "d-none" to something else in the Partial Question/Properties.html.
This works only with radio-buttons and check-boxes!
When a joker is used, the user gets only half of the points.
The half points will be rounded up, therefore you should not set points to 1. 2 or 10 is a better value if you use this joker.


.. _setMetatags:

setMetatags
"""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.setMetatags = -1`

This will set at least the metatags description, og:description, og:title and it will change the title of the page.
Used values: name and description of a quiz. This works only in a single view of a quiz. 


.. _user.useCookie:

user.useCookie
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.user.useCookie = -1`

A session can be stored in a cookie, so a user can continue later with a quiz.
This even means, that a user can not make a quiz or poll twice!
-1 means: the cookie will be stored until the browser is closed.
1 and greater means: a cookie will be stored for X days.
Please note: sessions and cookies are not working if you enable Ajax. They are currently not supported in the Ajax-version.
Note furthermode: if enabling the cookies, these cookies will be saved: qsessionXX. XX is the quiz-ID.
This cookies are not bad! You don´t need a cookie bar for it, but you need to tell about it at your GDPR-site.


.. _user.askForData:

user.askForData
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.user.askForData = 3`

4 options are available: 0, 1, 2 or 3. 0 means: don´t ask for user data like name oder email.
The other values enables a form, that ask the user for this data: name, email and homepage.
1: the form will appear at the first page of a quiz.
2: the form will appear at the intro page.
3: the form will appear at the final page of a quiz. Note: in this case you will need to define a closure page too!
Setting: closurePageUid. The form from the final page will redirect to this page. Note: this does not work in the AJAX version.


.. _email.specific:

email.specific
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.email.specific = {"116":{"415":{"email":"green@test.de","name":"Grün","subject":"Lieblingsfarbe ist grün!"},"416":{"email":"red@test.de","name":"Rot","subject":"Lieblingsfarbe ist rot!"}}}`

Send an email on specific answer? Can be set as an JSON-object:

{"question_uid":{"answer_uid":{"email":"E-mail 1","name":"Name 1","subject":"Subject 1"},"answer_uid":{"email":"E-mail 2","name":"Name 2","subject":"Subject 2"}}}

All values are mandatory. Take care to use correct quotes (")!

Example question: "Frage 1: Lieblingsfarbe" (question_id in the DB: 116), Answer 1: blau (answer_id in the DB: 414), Answer 2 (answer_id in the DB: 415): grün, Answer 3: rot (answer_id in the DB: 416)

Example JSON-object: {"116":{"415":{"email":"green@test.de","name":"Grün","subject":"Lieblingsfarbe ist grün!"},"416":{"email":"red@test.de","name":"Rot","subject":"Lieblingsfarbe ist rot!"}}}

You can extend the object for every answer: {"12":{"2":{…},"3":{…}},13:{"1":{…},"5":{…}}}

Note: this works only if "email.sendToAdmin = 1". If you set email.adminEmail too, then an additional admins gets the email too.


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

- Optional questions are not marked. Why not?

  You need to define the mark-symbol by yourself via the TypoScript-setting. E.g. settings.template.optionalMark = *.

- The text changes to english when I activate Ajax. Whats wrong?

  You need to add some more TypoScript to your page. See chapter "Known problems".

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   PageTSconfig/Index
   Routing/Index
