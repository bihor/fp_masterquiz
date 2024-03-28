<?php

namespace Fixpunkt\FpMasterquiz\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
class QuizRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];

    
    /**
     * Sets the initial query settings: nicht nötig
    public function initializeObject()
    {
        * var QuerySettingsInterface $querySettings *
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(true);
        $querySettings->setLanguageOverlayMode(false);
        $this->setDefaultQuerySettings($querySettings);
    }
    */

    /**
     * Get the localized uid
     *
     * @param	integer	$defaultQuizUid	  quiz-uid
     * @param	integer	$sys_language_uid language-uid
     * @return  integer
     */
    public function getMyLocalizedUid(int $defaultQuizUid, int $sys_language_uid)
    {
        /*
        $query = $this->createQuery();
        //$query->getQuerySettings()->setReturnRawQueryResult(TRUE); // funktioniert leider nicht
        $query->matching(
            $query->logicalAnd(
                $query->equals('l10n_parent', $defaultQuizUid),
                $query->equals('sys_language_uid', $sys_language_uid)
            )
        );
        $result = $query->execute()->getFirst();
        if ($result) {
            return $result->getUid();
        } else {
            return 0;
        }
        */
        $uid = 0;
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_quiz');
        $statement = $queryBuilder
            ->select('uid')
            ->from('tx_fpmasterquiz_domain_model_quiz')
            ->where(
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($defaultQuizUid, \PDO::PARAM_INT))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($sys_language_uid, \PDO::PARAM_INT))
            )
            ->setMaxResults(1)
            ->executeQuery();
        while ($row = $statement->fetch()) {
            $uid = $row['uid'];
        }
        return $uid;
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
     * Fetches quizzes with other languages
     *
     * @param	integer	$uid quiz-uid
     * @return  array
     */
    public function findFormUidAndPidOtherLanguages(int $uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_quiz');
        $statement = $queryBuilder
            ->select('*')
            ->from('tx_fpmasterquiz_domain_model_quiz')
            ->where(
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->executeQuery();
        return $statement->fetchAllAssociative();
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
