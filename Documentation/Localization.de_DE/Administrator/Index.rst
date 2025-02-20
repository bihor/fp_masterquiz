.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _admin-manual:

Administratorhandbuch
=====================

Hinweis 1: die wichtigsten Templates sind: Quiz/List.html, Quiz/Show.html, Quiz/ShowByTag.html und Quiz/ShowAjax.html.
Hinweis 2: entferne keine Klassen oder IDs, die mit „quiz“ beginnen,
da einige davon zur Validierung des Formulars verwendet werden!

.. _admin-installation:

Installation
------------

Die Extension kann per Erweiterungsmanager oder Composer installiert werden.
Eine Liste der Konfigurationsoptionen findet man im Kapitel Konfiguration.


.. _admin-variables:

Variablen eines Quiz
--------------------

Wenn man Templates ändern möchten, sollte man wissen, welche Variablen eines Quiz verfügbar sind.
Es gibt diese Abschnitte: Quiz, Frage, Antwort, Bewertung, Tag.
Das sind Variablen, die im Backend ausgefüllt werden.
Und es gibt diese benutzerbezogenen Abschnitte: Teilnehmer und Auswahl (Antworten eines Teilnehmers).

Ein Quiz hat diese Variablen:
name, about, timeperiod (in Sekunden), media, questions, questionsSortByTag, categories, evaluations,
maximum2 (maximale Punkte für ein Quiz), qtype (für Quiz, Umfrage oder Test) und closed.

Eine Frage hat diese Variablen:
title, qmode (Frage-Modus), image, bodytext, explanation, sorting, tag, answers, selectOptions, numberOfAnswers,
arrayOfAnswers, categories, categoriesArray, sortedCategoriesArray und closed.
Und außerdem:
maximum1 (maximale Punktezahl für eine Frage),
allAnswers (Anzahl aller Antworten/Stimmen - Kontrollkästchen/Checkbox einmal gezählt),
totalAnswers (Anzahl aller Antworten/Stimmen - alle Kontrollkästchen/Checkboxen gezählt),
textAnswers (Array mit eingegebenen Textantworten, nur im BE verfügbar).

Eine Antwort hat diese Variablen:
title, titleJS, points, jokerAnswer, onwAnswer (yes/no), ownCategoryAnswer
(hat 2 Schlüssel: 0 die UID und 1 den Titel),
allAnswers (Gesamtantworten aller Benutzer),
allPercent (Gesamtprozent aller Benutzer - Kontrollkästchen einmal gezählt),
totalPercent (Gesamtprozent aller Benutzer - alle Kontrollkästchen gezählt) und
categories.

Eine Bewertung hat folgende Variablen:
evaluate (Punkte (nicht markiert) oder Prozent (markiert) bewerten), minimum und maximum, image, bodytext,
ce (Inhaltselement-ID), page (Seiten-ID) und categories.
Hinweis: Wenn eine Kategorie markiert ist, sucht die Bewertung stattdessen nach Kategorien.
Die Kategorie der Antworten wird validiert.
Die Kategorie, die vom Teilnehmer am häufigsten verwendet wurde, wird übernommen.

Ein Tag hat folgende Variablen:
name, timeperiod (in Sekunden).

Ein Teilnehmer hat diese Variablen:
name, email, homepage, user (FE-user UID), username (FE-user username), ip, session, sessionstart, quiz, points,
maximum1 (maximale Punkte für die beantworteten Fragen), maximum2 (maximale Punkte für ein Quiz),
startdate, crdate, tstamp, datesNotEqual, timePassed, page (erreichte Seite), completed (Quiz abgeschlossen?),
selections (alle beantworteten Fragen), selectionsByTag (beantwortete Fragen eines Tags) und
sortedSelections (beantwortete Fragen, gut sortiert).

Eine Auswahl/Auswertung hat diese Variablen:
question, answers, sorting, points, maximumPoints (maximale Punkte für diese Frage), entered (eingegebener Text zu dieser Frage)
und categories.

.. _admin-configuration:

Benutzerergebnisse
------------------

* Derzeit werden alle Benutzerergebnisse in der Datenbank gespeichert.
  Es gibt ein Sitzungstoken (nicht in der Ajax-Version), aber es wäre eine nette Funktion, nur dieses anstelle der Datenbank zu verwenden.

