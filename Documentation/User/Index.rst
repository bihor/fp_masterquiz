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

  - The AJAX-call calls an normal action and not an eID-script. The cHash-check must therefore be disabled if you use AJAX.

.. tip::

   Disable AJAX, if there is an unknown error.

.. tip::

   If you have a quiz with more than 10 questions, the backend will be very slow. To avoid this, create a quiz with nearly empty questions.
   Finally edit every question individually.

Currently this extension is a beta version.

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


.. _user-faq:

FAQ
---

- I need some features from myquizpoll. What can I do?

  You can tell me, which feature you need.
