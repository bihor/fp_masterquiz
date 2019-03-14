plugin.tx_fpmasterquiz {
    view {
        # cat=plugin.tx_fpmasterquiz/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:fp_masterquiz/Resources/Private/Templates/
        # cat=plugin.tx_fpmasterquiz/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:fp_masterquiz/Resources/Private/Partials/
        # cat=plugin.tx_fpmasterquiz/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:fp_masterquiz/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_fpmasterquiz//1; type=string; label=Default storage PID
        storagePid =
		# cat=plugin.tx_fpmasterquiz//2; type=int+; label=Recursive mode: The number of subpage levels which are searched for records.
        recursive =
    }
	settings {
        # cat = plugin.tx_fpmasterquiz//3; type=int+; label=typeNum for AJAX call
        typeNum = 190675
    }
}

module.tx_fpmasterquiz_mod1 {
    view {
        # cat=module.tx_fpmasterquiz_mod1/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:fp_masterquiz/Resources/Private/Backend/Templates/
        # cat=module.tx_fpmasterquiz_mod1/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:fp_masterquiz/Resources/Private/Backend/Partials/
        # cat=module.tx_fpmasterquiz_mod1/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:fp_masterquiz/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_fpmasterquiz_mod1//a; type=string; label=Default storage PID
        storagePid =
    }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder