# fp_masterquiz

version 3.5.3

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

8 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating, matrix.

This extension is not backward compatible to myquizpoll, but there is a simple import-task for myquizpoll-questions in older versions.

jQuery is required. Optimized for Bootstrap 4.

Dashboard widget available.

CSV-export available via scheduler task.

Available languages: english and german/deutsch.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/


Changes in version 3.5.0/1:
- Mandatory check with PHP too, if setting phpFormCheck=1.
- New question mode: matrix with categories of a question.

Changes in version 3.5.2:
- Security fix: checking participant against a session-key. Please read the section Administrator / Security fix in version 3.5.2.
- Bugfix: check if a quiz/poll is allowed on a page. Therefore, the defaultQuizUid was removed in the settings!

Changes in version 3.5.3:
-  Replaced invocation of PersistenceManager with DI #46
