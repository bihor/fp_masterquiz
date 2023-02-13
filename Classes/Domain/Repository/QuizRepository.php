<?php

namespace Fixpunkt\FpMasterquiz\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
 *
 ***/

/**
 * The repository for Quizzes
 */
class QuizRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];

    
    /**
     * Sets the initial query settings
     * @return void
     */
    public function initializeObject()
    {
        /** @var QuerySettingsInterface $querySettings */
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);

        $querySettings->setRespectStoragePage(false);
        $querySettings->setLanguageOverlayMode(false);

        $this->setDefaultQuerySettings($querySettings);
    }


    /**
     * Fetches entries of a folder.
     *
     * @return array|QueryResultInterface
     */
    public function findFromPid($pageId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            'sorting' => QueryInterface::ORDER_ASCENDING
        ]);
        $query->matching($query->equals('pid', $pageId));
        return $query->execute();
    }

    /**
     * Get the PIDs
     *
     * @return array
     */
    public function getStoragePids()
    {
        $query = $this->createQuery();
        return $query->getQuerySettings()->getStoragePageIds();
    }
}
