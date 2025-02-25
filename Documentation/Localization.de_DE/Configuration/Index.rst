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

- *Wichtig*: die Ajax-Version funktioniert mit Version 7 wegen eines TYPO3-Bug nicht mehr:
  https://forge.typo3.org/issues/105135

- *Wichtig*: Der AJAX-Aufruf ruft eine normale Aktion und kein eID-Skript auf.
  Das Problem ist, dass das Formular keinen cHash enthält.
  Daher muss die cHash-Anforderung im Installationstool deaktiviert werden:
  [FE][cacheHash][enforceValidation] = false
  Wenn es immer noch nicht funktioniert, kann man die cHash-Prüfung im Installationstool deaktivieren:
  [FE][pageNotFoundOnCHashError] = false
  Fazit: Verwende die Ajax-Version nur, wenn sie wirklich benötigt wird.

- *Wichtig*: Wenn man nicht das Plugin
  "Show a selected quiz and use a pagebrowser (you need to select the storage folder too)" /
  "Ein bestimmtes Quiz anzeigen und den Pagebrowser nutzen (Datensatzsammlung muss dennoch gewählt werden)",
  verwendet, muss man diesen TypoScript-Wert ändern: "ajaxfpmasterquiz_page.10.pluginName".
  Stell ihn auf "List" oder "Intro" ein (je nach ausgewähltem Plugin).

- Das Speichern von Benutzerdaten (auf der letzten Seite) funktioniert nicht.

- Es gibt weitere Probleme? Dann lies noch das Kapitel "Bekannte Probleme".

Layout**) Wenn man das Template-Layout 1 verwendet, sollte man folgendes wissen:

- Die Diagrammeinstellungen werden ignoriert, wenn man ein anderes Layout verwendet.

- Die ApexCharts werden automatisch verwendet. Weitere Informationen: https://apexcharts.com/

feusers°) Wenn man für user.checkFEuser einen Wert größer als 1 verwendet, kann ein Teilnehmer mehr als einmal teilnehmen.
Wenn man den Wert auf 4 setzt, sind 4 Teilnahmen zulässig (nicht im Ajax-Modus getestet).

Hinweis: Wenn man eine Cookie- oder FEuser-Prüfung aktiviert, kann ein Benutzer nicht erneut abstimmen,
wenn er bereits abgestimmt/teilgenommen hat.
Der Teilnehmer sieht sein Ergebnis einer Umfrage/eines Quiz anstelle der Kontrollkästchen/Optionsfelder.

Hinweis: Lies das Kapitel „Benutzerhandbuch“ für weitere Informationen zu diesen Eigenschaften/Einstellungen.

Hinweis: Die Seitenbrowser-Einstellungen werden ignoriert, wenn man die Aktion „Nach Tag anzeigen“ verwendet.

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

Zeigt 2 Fragen pro Seite an.


.. _user.defaultName:

defaultName
"""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.user.defaultName = User {TIME}`

Jeder Quizteilnehmer erhält einen Namen in der Datenbank.
Wenn "user.askForData=0" ist, wird dieser Name verwendet. {TIME} wird durch Datum und Uhrzeit ersetzt.
Wenn "user.checkFEuser=1" ist, wird der Name des FE-Benutzers verwendet.


.. _showAnswerPage:

showAnswerPage
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.showAnswerPage = 0`

Nach jedem Absenden wird keine Antwortseite angezeigt. Die nächste(n) Frage(n) werden angezeigt.


.. _showEveryAnswer:

showEveryAnswer
"""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.showEveryAnswer = 2`

Auf einer Antworten-Seite (nach jedem Absenden) werden alle Antworten wie auf der Seite davor angezeigt.
Zusätzlich werden die richtigen Antworten grün und die falsch beantworteten Antworten rot markiert.
Wenn der Wert auf 2 gesetzt ist, werden diese Antworten auf der letzten Seite nicht angezeigt.
Andernfalls werden sie auch auf der letzten Seite angezeigt, wenn showAnswersAtFinalPage auf 1 gesetzt ist.
Hinweis: Dies wurde nur mit Kontrollkästchen und Optionsfeldern getestet!


.. _allowEdit:

allowEdit
"""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.allowEdit = 1`

