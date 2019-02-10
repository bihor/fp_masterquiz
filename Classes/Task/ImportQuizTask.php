<?php
namespace Fixpunkt\FpMasterquiz\Task;

class ImportQuizTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	
	/**
	 * Uid of the folder
	 *
	 * @var integer
	 */
	protected $page = 0;

	/**
	 * Uid of the language
	 *
	 * @var integer
	 */
	protected $language = 0;	

	/**
	 * Simulate only?
	 *
	 * @var integer
	 */
	protected $simulate = 0;
	
	
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
	 * Get the value of the protected property language
	 *
	 * @return integer UID of the language for this task
	 */
	public function getLanguage() {
		return $this->language;
	}
	
	/**
	 * Set the value of the private property language
	 *
	 * @param integer $page UID of the language for this task.
	 * @return void
	 */
	public function setLanguage($language) {
		$this->language = $language;
	}
	
	/**
	 * Get the value of the protected property simulate
	 *
	 * @return integer
	 */
	public function getSimulate() {
		return $this->simulate;
	}
	
	/**
	 * Set the value of the private property simulate
	 *
	 * @param integer $simulate
	 * @return void
	 */
	public function setSimulate($simulate) {
		$this->simulate = ($simulate) ? 1 : 0;
	}
	
	
	public function execute() {
		$successfullyExecuted = TRUE;
		$insert = array();
		$pid = (int) $this->getPage();			// folder with CD elements
		$syslanguid = (int) $this->getLanguage();	// sys_language_uid ID
		$simulate = ($this->getSimulate()) ? TRUE : FALSE;	// simulate import?
		
		// Import
		$selectedArray = array();
		// select all participant elements of one folder
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
		    '*',
		    'tx_myquizpoll_question',
		    'deleted=0 AND hidden=0 AND t3ver_oid=0 AND pid=' . $pid . ' AND sys_language_uid=' . $syslanguid,
		    '',
		    'sorting ASC'
		);
		if ($GLOBALS['TYPO3_DB']->sql_num_rows($res) > 0) {
		   while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
		       $selectedArray[] = $row;
		   }
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($res);
		
		if ( count($selectedArray) > 0 ) {
			$nr=0;
			$fields_values = array();
			$fields_values['pid'] = $pid;
			$fields_values['tstamp'] = time();
			$fields_values['sys_language_uid'] = $syslanguid;
			$fields_values['cruser_id'] = $GLOBALS['BE_USER']->user["uid"];
			
			// Quiz einfügen
			$quiz_values = $fields_values;
			$answer_values = $fields_values;
			$quiz_values['crdate'] = time();
			$quiz_values['name'] = 'Import-Quiz';
			$quiz_values['questions'] = count($selectedArray);
			$quiz_values['sorting'] = 128;
			if ($simulate) {
			    $success_insert = TRUE;
			} else {
			    $success_insert = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_fpmasterquiz_domain_model_quiz', $quiz_values);
			}
			if ($success_insert) {
			    $quiz_uid = ($simulate) ? 1 : $GLOBALS['TYPO3_DB']->sql_insert_id();
			    if ($quiz_uid) {
			        // Fragen einfügen
			        foreach ($selectedArray as $entry) {
			            $fields_values['crdate'] = $entry['crdate'];
			            $fields_values['sorting'] = $entry['sorting'];
			            $fields_values['l10n_parent'] = 0;   // kennen wir nicht wirklich
			            $fields_values['title'] = $entry['title'];
			            $fields_values['bodytext'] = $entry['name'];
			            $fields_values['qmode'] = $entry['qtype'];
			            $fields_values['explanation'] = $entry['explanation'];
			            $fields_values['quiz'] = $quiz_uid;
			            $nr=0;
			            for ($i=1; $i<=6; $i++) {
			                if ($entry['answer' . $i]) {
			                    $nr++;
			                }
			            }
			            $fields_values['answers'] = $nr;
			            $insert[] = $fields_values;
			            if (!$simulate) {
			                $success_insert = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_fpmasterquiz_domain_model_question', $fields_values);
			                if ($success_insert) {
			                    // Antworten einfügen
			                    $question_uid = $GLOBALS['TYPO3_DB']->sql_insert_id();
			                    if ($question_uid) {
			                        for ($i=1; $i<=6; $i++) {
			                            if ($entry['answer' . $i]) {
			                                $points = $entry['points' . $i];
			                                if (!$points && $entry['correct' . $i]) {
			                                    $points = $entry['points'];
			                                }
			                                $answer_values['crdate'] = $entry['crdate'];
			                                $answer_values['sorting'] = $i * 128;
			                                $answer_values['l10n_parent'] = 0;   // is unknown
			                                $answer_values['title'] = $entry['answer' . $i];
			                                $answer_values['points'] = $points;
			                                $answer_values['question'] = $question_uid;
			                                $success_insert = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_fpmasterquiz_domain_model_answer', $answer_values);
			                                if (!$selectedArray) {
			                                    $successfullyExecuted = FALSE;
			                                }
			                            }
			                        }
			                    } else {
			                        $successfullyExecuted = FALSE;
			                    }
			                } else {
			                    $successfullyExecuted = FALSE;
			                }
			            }
			        }
			    } else {
			        $successfullyExecuted = FALSE;
			    }
			} else {
			    $successfullyExecuted = FALSE;
			}

			if ($simulate) {
				$output = $this->build_table($insert);
				$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
						$output,
						'Simulation:', // the header is optional
						\TYPO3\CMS\Core\Messaging\FlashMessage::INFO,
						FALSE
				);
				$flashMessageService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessageService');
				$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
				$messageQueue->addMessage($message);
			}
		} else {
			$successfullyExecuted = FALSE;
		}
		return $successfullyExecuted;
	}
	
	/**
	 * Aray nach Tabelle
	 *
	 * @return	string
	 */
	function build_table($array){
		// start table
		$html = '<style>table tr th, table tr td {padding:3px;border:1px solid #666;}</style><table class="dump">';
		// header row
		$html .= '<tr>';
		foreach($array[0] as $key=>$value){
			$html .= '<th>' . $key . '</th>';
		}
		$html .= '</tr>';
	
		// data rows
		foreach( $array as $value){
			$html .= '<tr>';
			foreach($value as $value2){
				$html .= '<td>' . strip_tags($value2) . '</td>';
			}
			$html .= '</tr>';
		}
	
		// finish table and return it
		$html .= '</table>';
		return $html;
	}
}