.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

Note: only the templates Quiz/List.html and Quiz/Show.html are in use!
Don´t remove classes or IDs that begin with quiz, because they are used to vaildate the form!


.. _admin-installation:

Installation
------------

To install the extension, perform the following steps:

#. Go to the Extension Manager
#. Install the extension
#. Load the static template
#. Create a quiz...

For a list of configuration options, go to the chapter Configuration.


.. _admin-configuration:

User results
------------

* Currently all user results will be saved in the database. No session is used yet, but that would be a nice feature.

* User results can be deleted automatically. There is a task which can delete old user results. You find the task in the Scheduler.


.. _admin-faq:

FAQ
---

- Are there any APIs or Hooks?

  No.