# fp_masterquiz

version 5.1.6

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

Changes in version 5.0:
- Refactoring with the rector-tool.
- settings.debug=2 is new. If 2 instead of 1, the debug output will be written into a log file.
- settings.user.checkFEuser allows now values greater than 1.
- Bugfix for pointsMode 4.

Changes in version 5.0.3:
- Bugfix: prevent multiple ajax calls.
- Bugfix: Matrix-Display.

Changes in version 5.1:
- More layout possibilities: group a normal quiz/poll by tags; show answers inline (span instead of div).

Changes in version 5.1.4:
- More support for group by tags.
- More support for matrix-questions.

Changes in version 5.1.6:
- Bugfix: backend preview.
- Remove of deprecated methods.