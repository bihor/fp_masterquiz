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
	 * Flag
	 *
	 * @var integer
	 */
	protected $flag = 0;
	
	
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
	
	/**
	 * Get the value of the protected property flag
	 *
	 * @return integer
	 */
	public function getFlag() {
	    return $this->flag;
	}
	
	/**
	 * Set the value of the private property flag
	 *
	 * @param integer $flag
	 * @return void
	 */
	public function setFlag($flag) {
	    $this->flag = ($flag) ? 1 : 0;
	}
	
	
	public function execute() {
		$successfullyExecuted = TRUE;
		$pid = (int) $this->getPage();			// folder with participant elements
		$days = (int) $this->getDays();			// number of days
		$flag = $this->getFlag();               // delete flag or real delete?
		$now = time();
		$past = time() - ($days * 24 * 60 * 60);
		$participantArray = [];
		$selectedArray = [];
		
		// https://www.clickstorm.de/blog/doctrine-dbal-typo3-version-8/
		// select all participant elements of one folder, denn es gibt irgendwie kein delete cascade
		if ($flag) {
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
    		   ->executeQuery();
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
    				->executeStatement();
    			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
    			$queryBuilder
    				->update('tx_fpmasterquiz_domain_model_participant')
    				->where(
    					$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($participantUid, \PDO::PARAM_INT))
    				)
    				->set('deleted', '1')
    				->set('tstamp', $now)
    				->executeStatement();
    		}
		} else {
		    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_selected');
		    $statement = $queryBuilder
		      ->select('uid')
		      ->from('tx_fpmasterquiz_domain_model_selected')
		      ->where(
		        $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT))
		      )
		      ->andWhere(
		         $queryBuilder->expr()->lt('crdate', $queryBuilder->createNamedParameter($past, \PDO::PARAM_INT))
		      )
		      ->executeQuery();
		    while ($row = $statement->fetch()) {
		        $selectedArray[] = $row['uid'];
		    }
		    
		    $table = 'tx_fpmasterquiz_selected_answer_mm';
		    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		    foreach ($selectedArray as $selectedUid) {
		        $queryBuilder
		          ->delete($table)
    		      ->where(
    		          $queryBuilder->expr()->eq('uid_local', $queryBuilder->createNamedParameter($selectedUid, \PDO::PARAM_INT))
		          )
		          ->executeStatement();
		    }
		    
		    $table = 'tx_fpmasterquiz_domain_model_selected';
		    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		    foreach ($selectedArray as $selectedUid) {
		        $queryBuilder
		          ->delete($table)
		          ->where(
		              $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($selectedUid, \PDO::PARAM_INT))
		          )
		          ->executeStatement();
		    }
		    
		    $table = 'tx_fpmasterquiz_domain_model_participant';
		    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
		    $queryBuilder
		      ->delete($table)
		      ->where(
		          $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT))
		      )
		      ->andWhere(
		          $queryBuilder->expr()->lt('crdate', $queryBuilder->createNamedParameter($past, \PDO::PARAM_INT))
		      )
		      ->executeStatement();
		}
		return $successfullyExecuted;
	}
}