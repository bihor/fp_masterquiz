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
		startPageUid =
		showPageUid =
		resultPageUid =
		defaultQuizUid = 1
		showAnswerPage = 1
		showOwnAnswers = 1
		showCorrectAnswers = 1
		showEveryAnswer = 0
		showAnswersAtFinalPage = 1
		showAllAnswers = 1
		showPoints = 1
		showPageNo = 1
		showQuestionNo = 0
		checkAllStars = 0
		allowHtml = 0
		joker = 0
		ajax = 0
		ajaxType = POST
		setMetatags = 0
		user {
			ipSave = 1
			ipAnonymous = 1
			useCookie = 0
			checkFEuser = 0
			askForData = 0
			defaultName = default {TIME}
			defaultEmail =
			defaultHomepage =
		}
		email {
			adminEmail = 
			adminName = 
			adminSubject = New poll/quiz-result
			userSubject = Your poll/quiz-result
			fromEmail = 
			fromName =
			sendToAdmin = 0
			sendToUser = 0
			# Send e-mail if specific answer(s) (JSON object formatted)
			specific =
			likeFinalPage = 0
		}
		pagebrowser {
			itemsPerPage         = 1
			insertAbove          = 0
			insertBelow          = 0
			maximumNumberOfLinks = 50
		}
		template {
			colText = col-md-8
			colImage = col-md-4
			wrapQuizTitle1 = <h2>
			wrapQuizTitle2 = </h2>
			wrapQuizDesc1 = <h3>
			wrapQuizDesc2 = </h3>
			wrapQuestionTitle1 = <div class="mx-auto"><h4>
			wrapQuestionTitle2 = </h4></div>
			wrapQuestionDesc1 = <div class="mx-auto">
			wrapQuestionDesc2 = </div>
			wrapDone1 = <h4>
			wrapDone2 = </h4>
		}
		chart {
			type = pie
			width = 492
		}
		templateLayout =
		overrideFlexformSettingsIfEmpty = startPageUid,showPageUid,resultPageUid,defaultQuizUid,templateLayout,pagebrowser.itemsPerPage
		debug = 0
		typeNum = {$plugin.tx_fpmasterquiz.settings.typeNum}
	}
}

# Module configuration
module.tx_fpmasterquiz_web_fpmasterquizmod1 {
    persistence {
        storagePid = {$module.tx_fpmasterquiz_mod1.persistence.storagePid}
    }
    view {
        templateRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_fpmasterquiz_mod1.view.templateRootPath}
        partialRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_fpmasterquiz_mod1.view.partialRootPath}
        layoutRootPaths.0 = EXT:fp_masterquiz/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_fpmasterquiz_mod1.view.layoutRootPath}
    }
    settings {
		pagebrowser {
           itemsPerPage         = 25
           insertAbove          = 0
           insertBelow          = 1
           maximumNumberOfLinks = 70
		}
		debug = 0
    }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

# PAGE object for Ajax call (you need to add your language settings here too!):
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

# CSS for Star Rating. You can delete it, if you dont need it
page.includeCSS.fpMasterQuizRatingStar = EXT:fp_masterquiz/Resources/Public/Css/RatingStar.css
