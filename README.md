# fp_masterquiz

version 3.2.0

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

7 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating.

This extension is not backward compatible to myquizpoll, but there is a simple import-task for myquizpoll-questions in older versions.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/

Changes in version 3.1.1/2:
- Setting user.useQuizPid, noFormCheck, random and allowEdit added.
- Possibility added to move question from one quiz to another.
- More Flexforms.
- Bugfix for breaking change in TYPO3 11.5.0.

Changes in version 3.2:
- Every question can now be set to be optional. Setting template.optionalMark added (setting mandatoryMark from version 3.1.5 replaced).
- The answer of text-fields is now checked too (it is no longer optional, but can be set to optional).
- The RatingStar.css will now be included by the viewhelper f:asset in the template itself.
- Setting template.col12 added for questions without an image.
- Div with class card-body added to all cards.
- Variable participant.username added.