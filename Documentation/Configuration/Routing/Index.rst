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
    extension: FpMasterquiz
    plugin: Pi1
    routes:
      - { routePath: '/', _controller: 'FpMasterquiz::list' }
      - { routePath: '/umfrage', _controller: 'FpMasterquiz::show' }
      - routePath: '/umfrage/{quiz_title}'
        _controller: 'FpMasterquiz::show'
        _arguments:
          quiz_title: quiz
    defaultController: 'FpMasterquiz::list'
    requirements:
      tag_title: '^[a-z0-9].*$'
    aspects:
      quiz_title:
        type: PersistedAliasMapper
        tableName: tx_fpmasterquiz_domain_model_quiz
        routeFieldPattern: '^(?P<path_segment>.+)$'
        routeFieldResult: '{path_segment}'
        routeFieldName: path_segment