.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration:

Konfigurationsreferenz
======================

Die Konfiguration ist über TypoScript und FlexForms möglich und einige Punkte
können beim Quiz in der Listenansicht konfiguriert werden.

Hier beschreibe ich nur die **TypoScript**-Einstellungen.

.. _configuration-typoscript:

TypoScript-Referenz
--------------------

Die TypoScript-Einstellungen können über den TypoScript-Object-Browser geändert werden.
tx_fpmasterquiz.view, tx_fpmasterquiz.persistence und persistence.features sind wie in anderen Erweiterungen.
Hier ist nur eine Liste der tx_fpmasterquiz.settings.
Wenn die Werte 0, 1 und 2 möglich sind, bedeutet
1: diese Funktion aktivieren,
2 bedeutet: diese Funktion aktivieren, aber nicht auf der letzten Seite.

Eigenschaften
^^^^^^^^^^

.. container:: ts-properties

============================ =========== =============================================== ==============================
Eigenschaft                  Datentyp    Beschreibung                                    Default
============================ =========== =============================================== ==============================
startPageUid                 integer     UID der Seite für den Start (listPid).          -
showPageUid                  integer     UID der Detail-Seite eines Quiz (detailPid).    -
closurePageUid               integer     UID der Abschlußseite eines Quiz.               -
resultPageUid                integer     UID der Seite, wo Ergebnisse angezeigt werden.  -
highscorePageUid             integer     UID der Seite für einen Highscore.              -
defaultQuizUid               integer     UID vom Quiz, das angezeigt werden soll.        -
introContentUid              integer     Inhaltselement für die Intro-Seite.             -
introNextAction              string      Action nach der intro page: show oder showByTag show
showAnswerPage               boolean     Zeige eine Antwort-Seite nach jedem absenden?   1
showOwnAnswers               integer     Zeige die Antworten des Teilnehmers? 0,1 oder 2 2
showCorrectAnswers           integer     Zeige die richtigen Antworten? 0, 1 oder 2.     1
showEveryAnswer              integer     Zeige jede Antwortoption an? 0, 1 oder 2.       0
showAnswersAtFinalPage       boolean     Zeige Antworten+Lösungen auf der letzten Seite? 1
showAllAnswers               boolean     Zeige alle bisherigen Antworten am Ende an?     1
showPoints                   boolean     Zeige mögliche/erreichte Punkte (maximum>0)?    1
showPageNo                   boolean     Zeige die Seitennummer / Anzahl der Seiten an?  1
showQuestionNo               boolean     Zeige die Fragen-Nr. / Anzahl der Fragen an?    0
showDetailedCategoryEval     boolean     Zeige Kategorie-Auswertungen an, falls möglich? 0
groupByTag                   boolean     Gruppiere ein Quiz nach den benutzen Tags?      0
redirectToResultPageAtFinal  boolean     Leite zu einer Ergebnis-Seite am Ende?          0
checkAllStars                boolean     Markiere alle Sterne bei der Sternebewertung?   0
highscoreLimit               integer     Anzahl der Einträge beim Highscore.             10
resultLimit                  integer     Anzahl der Einträge bei Ergebnissen (layout=2). 20
pointsMode                   integer     Punkte für beantwort. Fragen: 0, 1, 2, 3 oder 4 0
noFormCheck                  boolean     Prüfe nicht, ob Fragen beantwortet wurden?      0
phpFormCheck                 boolean     Prüfe per PHP, ob Fragen beantwortet wurden?    0
allowEdit                    boolean     Zeige Links zu Seiten und erlaube Bearbeitung?  0
allowHtml                    boolean     Erlaube HTML bei Antworten?                     0
closed                       boolean     Quiz ist geschlossen (keine Teilnahme möglich)? 0
random                       boolean     Zufallsmodus? Funktioniert nur mit Tags.        0
joker                        boolean     Joker-Button? Funktioniert nur mit AJAX.        0
ajax                         boolean     AJAX-version* aktivieren?                       0
ajaxType                     string      POST oder GET verwenden?                        GET
setMetatags                  boolean     Setze Metatags und ändere den Titel?            0
includeRatingCSS             boolean     Inkludiere RatingStar.css via f:asset?          1
user.ipSave                  boolean     Speichere die IP-Adresse eines Teilnehmers?     1
user.ipAnonymous             boolean     Anonymisiere die IP-Adresse?                    1
user.useCookie               integer     Speichere die Session auch in einem Cookie.     0
user.useQuizPid              boolean     Benutze automatisch die PID vom Quiz?           0
user.checkFEuser             integer     Prüfe, ob ein FEuser schon teilgenommen hat?°   0
user.askForData              integer     Frage nach Benutzerdaten? 0, 1, 2 oder 3.       0
user.defaultName             string      Default user name ({TIME} wird ersetzt).        default {TIME}
user.defaultEmail            string      Default user email.                             -
user.defaultHomepage         string      Default user homepage.                          -
email.fromEmail              string      Abesender-E-Mail-Adresse.                       -
email.fromName               string      Abender-Name.                                   -
email.adminEmail             string      Admin E-Mail-Adressen separiert mit ,           -
email.adminName              string      Admin-Name.                                     -
email.adminSubject           string      Betreff der Admin-E-Mail.                       New poll/quiz-result
email.userSubject            string      Betreff der Benutzer-E-Mail.                    Your poll/quiz-result
email.sendToAdmin            boolean     Sende am Schluß eine E-Mail an den Admin?       0
email.sendToUser             boolean     Sende am Schluß eine E-Mail an den Benutzer?    0
email.specific               string      Sende E-Mails an spezifische Admins?            -
email.likeFinalPage          boolean     E-Mail-Inhalt wie auf der Schlußseite?          0
pagebrowser.itemsPerPage     integer     Anzahl der Fragen pro Seite.                    1
pagebrowser.insertAbove      boolean     Wird nicht benötigt.                            0
pagebrowser.insertBelow      boolean     Wird nicht benötigt.                            0
pagebrowser.maximumNum...    integer     Wird nicht benötigt.                            50
template.colText             string      Klasse für eine Frage mit Antworten.            col-md-8
template.colImage            string      Klasse fürs Bild einer Frage.                   col-md-4
template.col12               string      Klasse für Antworten ohne Bild.                 col-12
template.wrapQuizTitle1      string      Wrap für den Quiz-Titel.                        <h2>
template.wrapQuizTitle2      string      Wrap für den Quiz-Titel.                        </h2>
template.wrapQuizDesc1       string      Wrap für die Quiz-Beschreibung.                 <h3>
template.wrapQuizDesc2       string      Wrap für die Quiz-Beschreibung.                 </h3>
template.wrapTagName1        string      Wrap für den Tag-Namen.                         <h4>
template.wrapTagName2        string      Wrap für den Tag-Namen.                         </h4>
template.wrapQuestionTitle1  string      Wrap für den Fragen-Titel.                      <legend><div class="mx-auto">
template.wrapQuestionTitle2  string      Wrap für den Fragen-Titel.                      </div></legend>
template.wrapQuestionDesc1   string      Wrap für die Fragen-Beschreibung.               <div class="mx-auto">
template.wrapQuestionDesc2   string      Wrap für die Fragen-Beschreibung.               </div>
template.wrapDone1           string      Wrap für die Fertig-Meldung am Schluß.          <h4>
template.wrapDone2           string      Wrap für die Fertig-Meldung am Schluß.          </h4>
template.optionalMark        string      Kennzeichen für optionale Fragen, Z.B. *.       -
chart.type                   string      Chart-Typen: pie, donut oder bar.               pie
chart.width                  integer     Breite des Chart.                               492
templateLayout               integer     Template-Layout. Siehe PageTSconfig**.          -
overrideFlexformSettings...  string      Überschreibe diese Felder, falls sie leer sind. startPageUid,...
debug                        integer     Debug-Modus? 0: nein; 1: in HTML; 2: via Datei. 0
typeNum                      integer     Typ des AJAX-calls. Nicht ändern!               190675
============================ =========== =============================================== ==============================

