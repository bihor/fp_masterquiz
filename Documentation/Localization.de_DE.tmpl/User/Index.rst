.. include:: /Includes.rst.txt

.. _user-manual:

Benutzerhandbuch
================

Redakteure können ein Quiz/eine Umfrage/einen Test in einem Ordner erstellen.
Zuerst muss man ein Quiz in der Listenansicht erstellen. Klicke auf das Quiz und füge dem Quiz einige Fragen und Antworten hinzu.

Optional kann man einige Bewertungen/Auswertungen hinzufügen.

Nachdem ein Quiz mit einigen Fragen erstellt wurde, kann man das Plugin auf einer Seite hinzufügen und dort den Ordner mit dem Quiz auswählen.

Hinweise:

- Nicht alle Einstellungen können über FlexForms vorgenommen werden. Es gibt weitere TypoScript-Einstellungen.

- Wenn man die AJAX-Version aktiviert, werden die FlexForms ignoriert, da der AJAX-Aufruf das Plugin nicht kennt.

- **Konfiguriere das Quiz nur über TypoScript, wenn die AJAX-Version verwendet wird**.

- Der AJAX-Aufruf ruft eine normale Aktion und kein eID-Skript auf. Die cHash-Prüfung muss deaktiviert werden (dies ist standardmäßig eingestellt), wenn AJAX verwendet wird.

- Die AJAX-Lösung funktioniert derzeit nicht, wenn die Aktion „Nach Tag anzeigen“ verwendet wird.

.. tip::

    Tipp für fp_masterquiz Version < 3.6.0:
    Wenn man ein Quiz mit mehr als 10 Fragen habt, wird das Backend langsam. Um dies zu vermeiden, erstellen man ein Quiz mit fast leeren Fragen.
    Bearbeite abschließend jede Frage einzeln.
    Zweite Möglichkeit: gehe zum Backend-Modul und klicke auf „Zeige Quiz-Details“.
    Dort kann man Fragen zu einem Quiz hinzufügen, nachdem man zuerst Fragen erstellt habt.
    Dritte Möglichkeit: man kann die „Erweiterte Ansicht“ in der Listenansicht verwenden.
    Dort kann man jedes Feld eines Quiz bearbeiten,
    nachdem man das gesamte Quiz/die Umfrage erstellt habt. Siehe Screenshot unten.

Diese Screenshots zeigen ein Quiz in der Listenansicht und einige FlexForm-Einstellungen des Plugins.

.. include:: /Images/UserManual/BackendView1.rst.txt

   Backend-Ansicht von einem Quiz.

.. include:: /Images/UserManual/BackendPlugin1.rst.txt

   Backend-Ansicht des Plugins (Teil 1). Viele Flexform-Einstellungen!

.. include:: /Images/UserManual/BackendPlugin2.rst.txt

   Backend-Ansicht des Plugins (Teil 2).

.. include:: /Images/UserManual/BackendQuiz2.rst.txt

   Man kann jedes Feld eines Quiz in der erweiterten Ansicht bearbeiten.

Aktionen
--------

Man kann folgende Plugins benutzen:

- list: Liste aller Quiz/Umfragen/Tests eines Ordners mit Links zur Einzelansicht

- show: ausgewähltes Quiz/Umfrage/Test anzeigen und Seitenbrowser verwenden

- showByTag: ausgewähltes Quiz/Umfrage/Test anzeigen und Fragen nach Tag sortieren: auf jeder Seite werden Fragen eines Tags angezeigt
  (Ajax-Version funktioniert noch nicht)

- intro: eine Intro-Seite und dann ein Quiz anzeigen

- closure: eine Abschlussseite nach Abschluss eines Quiz anzeigen; diese Seite wird nur angezeigt, wenn user.askForData=3

- result: ein Ergebnis eines Quiz/einer Umfrage/eines Tests anzeigen

- highscore: einen Highscore eines Quiz anzeigen

Fragemodi
---------

Man kann zwischen folgenden Fragemodi wählen:
Mehrfachantworten möglich (Kontrollkästchen), Eine Antwort auswählen (Optionsfeld), Eine Antwort auswählen (Auswahloptionen),
Antwort eingeben (Textfeld), Ja/Nein-Felder (2 Optionsfelder), Kommentar eingeben (Textfeld), Kommentar anzeigen, Sternebewertung
und eine Matrix von Kategorien einer Frage für jede Antwort (nur für Umfragen geeignet; noch keine detaillierte Auswertung implementiert).

