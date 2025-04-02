.. include:: /Includes.rst.txt


Frontend-Routing-Setup
^^^^^^^^^^^^^^^^^^^^^^

Die Erweiterung bietet eine Frontend-Route-Enhancer-Konfiguration, die man in
der Seiten-Konfiguration einbinden kann: `config/sites/mysite/config.yaml`.

.. code-block:: yaml

   imports:
     - { resource: "EXT:fp_masterquiz/Configuration/Routes/Default.yaml" }

Man kann diese Konfiguration jederzeit ändern oder erweitern.

Hinweis: Bei jedem Quiz muss das Pfadsegment festgelegt sein, bevor man diese Funktion nutzen kann!


Beispiel
~~~~~~~~

Die eigene Frontend-Routenkonfiguration fügt man seiner Seiten-Konfiguration zu::

  routeEnhancers:
    QuizPlugin:
      type: Extbase
      limitToPages:
        - 410
      extension: FpMasterquiz
      plugin: Pi1
      routes:
        - { routePath: '/', _controller: 'FpMasterquiz::list' }
        -
          routePath: '/quiz/{quiz_title}'
          _controller: 'FpMasterquiz::show'
          _arguments:
            quiz_title: quiz
        -
          routePath: '/result/{quiz_title}'
          _controller: 'FpMasterquiz::result'
          _arguments:
            quiz_title: quiz
      defaultController: 'FpMasterquiz::list'
      aspects:
        quiz_title:
          type: PersistedAliasMapper
          tableName: tx_fpmasterquiz_domain_model_quiz
          routeFieldName: path_segment
