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
 * The repository for Selecteds
 */
class SelectedRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
        'tstamp' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * Fetches entries of a folder.
     *
     * @param integer $pageId Page-UID
     * @return    array|QueryResultInterface
     */
    public function findFromPid($pageId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            'tstamp' => QueryInterface::ORDER_ASCENDING
        ]);
        $query->matching($query->equals('pid', $pageId));
        return $query->execute();
    }

    /**
     * Fetches entries of a folder and question.
     *
     * @param integer $pageId Page-UID
     * @param integer $questionId Question-UID
     * @return    array|QueryResultInterface
     */
    public function findFromPidAndQuestion($pageId, $questionId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            'tstamp' => QueryInterface::ORDER_ASCENDING
        ]);
        $query->matching(
            $query->logicalAnd(
                $query->equals('pid', $pageId),
                $query->equals('question', $questionId)
            )
        );
        return $query->execute();
    }

    /**
     * Fetches no. of a participant and question.
     *
     * @param integer $participantId Participant-UID
     * @param integer $questionId Question-UID
     * @return    integer
     */
    public function countByParticipantAndQuestion($participantId, $questionId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                $query->equals('participant', $participantId),
                $query->equals('question', $questionId)
            )
        );
        return $query->execute()->count();
    }

    /**
     * Fetches no. of a participant and question.
     *
     * @param integer $participantId Participant-UID
     * @param integer $questionId Question-UID
     * @return    array|QueryResultInterface
     */
    public function findByParticipantAndQuestion($participantId, $questionId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                $query->equals('participant', $participantId),
                $query->equals('question', $questionId)
            )
        );
        return $query->execute()->getFirst();
    }

    /**
     * Delete entry for participant and question. Wird doch nicht gebraucht!
     *
     * @param integer $participantId Participant-UID
     * @param integer $questionId Question-UID
     */
    public function deleteByParticipantAndQuestion($participantId, $questionId)
    {
        $table = 'tx_fpmasterquiz_domain_model_selected';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $rows = $queryBuilder
            ->select('uid')
            ->from($table)
            ->where(
                $queryBuilder->expr()->and(
                    $queryBuilder->expr()->eq('participant', $queryBuilder->createNamedParameter($participantId, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('question', $queryBuilder->createNamedParameter($questionId, \PDO::PARAM_INT))
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
        foreach ($rows as $row) {
            GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table)
                ->delete(
                    $table,
                    ['uid' => (int)$row['uid']]
                );
            GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_fpmasterquiz_selected_answer_mm')
                ->delete(
                    'tx_fpmasterquiz_selected_answer_mm',
                    ['uid_local' => (int)$row['uid']]
                );
        }
    }

    /**
     * Delete specific entry (after edit)
     *
     * @param integer $uid UID
     */
    public function deleteSelection($uid)
    {
        $table = 'tx_fpmasterquiz_domain_model_selected';
        GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table)
            ->delete(
                $table,
                ['uid' => (int)$uid]
            );
        GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_fpmasterquiz_selected_answer_mm')
            ->delete(
                'tx_fpmasterquiz_selected_answer_mm',
                ['uid_local' => (int)$uid]
            );
    }
}
