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


.. _admin-variables:

Variables of a quiz
-------------------

If you want to change some templates, you should know, which variables of a quiz are available.
There are this sections: quiz, question, answer, evaluation, tag. That are variables, filled in the backend.
And there are this user-related sections: participant and selection (answers of a participant).

A quiz has this variables:
name, about, timeperiod (in seconds), media, questions, questionsSortByTag, categories, evaluations and
maximum2 (maximum points for a quiz).

A question has this variables:
title, qmode (question-mode), image, bodytext, explanation, sorting, tag, answers, selectOptions, numberOfAnswers, arrayOfAnswers.
Furthermore:
maximum1 (maximum points for a question),
allAnswers (no. of all answers/votes - checkboxes counted once),
totalAnswers (no. of all answers/votes - all checkboxes counted),
textAnswers (array with entered text answers, only in the BE available).

An answer has this variables:
title, titleJS, points, jokerAnswer, onwAnswer (yes/no), allAnswers (total answers of all users),
allPercent (total percent of all users - checkbox counted ounce),
totalPercent (total percent of all users - all checkboxes counted).

An evaluation has this variables:
evaluate (evaluate points (unchecked) or percentage (checked)), minimum and maximum, image, bodytext,
ce (content element ID), page (page ID).

A tag has this variables:
name, timeperiod (in seconds).

A participant has this variables:
name, email, homepage, user (FE-user-ID), ip, session, sessionstart, quiz, points,
maximum1 (maximum points for the answered questions), maximum2 (maximum points for a quiz),
startdate, crdate, tstamp, datesNotEqual, timePassed, page (reached page), completed (quiz completed?),
selections (all answered questions), selectionsByTag (answered questions of a tag),
sortedSelections (answered questions, well sorted).

A selection has this variables:
question, answers, sorting, points, maximumPoints (maximum points for this question), entered (entered text to this question).


.. _admin-configuration:

User results
------------

* Currently all user results will be saved in the database. There is a session-token (not in the Ajax-version), but it would be a nice feature to use only that one instead of the database.

* User results can be deleted automatically. There is a task which can delete old user/quiz-taker results. You find the task in the Scheduler.

.. tip::

   If you want to change the layout of a quiz, you do not need to change the templates necessarily.
   Take a look at the TypoScript configuration. You can change the layout with the settings.template.*


.. _admin-import:

Importing myquizpoll entries
----------------------------

* There is a scheduler task which whom you can import simple question from the old extension myquizpoll.

.. important::

   You will need TYPO3 8 or 9 if you use this import task.
   If you are using TYPO3 9 and you want to import myquizpoll-questions, then you will need the extension typo3db_legacy too!


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
  
- How can I use routing / speaking urls?

    See chapter “Configuration / Routing”.

- Does the extension uses cookies?

    Only if you enable them via settings.user.useCookie. See chapter “Configuration”.