Wenn man diese Funktion aktiviert, werden Links zu allen Seiten eines Quiz angezeigt,
sodass ein Benutzer seine Antworten bearbeiten kann.
Hinweis: Dies funktioniert nur für die Aktion „Nach Tag anzeigen“ und Fragen vom Typ „Radio“, „Kontrollkästchen“ oder „Text“.
Hinweis: Diese Funktion deaktiviert die Antwortseite!
Hinweis: Setze allowEdit = 2, wenn Teilnehmer auch ein abgeschlossenes Quiz/Umfrage bearbeiten können sollen.


.. _random:

random
""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.random = 1`

Wenn man diese Funktion aktiviert, werden die Tags neu sortiert. Die geänderte Reihenfolge wird auch in der Datenbank gespeichert.
Hinweis: Dies funktioniert nur bei der Aktion „Nach Tag anzeigen“, da Tags und nicht Fragen zufällig sortiert werden.


.. _noFormCheck:

noFormCheck
"""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.noFormCheck = 1`

Normalerweise muss jede Frage beantwortet werden, bevor die Seite gesendet werden kann.
Man kann diese Prüfung generell deaktivieren.
Seit Version 3.2.0 kann man bei jeder Frage angeben, ob sie optional sein soll oder nicht.
Hinweis: Es werden nur Fragen vom Typ Radio, Kontrollkästchen, Auswahlfeld, Eingabefeld und Textbereich geprüft.
Alle Antworten auf andere Arten von Fragen sind optional (sie werden nicht geprüft).


.. _pointsMode:

pointsMode
""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.pointsMode = 1`

Im Standardmodus sind Minuspunkte z. B. bei Checkboxen möglich, wenn nicht alle richtigen Antworten angekreuzt sind.

pointsMode=1: Minuspunkte werden auf 0 Punkte gesetzt.

pointsMode=3: wie pointsMode=1, aber wenn nicht alle richtigen Antworten angekreuzt sind, bekommt der Teilnehmer für
die ganze Frage 0 Punkte statt x/y Punkte.

pointsMode=4: wie pointsMode=3, aber wenn alle Antworten richtig beantwortet sind, wird nur 1 Punkt vergeben, sonst 0.


.. _joker:

joker
"""""

:typoscript:`plugin.tx_fpmasterquiz.settings.joker = 1`

Mit dieser Einstellung kann ein 50:50-Joker aktiviert werden. Dies funktioniert nur, wenn auch "ajax = 1" gesetzt ist!
Der Joker verwendet alle Antworten mit Punkten größer als 0. Die restlichen Antworten werden vom Joker zufällig ausgewählt.
Man kann im Backend nicht festlegen, welche Antworten der Joker anzeigen soll.
Wenn die Anzahl der Antworten ungerade ist, funktioniert es folgendermaßen:
Bei 5 Antworten werden 3 Antworten vom Joker deaktiviert / der Joker blendet zufällig 2 falsche Antworten aus.
Die deaktivierten Antworten werden durch Setzen der Klasse "d-none" ausgeblendet.
Man kann "d-none" in der Partial Question/Properties.html durch etwas anderes ersetzen.
Dies funktioniert nur mit Radio-Buttons und Kontrollkästchen!
Wenn ein Joker verwendet wird, erhält der Benutzer nur die Hälfte der Punkte.
Die halben Punkte werden aufgerundet, daher sollten die Punkte nicht auf 1 gesetzt werden.
2 oder 10 sind ein besserer Wert, wenn man diesen Joker verwendet.


.. _setMetatags:

setMetatags
"""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.setMetatags = -1`

Dadurch werden zumindest die Metatags Beschreibung, og:description und og:title festgelegt und der Titel der Seite geändert.
Verwendete Werte: Name und Beschreibung eines Quiz. Dies funktioniert nur in einer Einzelansicht eines Quiz.


.. _user.useCookie:

user.useCookie
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.user.useCookie = -1`

Eine Session kann in einem Cookie gespeichert werden, damit ein Benutzer später mit einem Quiz fortfahren kann.
Das bedeutet sogar, dass ein Benutzer kein Quiz oder keine Umfrage zweimal durchführen kann!
-1 bedeutet: das Cookie wird gespeichert, bis der Browser geschlossen wird.
1 und höher bedeutet: ein Cookie wird für X Tage gespeichert.
Bitte beachten: Sessions und Cookies funktionieren nicht, wenn Ajax aktiviert ist.
Sie werden derzeit in der Ajax-Version nicht unterstützt.
Beachte außerdem: Wenn man die Cookies aktiviert, werden diese Cookies gespeichert: qsessionXX. XX ist die Quiz-ID.
Diese Cookies sind nicht schlecht! Man braucht dafür keine Cookie-Leiste,
aber man muss auf der DSGVO-Seite darüber informieren.


.. _user.askForData:

user.askForData
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.user.askForData = 3`

