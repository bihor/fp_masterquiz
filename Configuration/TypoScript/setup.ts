
plugin.tx_fpmasterquiz_pi1 {
    view {
        templateRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_fpmasterquiz_pi1.view.templateRootPath}
        partialRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_fpmasterquiz_pi1.view.partialRootPath}
        layoutRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_fpmasterquiz_pi1.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_fpmasterquiz_pi1.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
	settings {
		startPageUid = 1
		defaultQuizUid = 1
		showAnswerPage = 1
		user {
			ipSave = 0
			ipAnonymous = 0
		}
		pagebrowser {
			itemsPerPage         = 1
			insertAbove          = 0
			insertBelow          = 0
			maximumNumberOfLinks = 50
	}
	}
}
