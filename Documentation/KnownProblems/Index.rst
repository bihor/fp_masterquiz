.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _known-problems:

Known Problems
==============

The bug tracker is here:
`bug tracker <https://github.com/bihor/fp_masterquiz/issues>`_?

jQuery needed to be loaded in the head.

There might be some problems, if you enable Ajax!
Sessions and Cookies are currently not supported if you enable Ajax.

Note for versions < 3: it might be necessary to change the Quiz/Show.html template, if you will see the startpage
instead of a question as a ajax result page. You could try to change the type from POST to GET in the $.ajax call.
But you can change this via TypoScript too:

:typoscript:`plugin.tx_fpmasterquiz.settings.ajaxType = GET`

Furthermore the default language will be english in TYPO3 9 (and 10?) if you enable Ajax. You can solve this problem this way:
you need to add some TypoScript like this to your TypoScript-setup:

:typoscript:`ajaxfpmasterquiz_page.config.language = de`

:typoscript:`ajaxfpmasterquiz_page.config.sys_language_uid = 0`

:typoscript:`ajaxfpmasterquiz_page.config.locale_all = de_DE.utf8`

Please note furthermore:

- the AJAX-version of the quiz/poll works only if the cHash-check is disabled by TypoScript:
  plugin.tx_fpmasterquiz.features.requireCHashArgumentForActionArguments = 0 
  This is set by default. Or if you disable the cHash-check globally: 
  $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = false
  in the install tool.