Zeitraum
--------

Bei einem Quiz und einem Tag kann ein Zeitraum definiert werden. Wenn die Zeit abgelaufen ist,
wird das Formular zur nächsten Seite oder zur letzten Seite weitergeleitet.

Punkte
------

Es gibt im Backend kein Kontrollkästchen für richtige Antworten!
Um eine Antwort als richtig zu markieren, müssen Sie im Punktefeld einen Wert größer als 0 eingeben.

Für falsche Antworten wähle 0 oder einen negativen Wert.

Für Umfragen müssen keine Punkte vergeben werden.

Textantworten
-------------

Es gibt 2 mögliche Textantworten: Eingabefeld oder Textbereich.
*Hinweis*: Diese Funktion funktioniert nur, wenn man auch eine Antwort zu einer solchen Frage hinzufügt!
Die hinzugefügte Antwort wird nicht im Frontend angezeigt, wird aber benötigt, um ein Eingabefeld oder einen Textbereich im Frontend anzuzeigen.

Sternebewertung
---------------

Ein Sonderfall ist die Sternebewertungsfunktion. Für diese Funktion ist standardmäßig eine CSS-Datei enthalten.
Wenn man diese Funktion nicht benötigt, kann man die CSS-Datei für Versionen bis 3.1.2 wie folgt entfernen::

  page.includeCSS.fpMasterQuizRatingStar >

Seit Version 3.1.3 kann man die CSS-Datei über TypoScript (oder im Template selbst) entfernen::

  plugin.tx_fpmasterquiz.settings.includeRatingCSS = 0

Ansonsten sollte man folgendes wissen:
Die Sternebewertung funktioniert möglicherweise mit alten Browsern nicht richtig. Es handelt sich um eine reine CSS-Lösung.
Sie sieht folgendermaßen aus:

.. include:: /Images/UserManual/StarRating.rst.txt

   Beispiel für eine Sternebewertung.

Man kann sie folgendermaßen verwenden:
Da im Hintergrund Radio-Boxen verwendet werden, muss man sie wie Radio-Boxen konfigurieren.
Wähle den Fragemodus „Sternebewertung“ und füge dann so viele Antworten hinzu, wie du möchtest,
um Sterne zu erhalten. Wenn man 5 Sterne möchte, fügt man 5 Antworten hinzu.
Die erste Antwort ist die höchste Bewertung (z. B. 5 Sterne) und die letzte Antwort ist die niedrigste Antwort (1 Stern).
Das ist die umgekehrte Logik der Sternebewertung in der Erweiterung myquizpoll.
Lege die Punkte nicht fest. In der Benutzerantwort zeigen die Punkte an, wie viele Sterne ausgewählt wurden.
Mit der Einstellung checkAllStars kann man festlegen, ob standardmäßig ein oder alle Sterne aktiviert werden sollen.

.. important::

   Für jede Frage muss man mindestens eine Antwort hinzufügen, auch bei einigen
   Typen, wo die Antwort nicht angezeigt wird!

.. _user-faq:

FAQ
---

- Was ist mit Benutzerdaten wie Name und E-Mail? Wo kann man sie abfragen?

  Es ist eine spezielle Einführungsseite möglich, auf der man nach Benutzername, E-Mail und Homepage fragen kann.
  Oder man kann die Benutzerdaten auf der ersten Seite eines Quiz abfragen.
  Und: man kann die Benutzerdaten auf der letzten Seite abfragen.
  Dann benötigt man auch eine Abschlussseite.
  Wenn der Benutzer angemeldet ist, werden diese Daten von fe_users übernommen.

- Was ist der Unterschied zwischen der letzten Seite und der Abschlussseite?

  Die letzte Seite ist die Seite, die man erhält, wenn das Quiz abgeschlossen wurde.
  Wenn „user.askForData = 3“ ist, wird dieses Formular
  von der letzten Seite auf die Abschlussseite umgeleitet.
  Nur in diesem Fall benötigt man eine Abschlussseite.

- Es treten Fehler auf oder ich erhalte eine leere Seite. Was kann ich tun?

  Wenn man AJAX verwendet: Deaktiviere es oder lese das Administrationshandbuch.
  Man kann auch dieses TypoScript ausprobieren: config.contentObjectExceptionHandler = 0