AJAX*) Wenn man AJAX aktiviert, sollte man folgendes wissen:

- Die FlexForms werden ignoriert, da der AJAX-Aufruf das Plugin nicht kennt.

- **Konfiguriere das Quiz nur per TypoScript**.
  Auch die persistence.storagePid muss gesetzt werden!

- Es ist nur eine Frage pro Seite möglich.

- Die AJAX-Lösung wird für die Aktion „Nach Tag anzeigen“ nicht unterstützt.

- *Wichtig*: Der AJAX-Aufruf ruft eine normale Aktion und kein eID-Skript auf.
  Das Problem ist, dass das Formular keinen cHash enthält.
  Daher muss die cHash-Anforderung im Installationstool deaktiviert werden:
  [FE][cacheHash][enforceValidation] = false
  Wenn es immer noch nicht funktioniert, kann man die cHash-Prüfung im Installationstool deaktivieren:
  [FE][pageNotFoundOnCHashError] = false
  Fazit: Verwende die Ajax-Version nur, wenn sie wirklich benötigt wird.

- *Wichtig*: Wenn das Plugin
  "Ein bestimmtes Quiz anzeigen und den Pagebrowser verwenden (Sie müssen auch den Speicherordner auswählen)" /
  "Ein bestimmtes Quiz anzeigen und den Pagebrowser nutzen (Datensatzsammlung muss dennoch gewählt werden)" nicht verwenden,
  müssen Sie diesen TypoScript-Wert ändern: "ajaxfpmasterquiz_page.10.pluginName".
  Stellen Sie ihn auf "Liste" oder "Intro" ein (je nach ausgewähltem Plugin).

