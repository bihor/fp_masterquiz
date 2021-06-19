# fp_masterquiz

version 2.2.0

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

7 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating.

This extension is not backward compatible to myquizpoll, but there is a simple import-task for myquizpoll-questions.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/

Changes in version 2.2.0:
- intro action and settings introContentUid, introNextAction added.
- date and time of the participant in the BE module.
- text-answers in the BE module.
- time period for a quiz.
- TCA-Bugfix for TYPO3 10.
