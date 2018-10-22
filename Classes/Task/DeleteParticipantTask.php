<?php
namespace Fixpunkt\FpMasterquiz\Task;

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
		$past = time() - ($days * 24 * 60 * 60);
		$where = 'pid=' . $pid . ' AND crdate<' . $past;
		$selectedArray = [];
		
		// select all participant elements of one folder
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
		return $successfullyExecuted;
	}
}