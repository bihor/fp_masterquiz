<?php
namespace Fixpunkt\FpMasterquiz\Task;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\BackendWorkspaceRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

class DeleteParticipantTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Uid of the folder
	 *
	 * @var integer
	 */
	protected $page = 0;

	/**
	 * Days
	 *
	 * @var integer
	 */
	protected $days = 0;
	
	
	/**
	 * Get the value of the protected property page
	 *
	 * @return integer UID of the start page for this task
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * Set the value of the private property page
	 *
	 * @param integer $page UID of the start page for this task.
	 * @return void
	 */
	public function setPage($page) {
		$this->page = $page;
	}
	
	/**
	 * Set the value of the private property page
	 *
	 * @param integer $days
	 * @return void
	 */
	public function setDays($days) {
		$this->days = $days;
	}

	/**
	 * Get the value of the protected property page
	 *
	 * @return integer days
	 */
	public function getDays() {
		return $this->days;
	}
	
	
	public function execute() {
		$successfullyExecuted = TRUE;
		$pid = (int) $this->getPage();			// folder with participant elements
		$days = (int) $this->getDays();			// number of days
		$now = time();
		$past = time() - ($days * 24 * 60 * 60);
		$participantArray = [];
		//$where = 'pid=' . $pid . ' AND crdate<' . $past;
		
		// select all participant elements of one folder, denn es gibt irgendwie kein delete cascade
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
		$statement = $queryBuilder
		   ->select('uid')
		   ->from('tx_fpmasterquiz_domain_model_participant')
		   ->where(
		   		$queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT))
		   	)
		   	->andWhere(
		   		$queryBuilder->expr()->lt('crdate', $queryBuilder->createNamedParameter($past, \PDO::PARAM_INT))
	   		)
		   ->execute();
		while ($row = $statement->fetch()) {
			$participantArray[] = $row['uid'];
		}
		foreach ($participantArray as $participantUid) {
			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_selected');
			$queryBuilder
				->update('tx_fpmasterquiz_domain_model_selected')
				->where(
					$queryBuilder->expr()->eq('participant', $queryBuilder->createNamedParameter($participantUid, \PDO::PARAM_INT))
				)
				->set('deleted', '1')
				->set('tstamp', $now)
				->execute();
			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
			$queryBuilder
				->update('tx_fpmasterquiz_domain_model_participant')
				->where(
					$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($participantUid, \PDO::PARAM_INT))
				)
				->set('deleted', '1')
				->set('tstamp', $now)
				->execute();
		}
		/* alt:
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'uid',
				'tx_fpmasterquiz_domain_model_selected',
				$where,
				'',
				'uid ASC');
		if ($GLOBALS['TYPO3_DB']->sql_num_rows($res) > 0) {
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
				$selectedArray[] = $row['uid'];
			}
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($res);
		
		foreach ($selectedArray as $selectedUid) {
			$GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_selected_answer_mm', 'uid_local=' . intval($selectedUid) );
		}
		$GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_domain_model_selected', $where );
		$GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_domain_model_participant', $where );
		*/
		return $successfullyExecuted;
	}
}