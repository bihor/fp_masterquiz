.. include:: ../../Includes.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Page TSconfig
^^^^^^^^^^^^^

- You can use the Page TSconfig to define some template layouts.

Example
~~~~~~~

Here an example with 2 layouts for your templates:

::

  tx_fpmasterquiz.templateLayouts {
    0 = Standard-Layout
    1 = Layout for a poll with a pie chart
  }


- You can use every number and description for the layouts.
- Now you can select a layout in the FlexForm of every page.
- Finally you can use now different layouts in your templates.

Example
~~~~~~~

Here an example for a template (extract) with 2 layouts:

::

	<f:if condition="{settings.templateLayout} == 1">
		<f:then>
			show a pie chart
		</f:then>
		<f:else>
			show only text
		</f:else>
	</f:if>

- Furthermore you can use TSconfig to rename or hide quiz-fields. Here two examples:

::

   TCEFORM.tx_fpmasterquiz_domain_model_question.explanation.disabled = 1
   TCEFORM.tx_fpmasterquiz_domain_model_quiz.about.label = Description for the list view

You find the TSconfig when you edit a page. Go to the tab Ressources.