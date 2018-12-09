plugin.tx_fpmasterquiz {
    view {
        templateRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_fpmasterquiz.view.templateRootPath}
        partialRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_fpmasterquiz.view.partialRootPath}
        layoutRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_fpmasterquiz.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_fpmasterquiz.persistence.storagePid}
        recursive = {$plugin.tx_fpmasterquiz.persistence.recursive}
    }
    features {
        skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 0
    }
    mvc {
        callDefaultActionIfActionCantBeResolved = 1
    }
	settings {
		startPageUid = 1
		defaultQuizUid = 1
		showAnswerPage = 1
		showCorrectAnswers = 1
		showPoints = 1
		ajax = 0
		user {
			ipSave = 1
			ipAnonymous = 1
			askForData = 0
			defaultName = default {TIME}
			defaultEmail =
			defaultHomepage =
		}
		pagebrowser {
			itemsPerPage         = 1
			insertAbove          = 0
			insertBelow          = 0
			maximumNumberOfLinks = 50
		}
		overrideFlexformSettingsIfEmpty = startPageUid,defaultQuizUid,pagebrowser.itemsPerPage
		debug = 0
		typeNum = {$plugin.tx_fpmasterquiz.settings.typeNum}
	}
}

# PAGE object for Ajax call:
ajaxfpmasterquiz_page = PAGE
ajaxfpmasterquiz_page {
    typeNum = {$plugin.tx_fpmasterquiz.settings.typeNum}
    config {
        disableAllHeaderCode = 1
        additionalHeaders = Content-type:application/html
        xhtml_cleaning = 0
        debug = 0
        no_cache = 1
        admPanel = 0
    }
    10 < tt_content.list.20.fpmasterquiz_pi1
}