<?php
namespace Fixpunkt\FpMasterquiz\Domain\Repository;

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
class SelectedRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
	/**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
    	'tstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];
	
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
			'tstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
		]);
		$query->matching($query->equals('pid', $pageId));
		return $query->execute();
	}
	
	/**
	 * Fetches entries of a folder and question.
	 *
	 * @param	integer	$pageId	Page-UID
	 * @param	integer	$questionId	Question-UID
	 * @return	array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findFromPidAndQuestion($pageId, $questionId)
	{
	    $query = $this->createQuery();
	    $query->getQuerySettings()->setRespectStoragePage(false);
	    $query->setOrderings([
	        'tstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
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
	 * @param	integer	$participantId	Participant-UID
	 * @param	integer	$questionId		Question-UID
	 * @return	integer
	 */
	public function countByParticipantAndQuestion($participantId, $questionId)
	{
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->setOrderings([
			'tstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
		]);
		$query->matching(
			$query->logicalAnd(
				$query->equals('participant', $participantId),
				$query->equals('question', $questionId)
			)
		);
		return $query->execute()->count();
	}
}
