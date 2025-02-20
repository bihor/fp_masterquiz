.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _changelog:

Änderungen
==========

3.0.0/2:
Version für TYPO3 10 und 11.
Closure-Aktion und Einstellung von closurePageUid hinzugefügt.
Standardwert für Einstellung von ajaxType von POST auf GET geändert.
Sprache eines Teilnehmers und seiner Antworten von 0 auf -1 geändert.
Breaking: myquizpoll-import-task entfernt.

3.1.1:
Einstellungen von user.useQuizPid, noFormCheck, random und allowEdit hinzugefügt.
Möglichkeit hinzugefügt, Fragen von einem Quiz in ein anderes Quiz zu verschieben.
Mehr Flexforms.

3.1.2:
Bugfix für Breaking Change in TYPO3 11.5.0.

3.2.0:
Jede Frage kann jetzt als optional eingestellt werden. Einstellung template.optionalMark hinzugefügt.
Die Antwort von Textfeldern wird jetzt ebenfalls geprüft (sie ist nicht mehr optional, kann aber auf optional eingestellt werden).
Die RatingStar.css wird nun vom Viewhelper f:asset im Template selbst eingebunden. Mit includeRatingCSS=0 lässt sie sich deaktivieren.
Einstellung template.col12 für Fragen ohne Bild hinzugefügt.
Div mit Klasse card-body zu allen Karten hinzugefügt.
Variable participant.username hinzugefügt.

3.3.0/1:
Backend-Layout für TYPO3 11.5 angepasst.
Evaluierung der meistgenutzten Kategorie nun ebenfalls möglich. Einstellung showDetailedCategoryEvaluation hinzugefügt.
TYPO3-Kategorien sind nun bei Quiz, Frage, Antwort, Auswahl und Bewertung verfügbar.
Pflichtfragen werden nun bei Auftreten eines Fehlers markiert. Die Fehlermeldung ist nun keine JavaScript-Warnmeldung mehr.
2 Widgets für das TYPO3-Dashboard hinzugefügt (die Erweiterung Dashboard wird in TYPO3 11 benötigt).
Unterstützt nun PHP 8; Dank an Gerald Loss.
Bugfix: Teilnehmerdaten in einen anderen Ordner verschieben.
Bugfix: Überprüfung von Kontrollkästchen behoben.

3.4.0:
Die Antwort von Textarea-Feldern wird nun ebenfalls überprüft (ist nicht mehr optional, kann aber auf optional gesetzt werden).
CSV-Export als Scheduler-Aufgabe hinzugefügt.
Dashboard in TYPO3 11 nicht mehr erforderlich.
Layoutoptimierungen.

3.4.4:
Bugfix: Daten vor der Auswertung beibehalten.
Bugfix: Kategorieauswertung.
Bugfix: falscher Namespace im TemplateLayout korrigiert.

3.5.0/1:
Obligatorische Überprüfung auch mit PHP, wenn phpFormCheck=1 gesetzt ist.
Neuer Fragenmodus: Matrix mit Kategorien einer Frage.

3.5.2:
Sicherheitsfix: Überprüfung des Teilnehmers anhand eines Sitzungsschlüssels.
Bitte lesen Sie den Abschnitt Administrator / Sicherheitsfix in Version 3.5.2.
Sicherheitsfix: Überprüfung, ob ein Quiz/eine Umfrage auf einer Seite zulässig ist.
Daher wurde die defaultQuizUid in den Einstellungen entfernt!

3.5.5:
Aufruf von PersistenceManager durch DI #46 ersetzt.
Quellcode neu formatiert und PHP 8 Bugfix.
Bugfix: optionales Kontrollkästchen war nicht anklickbar.

3.6.0:
Tabs für Quizeintrag im Backend eingeführt. Fragen und Bewertungen sind jetzt eingeklappt.
Einstellung „geschlossen“ hinzugefügt: Teilnahme ist dann nicht möglich.
Typ für Quizeintrag hinzugefügt.
Bugfix beim Senden von E-Mails und AdminEmail kann jetzt mehrere E-Mail-Adressen enthalten und im Debugmodus wird der E-Mail-Inhalt abgefragt.
Bugfix für andere Sprachen als 0 und PHP 8 Bugfix.

