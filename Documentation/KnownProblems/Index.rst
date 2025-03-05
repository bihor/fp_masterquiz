.. include:: /Includes.rst.txt

.. _known-problems:

Known Problems
==============

The bug tracker is here:
`bug tracker <https://github.com/bihor/fp_masterquiz/issues>`_?

There might be some problems, if you enable Ajax!
User-data and cookies are currently not supported if you enable Ajax.

The default language will be english in TYPO3 9 (and 10?) if you enable Ajax. You can solve this problem this way:
you need to add some TypoScript like this to your TypoScript-setup:

:typoscript:`ajaxfpmasterquiz_page.config.language = de`

:typoscript:`ajaxfpmasterquiz_page.config.sys_language_uid = 0`

:typoscript:`ajaxfpmasterquiz_page.config.locale_all = de_DE.utf8`

Please note furthermore:

- the AJAX-version of the quiz/poll works only if the cHash-check is disabled in the install tool.
  See chapter "Configuration".

- the AJAX-version ignores FlexForm-settings during the AJAX-call but not during the initialization.
  Therefore you should not set any FlexForms if you use AJAX or they should be equal.
