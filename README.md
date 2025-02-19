# fp_masterquiz

version 6.2.0

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

8 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating, matrix.

jQuery is required. Optimized for Bootstrap 4/5.

Dashboard widget available.

CSV-export available via scheduler task.

Available languages: english and german/deutsch.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/

Changes in 6.0.0:
- First version for TYPO3 13, but emails are not working with TYPO3 13!
- Upgrade Wizards for old file references and Switchable-Controller-Action-Plugins removed!

Changes in 6.1.0:
- Support for TYPO3 12 dropped!
- The emails work now with TYPO3 13 too, and they are now localized too.

Changes in 6.1.1:
- Bugfix: tasks fixed.

Changes in 6.2.0:
- Layout changed: fieldset added to questions and user data in the form and settings.wrapQuestionTitle1 changed to legend.

You find the whole changelog here:
https://raw.githubusercontent.com/bihor/fp_masterquiz/refs/heads/master/Documentation/ChangeLog/Index.rst
