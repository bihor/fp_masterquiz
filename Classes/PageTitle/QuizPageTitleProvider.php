<?php
declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

final class QuizPageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
