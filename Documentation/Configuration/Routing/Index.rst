.. include:: /Includes.rst.txt


Frontend Routing Setup
^^^^^^^^^^^^^^^^^^^^^^

The extension provides a frontend route enhancer configuration that you can include
in your site configuration `config/sites/mysite/config.yaml`.

.. code-block:: yaml

   imports:
     - { resource: "EXT:fp_masterquiz/Configuration/Routes/Default.yaml" }

Feel free to modify or enhance this configuration.

Note: every quiz must have set the path segment before you can use this feature!


Example
~~~~~~~

You write your own frontend route configuration by adding the following to your site configuration::

  routeEnhancers:
    QuizPlugin:
      type: Extbase
      limitToPages:
        - 410
      extension: FpMasterquiz
      plugin: Show
      routes:
        - { routePath: '/', _controller: 'Quiz::list' }
        -
          routePath: '/quiz/{quiz_title}'
          _controller: 'Quiz::show'
          _arguments:
            quiz_title: quiz
        -
          routePath: '/result/{quiz_title}'
          _controller: 'Quiz::result'
          _arguments:
            quiz_title: quiz
      defaultController: 'Quiz::list'
      aspects:
        quiz_title:
          type: PersistedAliasMapper
          tableName: tx_fpmasterquiz_domain_model_quiz
          routeFieldName: path_segment
