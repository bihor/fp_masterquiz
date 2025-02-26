.. include:: ../../Includes.txt


.. _known-problems:

Bekannte Probleme
=================

Der Bugtracker ist hier:
`Bugtracker <https://github.com/bihor/fp_masterquiz/issues>`_?

Es kann zu Problemen kommen, wenn man Ajax aktiviert!

Benutzerdaten und Cookies werden derzeit nicht unterstützt, wenn man Ajax aktiviert.

Die Standardsprache ist in TYPO3 9 (und 10?) Englisch, wenn man Ajax aktiviert.
Man kann dieses Problem folgendermaßen lösen:
Man muss zum TypoScript-Setup ein TypoScript wie dieses hinzufügen:

:typoscript:`ajaxfpmasterquiz_page.config.language = de`

:typoscript:`ajaxfpmasterquiz_page.config.sys_language_uid = 0`

:typoscript:`ajaxfpmasterquiz_page.config.locale_all = de_DE.utf8`

Beachte außerdem:

- die AJAX-Version des Quiz/der Umfrage funktioniert nur, wenn die cHash-Prüfung im Installationstool deaktiviert ist.
Siehe Kapitel „Konfiguration“.

- die AJAX-Version ignoriert FlexForm-Einstellungen während des AJAX-Aufrufs, aber nicht während der Initialisierung.
Man sollte daher keine FlexForms festlegen, wenn man AJAX verwendet, oder die Einstellungen sollten gleich sein.
