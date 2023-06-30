<?php

namespace Fixpunkt\FpMasterquiz\Domain\Repository;

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
 * The repository for Questions
 */
class QuestionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * Fetches questions of with no relation.
     *
     * @return array|QueryResultInterface
     */
    public function findLostQuestions($pageId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                $query->equals('pid', $pageId),
                $query->equals('quiz', 0)
            )
        );
        return $query->execute();
    }

    /**
     * Find questions from other quizzes
     *
     * @return array|QueryResultInterface
     */
    public function findOtherThan($pageId, $quizID)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                $query->equals('pid', $pageId),
                $query->logicalNot($query->equals('quiz', $quizID))
            )
        );
        return $query->execute();
    }

    /**
     * Move a question
     *
     * @param integer $questionID Question
     * @param integer $quizID Quiz
     */
    public function moveToQuiz($questionID, $quizID)
    {
        $table = 'tx_fpmasterquiz_domain_model_question';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder
            ->update($table)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($questionID, \PDO::PARAM_INT))
            )
            ->set('quiz', intval($quizID))
            ->executeStatement();
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
