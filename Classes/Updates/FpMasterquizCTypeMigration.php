<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Fixpunkt\FpMasterquiz\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

/**
 * With TYPO3 13 all plugins have to be declared as content elements (CType) insteadof "list_type"
 */
#[UpgradeWizard('fpMasterquizCTypeMigration')]
final class FpMasterquizCTypeMigration extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'fpmasterquiz_list' => 'fpmasterquiz_list',
            'fpmasterquiz_show' => 'fpmasterquiz_show',
            'fpmasterquiz_showbytag' => 'fpmasterquiz_showbytag',
            'fpmasterquiz_intro' => 'fpmasterquiz_intro',
            'fpmasterquiz_closure' => 'fpmasterquiz_closure',
            'fpmasterquiz_result' => 'fpmasterquiz_result',
            'fpmasterquiz_highscore' => 'fpmasterquiz_highscore'
        ];
    }

    public function getTitle(): string
    {
        return 'Migrate "Masterquiz" plugins to content elements (CType).';
    }

    public function getDescription(): string
    {
        return 'The "Masterquiz" plugin is now registered as content element. Update migrates existing records and backend user permissions.';
    }
}
