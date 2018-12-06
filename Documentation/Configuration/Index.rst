.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration Reference
=======================

Configuration is possible via TypoScript, FlexForms and some points can be configured at the quiz in the list view.

Here I will describe the **TypoScript** settings only.


.. _configuration-typoscript:

TypoScript Reference
--------------------

The TypoScript settings can be changed via the TypoScript-Object-Browser. tx_fpmasterquiz.view, tx_fpmasterquiz.persistence
and persistence.features are like in other extensions. Here is only a list of the tx_fpmasterquiz.settings.


Properties
^^^^^^^^^^

.. container:: ts-properties

	=========================== =========== ============================================== ====================
	Property                    Data type   Description                                    Default
	=========================== =========== ============================================== ====================
	startPageUid                integer     UID of the page where the quiz beginns.        1
	defaultQuizUid              integer     UID of the quiz to show.                       1
	showAnswerPage              boolean     Show an answer page after every submit?        1
	ajax                        boolean     Enable the AJAX-version* of the quiz?          0
	user.ipSave                 boolean     Save the IP-address of a user?                 1
	user.ipAnonymous            boolean     Anonymize the IP-address?                      1
	user.askForData             boolean     Ask for user data at the first page of a quiz? 0
	user.defaultName            string      Default user name ({TIME} will be replaced).   default {TIME}
	user.defaultEmail           string      Default user email.
	user.defaultHomepage        string      Default user homepage.
	pagebrowser.itemsPerPage    integer     Number of questions on a page.                 1
	pagebrowser.insertAbove     boolean     You don´t need this.                           0
	pagebrowser.insertBelow     boolean     You don´t need this.                           0
	pagebrowser.maximumNum...   integer     You don´t need this.                           50
	overrideFlexformSettings... string      Fields that should be overwritten if empty.    startPageUid,...
	typeNum                     integer     Type of the AJAX-call. Don´t change it.        190675
	=========================== =========== ============================================== ====================

*) If you enable AJAX, you should know this:

  - The FlexForms will be ignored, because the AJAX-call does not know the plugin.

  - **Configure the quiz only by TypoScript**.

  - The AJAX-call calls an normal action and not an eID-script. The cHash-check must therefore be disabled in the install tool.


Property details
^^^^^^^^^^^^^^^^

.. only:: html

	.. contents::
		:local:
		:depth: 1


.. _ts-plugin-tx-extensionkey-stdwrap:

allWrap
"""""""

:typoscript:`plugin.tx_extensionkey.allWrap =` :ref:`t3tsref:data-type-wrap`

Wraps the whole item.


.. _ts-plugin-tx-extensionkey-wrapitemandsub:

wrapItemAndSub
""""""""""""""

:typoscript:`plugin.tx_extensionkey.wrapItemAndSub =` :ref:`t3tsref:data-type-wrap`

Wraps the whole item and any submenu concatenated to it.


.. _ts-plugin-tx-extensionkey-substelementUid:

subst_elementUid
""""""""""""""""

:typoscript:`plugin.tx_extensionkey.subst_elementUid =` :ref:`t3tsref:data-type-boolean`

If set, all appearances of the string ``{elementUid}`` in the total
element html-code (after wrapped in allWrap_) are substituted with the
uid number of the menu item. This is useful if you want to insert an
identification code in the HTML in order to manipulate properties with
JavaScript.


.. _configuration-faq:

FAQ
---

Possible subsection: FAQ
