<?php

namespace Fixpunkt\FpMasterquiz\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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
 * The repository for Participants
 */
class ParticipantRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Fetches entries of a folder.
     *
     * @param	integer	$pageId	Page-UID
     * @return	array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFromPid($pageId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            'tstamp' => QueryInterface::ORDER_DESCENDING
        ]);
        $query->matching($query->equals('pid', $pageId));
        return $query->execute();
    }

    /**
     * Fetches entries of a folder and quiz.
     *
     * @param	integer	$pageId	Page-UID
     * @param	integer	$quizId	Quiz-UID
     * @return	array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFromPidAndQuiz($pageId, $quizId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            'tstamp' => QueryInterface::ORDER_DESCENDING
        ]);
        $query->matching(
            $query->logicalAnd(
                $query->equals('pid', $pageId),
                $query->equals('quiz', $quizId)
            )
        );
        return $query->execute();
    }

    /**
     * Fetches entries of a quiz with a limit.
     *
     * @param integer $quizId Quiz-UID
     * @param integer $limit Limit for highscore
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFromQuizLimit(int $quizId, $limit = 10)
    {
        $query = $this->createQuery();
        $query->setOrderings([
            'points' => QueryInterface::ORDER_DESCENDING
        ]);
        $query->matching(
            $query->equals('quiz', $quizId)
        )->setLimit($limit);
        return $query->execute();
    }

    /**
     * Fetches entries for a quiz and user.
     *
     * @param integer $userId FEuser-UID
     * @param integer $quizId Quiz-UID
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findOneByUserAndQuiz($userId, $quizId)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('user', $userId),
                $query->equals('quiz', $quizId)
            )
        );
        return $query->execute()->getFirst();
    }

    /**
     * Fetches a entry for a pid and user.
     *
     * @param integer $userId FEuser-UID
     * @param integer $quizId Quiz-PID
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findOneByUidAndPid($userId, $quizPid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                $query->equals('uid', $userId),
                $query->equals('pid', $quizPid)
            )
        );
        return $query->execute()->getFirst();
    }
}
