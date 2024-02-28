# fp_masterquiz

version 4.3.0

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


Changes in version 3.7.0:
- Closed-checkbox added to a quiz too.
- Using a target-action at the list-view.
- New FE-layout for results: detailed table-list.
- allowEdit = 2 is new (allow edit even the status is completed).
- Bugfix: delete old selections when they are replaced in the edit mode.
- Bugfix: do not ignore changed user-data in edit mode.

Changes in version 3.7.1:
- Absolute path to images in emails.
- debug-echo removed.
- PHP 8 bugfix.

Changes in version 4.0:
- Breaking: all plugins must be changed via an update-script (in the install-tool)!
- TypoScript module.tx_fpmasterquiz_web_fpmasterquizmod1 changed to module.tx_fpmasterquiz.
- Note for the Ajax-version: maybe you need to change the value of "ajaxfpmasterquiz_page.10.pluginName".

Changes in version 4.1:
- TypoScript-files renamed from .ts to .typoscript.
- Prevent PHP and JavaScript errors from missing settings.
- Upgrade Wizard for old file references.

Changes in version 4.2:
- Questions can now be closed too.
- Bugfix for: prevent PHP and JavaScript errors from missing settings.

Changes in version 4.3:
- Setting redirectToResultPageAtFinal added: redirect to the result page when the final page is reached?
- Setting pointsMode added: 0 points if not all answers are correct now possible.