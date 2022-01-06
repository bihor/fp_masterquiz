.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

ChangeLog
=========

0.2.0: First release for the TER.

0.2.2: Bug with points fixed.
  New settings: settings.showCorrectAnswers and settings.showPoints.

0.3.0: Now optimized for Bootstrap 4.
  New settings: showAnswersAtFinalPage and template.

0.4.0: Now polls possible, because all submited results are avaiable.
  New settings: showOwnAnswers, showAllAnswers, templateLayout...

0.5.0: Now for TYPO3 8 and 9. Backend module added. Charts added.
  Deletion-task changed: delete-flag and real deletion now possible.
  Lazy loading removed, because delete cascade does not work with lazy loading.
  New settings: showPageNo and showQuestionNo.

0.6.0: Donut chart added.
  Session-token added to prevent reload-manipulations.
  New settings: user.useCookie.

0.7.0: Text-answer now possible. Thanks to Gerald Loss.
  New settings: user.checkFEuser.
  Bug fixed: anonymous IP address.

1.0.0: Question mode "Show a comment" and "Star rating" implemented.

1.1.0: Question mode "Enter a comment (textarea)" implemented.
  New settings: checkAllStars.
  Sending of emails now possible.
  Using of FE-user-data, if user.checkFEuser is set.
  Dropped support for TYPO3 8. Now for TYPO3 9 and 10.

1.2.0: New feature: 50:50 joker.
  Page layout view / preview in the backend. 
  Bugfix: summation of points works now with negative points too.
  Bugfix: FlexForms in TYPO3 10.
  Bugfix: hidden-fields in the backend.

1.3.0: New setting: ajaxType.
  New setting: email.likeFinalPage.
  New settings: showEveryAnswer and option 2 for showOwnAnswers and showCorrectAnswers.
  Bugfix: sending of emails.

1.4.0: New setting: resultPageUid and new action: result for a result page.
  Possiblity added to add a question to a quiz via backend module.
  Question mode "Yes/no-boxes (2 radio-buttons)" implemented.
  Important bugfix for PHP 7.3 and other bugfixes points related.

1.5.0: Bodytext and image added to the evaluation.
  Routing/slug/path segment added to a quiz.
  Categories added to a quiz.
  Layout of yes/no-questions changed.
  New settings: setMetatags.
  Sorting of selected answers of a participant: using now an array instead of an object.
  Another bugfix points related.
  See issues #12 - #18.

2.0.0: The ajax-action gets now the quiz-object.
  Media-field added to a quiz.
  Default value of the setting showAnswersAtFinalPage and showAllAnswers changed from 0 to 1.
  Default value of the setting showOwnAnswers changed from 1 to 2.
  Default value of startPageUid removed! Setting showPageUid added.
  Shows now the points only if the maximum points are greater than 0.
  jQuery can now be loaded in the footer.
  Important: probably you need to flush all caches.

2.1.0:
  Highscore action added.
  Explanation added to the result action/view.
  Completed-field added: final page reached?
  Deutsche Übersetzungen.
  Bugfix for TYPO3 10.
  Important: probably you need to flush all caches.

2.2.0:
  showByTag action added. Tag for a question added.
  intro action and settings introContentUid, introNextAction added.
  Showing all answers of a text-answer in the chart in the backend.
  Showing the start and end time in the backend.
  A time period can be defined for a quiz and/or a tag.
  TCA-Bugfix for TYPO3 10.
  Refactoring.

3.0.2:
  Version for TYPO3 10 and 11.
  closure action and setting closurePageUid added.
  Default-value for setting ajaxType changed from POST to GET.
  Language of a participant and his answers changed from 0 to -1.
  Breaking: myquizpoll-import-task removed.

3.1.1:
  Setting user.useQuizPid, noFormCheck, random and allowEdit added.
  Possibility added to move questions from one quiz to another quiz.
  More Flexforms.

3.1.2:
  Bugfix for breaking change in TYPO3 11.5.0.

3.2.0:
  Every question can now be set to be optional. Setting template.optionalMark added.
  The answer of text-fields is now checked too (it is no longer optional, but can be set to optional).
  The RatingStar.css will now be included by the viewhelper f:asset in the template itself. Use includeRatingCSS=0 to disable it.
  Setting template.col12 added for questions without an image.
  Div with class card-body added to all cards.
  Variable participant.username added.

3.3.0:
  Layout adapted for TYPO3 11.5.
  2 widgets for the TYPO3 dashboard added.
  Supports now PHP 8; thanks to Gerald Loss.