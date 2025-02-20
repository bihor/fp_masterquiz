.. include:: ../../../Includes.txt

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


Seiten-TSconfig
^^^^^^^^^^^^^^^

- Man kann die Seiten-TSconfig verwenden, um einige Template-Layouts zu definieren.
  Derzeit verarbeiten die Templates standardmäßig 3 verschiedene Layouts.

Beispiel
~~~~~~~~

Hier ein Beispiel mit 3 Layouts, die bereits in den Templates behandelt werden:

::

  tx_fpmasterquiz.templateLayouts {
    0 = Standard-Layout
    1 = Layout for a poll with a pie chart
    2 = Detailed quiz/poll-results at a result-page
  }


- Man kann jede beliebige Nummer und Beschreibung für die Layouts verwenden.
- Jetzt kann man im FlexForm des Plugins ein Layout auswählen.
- Schließlich kann man jetzt verschiedene Layouts in den Templates verwenden (0-2 werden bereits standardmäßig verwendet).

Beispiel
~~~~~~~~

Hier ein Beispiel für ein Template mit 2 Layouts:

::

	<f:if condition="{settings.templateLayout} == 1">
		<f:then>
			show a pie chart
		</f:then>
		<f:else>
			show only text
		</f:else>
	</f:if>

Hinweis: Standardmäßig lädt das Template JavaScript von cdn.jsdelivr.net, wenn man templateLayout 1 verwendet.
Dann werden die Ergebnisse als Diagramm angezeigt. Dabei wird Apexcharts verwendet.
Hier findet man weitere Informationen zu Apexcharts:
https://apexcharts.com/

- Darüber hinaus kann man TSconfig verwenden, um Quizfelder im BE umzubenennen oder auszublenden. Hier zwei Beispiele:

::

   TCEFORM.tx_fpmasterquiz_domain_model_question.explanation.disabled = 1
   TCEFORM.tx_fpmasterquiz_domain_model_quiz.about.label = Description for the list view

Man findet das TSconfig, wenn man eine Seite bearbeitet. Gehe zm Tab Ressources.
