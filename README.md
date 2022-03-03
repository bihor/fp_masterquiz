# fp_masterquiz

version 3.4.0

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

7 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating.

This extension is not backward compatible to myquizpoll, but there is a simple import-task for myquizpoll-questions in older versions.

jQuery is required. Optimized for Bootstrap 4.

Dashboard widget available.

CSV-export available via scheduler task.

Available languages: english and german/deutsch.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/


Changes in version 3.3.1:
- Backend-Layout adapted for TYPO3 11.5.
- Evaluation of the most used category is now possible too. Setting showDetailedCategoryEvaluation added.
- TYPO3 categories are now available at a quiz, question, answer, selected and evaluation.
- Mandatory questions are now marked when an error appears. The error message is now not a JavaScript-alert-message.
- 2 widgets for the TYPO3 dashboard added (the extension dashboard is required in TYPO3 11).
- Supports now PHP 8.
- Bugfix: moving participant data to another folder.
- Bugfix: check of checkboxes fixed.

Changes in version 3.4.0:
- The answer of textarea-fields is now checked too (it is no longer optional, but can be set to optional).
- CSV-export added as scheduler task.
- Dashboard no longer required in TYPO3 11.
- Layout optimizations.