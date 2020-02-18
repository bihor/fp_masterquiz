.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _user-manual:

Users Manual
============

Editors can create a quiz/poll/test on a folder. First you must create a quiz in the list view. Click at the quiz and add some questions and answers to the quiz.
Optionally you can add some evaluations.

After you have created a quiz with some questions you can add the plugin at a page and there you must select the folder with the quiz.

- Note:

  - Not every setting can be done by FlexForms. There are more TypoScript-settings.

  - When you enable the AJAX-version, the FlexForms will be ignored, because the AJAX-call does not know the plugin.

  - **Configure the quiz only by TypoScript, if you use the AJAX-version**.

  - The AJAX-call calls an normal action and not an eID-script. The cHash-check must be disabled (this is set by default) if you use AJAX.

.. tip::

   If you have a quiz with more than 10 questions, the backend will be very slow. To avoid this, create a quiz with nearly empty questions.
   Finally edit every question individually.

.. important::

   Not every DB field is used yet. Thats no error. This is not the final version...

This screenshots shows you a quiz in the list view and some FlexForm-settings of the plugin.

.. figure:: ../Images/UserManual/BackendView.png
   :width: 530px
   :alt: Backend view of a quiz

   Backend view of a quiz.

.. figure:: ../Images/UserManual/BackendPlugin.png
   :width: 530px
   :alt: Backend view of the plugin

   Backend view of the plugin (early beta version).

Star-Rating
-----------

A special case is the star rating feature. For that feature a CSS-file is included by default. If you do not need this feature, you can remove the CSS-file like this::

  page.includeCSS.fpMasterQuizRatingStar >

Otherwise you should know this: the star rating may not work correct with old browsers. It is a CSS only solution. It looks like this:

.. figure:: ../Images/UserManual/StarRating.png
   :width: 164px
   :alt: Star rating

   Star rating example.

You can use it this way: because it uses radio-boxes in the background, you must configure it like radio-boxes.
Select the question mode "star rating" and than add as many answers as you like to have stars. If you want 5 stars, add 5 answers.
The first answer is the highest rating (e.g. 5 stars) and and last answer is the lowest answer (1 star). 
That is the opposite logic of the star rating in the extension myquizpoll.
Do not set the points. In the user-answer, the points shows how many stars were seleced.

.. _user-faq:

FAQ
---

- I need some features from myquizpoll. What can I do?

  You can tell me, which feature you need.
  
- There are some errors or I get a blank page. What can I do?

  If you use AJAX: disable it or read the Administration-manual. You can try this TypoScript too: config.contentObjectExceptionHandler = 0