* Benutzerergebnisse können automatisch gelöscht werden. Es gibt eine Aufgabe,
  mit der alte Benutzer-/Quizteilnehmerergebnisse gelöscht werden können. Man findet diesen Task im Scheduler.

.. tip::

   Wenn du das Layout eines Quiz ändern möchtest, musst du nicht unbedingt die Templates ändern.
   Sieh dir die TypoScript-Konfiguration an. Du kannst das Layout auch mit den settings.template.* ändern.


.. _admin-final:

Abschlußseite
-------------

Auf der letzten Seite sind noch einige weitere Variablen verfügbar. Diese finden Sie im Partial FinalPage.html.
Darüber hinaus wird ein Array nur dann gefüllt, wenn man Kategorien bei der Auswertung verwenden: {finalCategories}.
Dieses Array enthält die Variablen: uid, title, count und all. all ist wiederum ein Array und enthält: title und count.


.. _admin-import:

Myquizpoll-Einträge importieren
-------------------------------

* Es gibt eine Planungsaufgabe, mit der man einfache Fragen aus der alten Erweiterung myquizpoll importieren kann.

.. important::

   Man benötigt TYPO3 8 oder 9, wenn man diese Importaufgabe verwenden will.
   Diese Aufgabe wurde in Version 3.0.0 dieser Erweiterung entfernt!
   Wenn man TYPO3 9 verwendet und myquizpoll-Fragen importieren möchte, benötigt man auch die Erweiterung typo3db_legacy!


.. _admin-export:

Teilnehmereinträge exportieren
-----------------------------

* Es gibt eine Scheduler-Aufgabe, mit der Sie Teilnehmer aus einem einzelnen
  Ordner (pid) exportieren können. Die CSV-Datei wird in den fileadmin-Ordner geschrieben.


.. _security-fix:

Sicherheitsfix in Version 3.5.2
-------------------------------

Seit Version 3.5.2 ist immer ein Sitzungsschlüssel erforderlich und dieser Sitzungsschlüssel wird mit einem Teilnehmer verglichen.
Wenn man die Ajax-Version verwendet UND wenn man eigene HTML-Templates verwendet, muss man dem Template Code hinzufügen!
Im Template Show.html muss man diese Zeile zu den versteckten Feldern des ersten Formulars hinzufügen::

<f:form.hidden name="session" value="" id="quiz-form-session" />

Im Template ShowAjax.html muss man 2 Zeilen hinzufügen.
Diese nach "$('#quiz-form'+ceuid+' #quiz-form-parti').val('{participant.uid}');"::

  $('#quiz-form'+ceuid+' #quiz-form-session').val('{session}');

und diese hier nach "$('#quiz-form-parti').val('0');"::

  $('#quiz-form-session').val('');

Dadurch wird für jeden Teilnehmer ein Sitzungsschlüssel festgelegt.

Eine weitere Änderung wurde in den Einstellungen vorgenommen.
Die Standard-Quiz-UID 1 wurde entfernt. Wenn man die Standardeinstellung verwendet,
muss man settings.defaultQuizUid erneut auf 1 setzen.


.. _admin-faq:

FAQ
---

- Gibt es APIs?

  Nein.

- Gibt es Abhängigkeiten?

  Ja, Sie benötigen jQuery.

- Wie kann ich den Übersetzungstext ändern?

  Hier ein TypoScript-Beispiel:

  ::

     plugin.tx_fpmasterquiz._LOCAL_LANG.de.text.yourAnswers = Deine Abstimmung:
     plugin.tx_fpmasterquiz._LOCAL_LANG.de.text.allAnswers = Bisherige Abstimmung:
     plugin.tx_fpmasterquiz._LOCAL_LANG.de.text.done = Danke für deine Teilnahme! Deine Auswertung:

- Wie kann ich einige Felder im Backend umbenennen oder ausblenden?

  Siehe Kapitel „Konfiguration / pageTSConfig“.

- Wie kann ich Routing / sprechende URLs verwenden?

  Siehe Kapitel „Konfiguration / Routing“.

- Verwendet die Erweiterung Cookies?

  Nur wenn man diese über settings.user.useCookie aktiviert. Siehe Kapitel „Konfiguration“.

- Gibt es ein Widget für das TYPO3-Dashboard?

  Ja, es gibt 2. Sie wurden in Version 3.2.4 hinzugefügt.
