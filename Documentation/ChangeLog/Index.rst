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
  Categories added to a quiz.
  Layout of yes/no-questions changed. 
  Another bugfix points related.
