.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

Note: only the templates Quiz/List.html, Quiz/Show.html and Quiz/ShowAjax.html are in use!
Don´t remove classes or IDs that begin with quiz, because they are used to vaildate the form!


.. _admin-installation:

Installation
------------

To install the extension, perform the following steps:

#. Go to the Extension Manager
#. Install the extension
#. Load the static template
#. Create a quiz... but read the user manual before.

For a list of configuration options, go to the chapter Configuration.

.. important::

   If you are using TYPO3 9 and you want to import myquizpoll-questions, then you will need the extension typo3db_legacy too!


.. _admin-configuration:

User results
------------

* Currently all user results will be saved in the database. There is a session-token (not in the Ajax-version), but it would be a nice feature to use only that one instead the database.

* User results can be deleted automatically. There is a task which can delete old user/quiz-taker results. You find the task in the Scheduler.

.. tip::

   If you want to change the layout of a quiz, you do not need to change the templates necessarily.
   Take a look at the TypoScript configuration. You can change the layout with the settings.template.*


.. _admin-faq:

FAQ
---

- Are there any APIs?

  No.

- How can I change the translations text? Here an TypoScript example:

  ::

     plugin.tx_fpmasterquiz._LOCAL_LANG.de.text.yourAnswers = Deine Abstimmung:
     plugin.tx_fpmasterquiz._LOCAL_LANG.de.text.allAnswers = Bisherige Abstimmung:

- How can I rename or hide some fields in the Backend?

  See chapter “Configuration / Page TSConfig”.