# fp_masterquiz

version 7.0.6

TYPO3 extension to create a quiz, poll or test. The participant result will be saved in the DB too and can be deleted automatically via Scheduler.

The results can be displayed as a chart too. An evaluation is possible too.

Features: a quiz, poll or test can be played by submitting a form or by submitting an AJAX-request.

8 question types/modes available: checkbox, radio-box, select-box, yes/no, text-field, textarea, star-rating, matrix.

jQuery is required. Optimized for Bootstrap 4/5.

Dashboard widget available.

CSV-export available via scheduler task.

Available languages: english and german/deutsch.

You find the documentation at typo3.org:
https://docs.typo3.org/p/fixpunkt/fp-masterquiz/master/en-us/


Changes in version 7.0.0:
- Breaking: PlugIns changed from list_type to CType. You need to execute the Upgrade Wizard to change your PlugIns.
- Breaking: due to a TYPO3 bug (issues/105135), the Ajax-Version is not working anymore!
- Breaking: layout changed: fieldset added to questions and user data in the form and settings.wrapQuestionTitle1 changed to legend.
- Documentation translated to german.

Changes in 7.0.1:
- Bugfix: the Ajax-version is now working again.

Changes in 7.0.2/3:
- Bugfix: documentation.

Changes in 7.0.4/5:
- Bugfix: get FE-users entry + get foreign entries.
- Bootstrap: added class text-end where text-right is used.

Changes in 7.0.6:
- Startingpoint added again to a plugin.
- pluginName in the list-view changed to show, if a target page is defined.
- Bugfix: documentation.

You find the whole changelog here:
https://raw.githubusercontent.com/bihor/fp_masterquiz/refs/heads/master/Documentation/ChangeLog/Index.rst
