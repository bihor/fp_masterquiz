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

There might be some problems, if you enable Ajax!
Sessions and Cookies are currently not supported if you enable Ajax.
Furthermore the default language will be english in TYPO3 9 if you enable Ajax. 

Please note furthermore:

- the AJAX-version of the quiz/poll works only if the cHash-check is disabled by TypoScript:
  plugin.tx_fpmasterquiz.features.requireCHashArgumentForActionArguments = 0 
  This is set by default. Or if you disable the cHash-check globally: 
  $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = false
  in the install tool.