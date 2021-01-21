# fp_masterquiz

version 2.0.0

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

7 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating.

This extension is not backward compatible to myquizpoll, but there is a simple import-task for myquizpoll-questions.

You find the documentation at typo3.org: https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/

Changes in version 2.0.0:
  The ajax-action gets now the quiz-object.
  Media-field added to a quiz.
  Default value of the setting showAnswersAtFinalPage and showAllAnswers changed from 0 to 1.
  Default value of the setting showOwnAnswers changed from 1 to 2.
  Default value of startPageUid removed! Setting showPageUid added.
  Shows now the points only if the maximum points are greater than 0.
  jQuery can now be loaded in the footer.
  Important: probably you need to flush all caches.

Changes in version 2.0.1: deutsche Übersetzungen.