Es stehen 4 Optionen zur Verfügung: 0, 1, 2 oder 3.
0 bedeutet: keine Abfrage von Benutzerdaten wie Name oder E-Mail.
Die anderen Werte aktivieren ein Formular, das den Benutzer nach diesen Daten fragt: Name, E-Mail und Homepage.
1: Das Formular erscheint auf der ersten Seite eines Quiz.
2: Das Formular erscheint auf der Einführungsseite.
3: Das Formular erscheint auf der letzten Seite eines Quiz. Hinweis: In diesem Fall muss auch eine Abschlussseite definiert sein!
Einstellung: closurePageUid. Das Formular von der letzten Seite leitet auf diese Seite weiter. Hinweis: Dies funktioniert nicht in der AJAX-Version.


.. _email.specific:

email.specific
""""""""""""""

:typoscript:`plugin.tx_fpmasterquiz.settings.email.specific = {"116":{"415":{"email":"green@test.de","name":"Grün","subject":"Lieblingsfarbe ist grün!"},"416":{"email":"red@test.de","name":"Rot","subject":"Lieblingsfarbe ist rot!"}}}`

Bei konkreter Antwort eine E-Mail an unterschiedliche Empfänger senden? Kann als JSON-Objekt gesetzt werden:

{"question_uid":{"answer_uid":{"email":"E-mail 1","name":"Name 1","subject":"Subject 1"},"answer_uid":{"email":"E-mail 2","name":"Name 2","subject":"Subject 2"}}}

Alle Werte sind Pflichtfelder. Achten Sie auf die korrekte Verwendung der Anführungszeichen (")!

Beispiel-Frage: "Frage 1: Lieblingsfarbe" (question_id in the DB: 116), Answer 1: blau (answer_id in the DB: 414), Answer 2 (answer_id in the DB: 415): grün, Answer 3: rot (answer_id in the DB: 416)

Beispiel JSON-Objekt: {"116":{"415":{"email":"green@test.de","name":"Grün","subject":"Lieblingsfarbe ist grün!"},"416":{"email":"red@test.de","name":"Rot","subject":"Lieblingsfarbe ist rot!"}}}

Man kann das Objekt für jede Antwort erweitern: {"12":{"2":{…},"3":{…}},13:{"1":{…},"5":{…}}}

Hinweis: Dies funktioniert nur, wenn „email.sendToAdmin = 1“ ist.
Wenn auch „email.adminEmail“ festlegt, erhalten auch zusätzliche Administratoren die E-Mail.


.. _Poll:

Umfrage
"""""""

Mit diesem TypoScript kann man eine einfache Umfrage mit einem Kreisdiagramm als Ergebnis konfigurieren::

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

Man kann den Text (der Schaltflächen/Buttons) wie folgt ändern::

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

Wenn debug = 1, wird eine Debug-Ausgabe unter der Quiz-/Umfrage-Ausgabe im FE angezeigt.
Wenn debug = 2, wird die Debug-Ausgabe in eine Protokolldatei namens var/log/typo3_fpmasterquiz_*.log geschrieben.


.. _configuration-faq:

FAQ
---

- Wie sieht es mit der Bewertung eines Quiz aus?

  Dies kann bei jedem Quiz konfiguriert werden.

- Optionale Fragen werden nicht markiert. Warum nicht?

  Man muss das Markierungssymbol selbst über die TypoScript-Einstellung definieren. Z. B. settings.template.optionalMark = *.

- Geschlossen ist ein Kontrollkästchen bei einem Quizeintrag (Registerkarte Access). Warum ist das auch eine Einstellung?

  Weil man mit diesen beiden Möglichkeiten einfach festlegen kann, ob ein oder mehrere Quizze geschlossen werden sollen.

- Der Text ändert sich auf Englisch, wenn ich Ajax aktiviere. Was ist falsch?

  Man muss der Seite noch etwas TypoScript hinzufügen. Siehe Kapitel „Bekannte Probleme“.

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   PageTSconfig/Index
   Routing/Index
