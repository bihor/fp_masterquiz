# fp_masterquiz

version 3.0.4

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

7 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating.

This extension is not backward compatible to myquizpoll, but there is a simple import-task for myquizpoll-questions.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/

Changes in version 3:
- Now for TYPO3 10 LTS and 11.3.
- Closure action and setting closurePageUid added.
- Default-value for setting ajaxType changed from POST to GET.
- Language of a participant and his answers changed to -1.
- Breaking: myquizpoll-import-task removed.

Version 3.0.4:
- Setting user.useQuizPid added.
- Possibility added to move question from one quiz to another.