3.7.0:
Geschlossen-Kontrollkästchen auch für Quiz hinzugefügt.
Verwendung einer Zielaktion in der Listenansicht.
Neues FE-Layout für Ergebnisse: detaillierte Tabellenliste.
allowEdit = 2 ist neu (Bearbeiten auch bei abgeschlossenem Status zulassen).
Bugfix: Alte Auswahlen löschen, wenn sie im Bearbeitungsmodus ersetzt werden.
Bugfix: Geänderte Benutzerdaten im Bearbeitungsmodus nicht ignorieren.

3.7.1:
Absoluter Pfad zu Bildern in E-Mails.
Debug-Echo entfernt.
PHP 8 Bugfix.

4.0:
Breaking: Alle Plugins müssen über ein Update-Skript (im Install-Tool) geändert werden!

TypoScript module.tx_fpmasterquiz_web_fpmasterquizmod1 geändert in module.tx_fpmasterquiz.

Hinweis für die Ajax-Version: Eventuell muss der Wert von „ajaxfpmasterquiz_page.10.pluginName“ geändert werden.

4.1:
TypoScript-Dateien von .ts in .typoscript umbenannt.

Vermeidung von PHP- und JavaScript-Fehlern durch fehlende Einstellungen.

Upgrade-Assistent für alte Dateiverweise.

4.2:
Fragen können jetzt auch geschlossen werden.

Bugfix für: Vermeidung von PHP- und JavaScript-Fehlern durch fehlende Einstellungen.

4.3:
Einstellung redirectToResultPageAtFinal hinzugefügt: Weiterleitung zur Ergebnisseite, wenn die letzte Seite erreicht ist?

Einstellung pointsMode hinzugefügt: 0 Punkte, wenn nicht alle Antworten richtig sind, jetzt möglich.

5.0:
Refactoring mit dem Rector-Tool.

settings.debug=2 ist neu. Wenn 2 statt 1, wird die Debug-Ausgabe in eine Log-Datei geschrieben.

settings.user.checkFEuser erlaubt jetzt Werte größer als 1.

Bugfix für settings.pointsMode 4.

5.0.3:
Bugfix: Vermeidung mehrerer Ajax-Aufrufe.

Bugfix: Matrix-Anzeige.

5.1:
Mehr Layout-Möglichkeiten: Gruppieren eines normalen Quiz/Umfrage nach Tags; Antworten inline anzeigen (Span statt Div).

5.1.4:
Mehr Unterstützung für Gruppieren nach Tags.

Mehr Unterstützung für Matrix-Fragen.

5.1.6:
Bugfix: Backend-Vorschau.

Entfernen veralteter Methoden und SQL-Felder.

5.1.7:
Bugfix: Sortierfehler der ausgewählten Tabelle.

5.1.8:
Bugfix: Übersetzungen im Ajax-Modus.

5.1.9:
Bugfix: Punkteberechnung für Modi 3 und 4.

5.1.10/1:
Bugfix: Backend-Modul für Benutzer zulassen.

5.2.0:
Refactoring mit dem Rector-Projekt.

Vorbereitungen für TYPO3 13. Achtung: Der Pfad zu den Backend-Templates ist jetzt in Configuration/page.tsconfig definiert.

6.0.0:
Erste Version für TYPO3 13, aber E-Mails funktionieren nicht mit TYPO3 13!

Upgrade-Assistenten für alte Dateiverweise und Switchable-Controller-Action-Plugins entfernt!

6.1.0:
Support für TYPO3 12 eingestellt!

Die E-Mails funktionieren jetzt auch mit TYPO3 13 und sind jetzt auch lokalisiert.

6.1.1:
Bugfix: Tasks behoben.

6.2.0:
Layout geändert: fieldset zu Fragen und Benutzerdaten im Formular hinzugefügt und
settings.wrapQuestionTitle1 in legend geändert.

Deutsche Dokumentation hinzugefügt.