- Das Speichern von Benutzerdaten (auf der letzten Seite) funktioniert nicht.

- Sie haben immer noch Probleme? Dann lesen Sie das Kapitel "Bekannte Probleme".

Layout**) Wenn Sie das Template-Layout 1 verwenden, sollten Sie Folgendes wissen:

- Die Diagrammeinstellungen werden ignoriert, wenn Sie ein anderes Layout verwenden.

- Die ApexCharts werden automatisch verwendet. Weitere Informationen: https://apexcharts.com/

feusers°) Wenn Sie für user.checkFEuser einen Wert größer als 1 verwenden, kann ein Teilnehmer mehr als einmal teilnehmen.

Wenn Sie den Wert auf 4 setzen, sind 4 Teilnahmen zulässig (nicht im Ajax-Modus getestet).

Hinweis: Wenn Sie eine Cookie- oder FEuser-Prüfung aktivieren, kann ein Benutzer nicht erneut abstimmen, wenn er bereits abgestimmt/teilgenommen hat.
Der Teilnehmer sieht sein Ergebnis einer Umfrage/eines Quiz anstelle der Kontrollkästchen/Optionsfelder.

Hinweis: Lesen Sie das Kapitel „Benutzerhandbuch“ für weitere Informationen zu diesen Eigenschaften/Einstellungen.

Hinweis: Die Seitenbrowser-Einstellungen werden ignoriert, wenn Sie die Aktion „Nach Tag anzeigen“ verwenden.

Hinweis: - bedeutet: kein Standardwert.

Beispiele:
^^^^^^^^^^

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

If you enable this feature, links to all pages of a quiz are shown, so an user can edit their answers.
Note: this works only for the action "show by tag" and questions of type radio, checkbox or text.
Note: this feature disables the answer-page!
Note: set allowEdit = 2, if participants should be able to edit even a completed quiz/poll.


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


.. _pointsMode:

pointsMode
""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.pointsMode = 1`

In the default mode, negative points are possible at e.g. checkboxes when not all correct answers are checked.
pointsMode=1: negative points will be set to 0 points.
pointsMode=3: like pointsMode=1, but when not all correct answers are selected, the participant will get 0 points for
the whole question instead of x/y points.
pointsMode=4: like pointsMode=3, but when all answers are answered correct, only 1 point will be given, else 0.


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
Note furthermore: if enabling the cookies, these cookies will be saved: qsessionXX. XX is the quiz-ID.
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


.. _text:

Text
""""

You can change the text (of buttons) like this::

  plugin.tx_fpmasterquiz._LOCAL_LANG.de {
    text.answer.input = Eingabe:
    text.answer.textarea = Kommentar:
    text.goon = weiter
    text.gofinal = Beenden
    text.showResultPage = Ergebnisse
    text.showHighscorePage = Highscore
    text.optional = optionale Frage
  }


.. _debug:

Debug
"""""

:typoscript:`plugin.tx_fpmasterquiz.settings.debug = 2`

If debug = 1, a debug output will be shown under the quiz/poll-output in the FE.
If debug = 2, the debug output will be written in a log file called var/log/typo3_fpmasterquiz_*.log


.. _configuration-faq:

FAQ
---

- What about the evaluation of a quiz?

  This can be configured at every quiz.

- Optional questions are not marked. Why not?

  You need to define the mark-symbol by yourself via the TypoScript-setting. E.g. settings.template.optionalMark = *.

- Closed is a checkbox at a quiz-entry (tab Access). Why is it a setting too?

  Because with this 2 possibilities you can easy define if one or more quizzes shall be closed.

- The text changes to english when I activate Ajax. Whats wrong?

  You need to add some more TypoScript to your page. See chapter "Known problems".

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   PageTSconfig/Index
   Routing/Index
