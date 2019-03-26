<?php
namespace Fixpunkt\FpMasterquiz\Task;

class CsvImportTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * CSV file
	 *
	 * @var string
	 */
	protected $csvfile;

	/**
	 * Fields to export
	 *
	 * @var string
	 */
	protected $fields;
	
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
	 * Separator
	 *
	 * @var string
	 */
	protected $separator;

	/**
	 * Delimiter
	 *
	 * @var string
	 */
	protected $delimiter;

	/**
	 * Convert from UTF-8 to ISO?
	 *
	 * @var integer
	 */
	protected $convert = 0;

	/**
	 * Delete entries first?
	 *
	 * @var integer
	 */
	protected $delete = 0;

	/**
	 * Simulate only?
	 *
	 * @var integer
	 */
	protected $simulate = 0;
	
	
	/**
	 * Get the value of the csv file
	 *
	 * @return string
	 */
	public function getCsvfile() {
		return $this->csvfile;
	}

	/**
	 * Set the value of the private property csvfile.
	 *
	 * @param string $csvfile Path to the csv file
	 * @return void
	 */
	public function setCsvfile($csvfile) {
		$this->csvfile = $csvfile;
	}
	
	/**
	 * Get the value of fields
	 *
	 * @return string
	 */
	public function getFields() {
		return $this->fields;
	}
	
	/**
	 * Set the value of the private property fields.
	 *
	 * @param string $fields Fields to export
	 * @return void
	 */
	public function setFields($fields) {
		$this->fields = $fields;
	}
	
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
	 * Get the separator
	 *
	 * @return string
	 */
	public function getSeparator() {
		return $this->separator;
	}
	
	/**
	 * Set the value of the separator
	 *
	 * @param string $separator
	 * @return void
	 */
	public function setSeparator($separator) {
		$this->separator = $separator;
	}

	/**
	 * Get the delimiter
	 *
	 * @return string
	 */
	public function getDelimiter() {
		return $this->delimiter;
	}
	
	/**
	 * Set the value of the delimiter
	 *
	 * @param string $delimiter
	 * @return void
	 */
	public function setDelimiter($delimiter) {
		$this->delimiter = $delimiter;
	}
	
	/**
	 * Get the value of the protected property convert
	 *
	 * @return integer
	 */
	public function getConvert() {
		return $this->convert;
	}
	
	/**
	 * Set the value of the private property convert
	 *
	 * @param integer $convert
	 * @return void
	 */
	public function setConvert($convert) {
		$this->convert = ($convert) ? 1 : 0;
	}

	/**
	 * Get the value of the protected property delete
	 *
	 * @return integer
	 */
	public function getDelete() {
		return $this->delete;
	}
	
	/**
	 * Set the value of the private property delete
	 *
	 * @param integer $delete
	 * @return void
	 */
	public function setDelete($delete) {
		$this->delete = ($delete) ? 1 : 0;
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
		$ln = "\r\n";							// line break
		$pid = (int) $this->getPage();			// folder with CD elements
		$syslanguid = (int) $this->getLanguage();	// sys_language_uid ID
		$separator = $this->getSeparator();		// Texttrenner
		$delimiter = $this->getDelimiter();		// Feldtrenner
		$convert = ($this->getConvert()) ? TRUE : FALSE;	// convert from ASCII to UTF-8?
		$delete = ($this->getDelete()) ? TRUE : FALSE;		// delete entries first?
		$simulate = ($this->getSimulate()) ? TRUE : FALSE;	// simulate import?
		$fields = $this->getFields();			// fields for import
		$fields_names = explode(',', $fields);	// field-array
		
		// files sortiert nach Name, dann umkehren
		$path = PATH_site . $this->getCsvfile();
		$files = array_filter(glob($path), 'is_file');
		$total = count($files);
		if ($total > 1) $files = array_reverse($files);
		$newestFile = '';
		foreach ($files as $file) {
			$newestFile = $file;				// take only the first found file
			break;
		}
		if (!$newestFile) {
			return FALSE;	// keine Datei gefunden
		}
		
		if ($delete && !$simulate) {
			// erst löschen
			/*
			$res = $GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_domain_model_quiz', 'pid=' . $pid . ' AND sys_language_uid=' . $syslanguid );
			$res = $GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_domain_model_question', 'pid=' . $pid . ' AND sys_language_uid=' . $syslanguid );
			$res = $GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_domain_model_answer', 'pid=' . $pid . ' AND sys_language_uid=' . $syslanguid );
			$res = $GLOBALS['TYPO3_DB']->exec_DELETEquery( 'tx_fpmasterquiz_domain_model_evaluation', 'pid=' . $pid . ' AND sys_language_uid=' . $syslanguid );
			*/
		}
		
		// Import
		$lines = array();
		if ($newestFile)
			$lines = file($newestFile);
		if ( count($lines) > 1 ) {
			$nr=0;
			$fields_values = array();
			$fields_values['pid'] = $pid;
			$fields_values['tstamp'] = time();
			$fields_values['crdate'] = time();
			$fields_values['sys_language_uid'] = $syslanguid;
			$fields_values['cruser_id'] = $GLOBALS['BE_USER']->user["uid"];
			$handle = fopen ($newestFile, "r");              // Datei zum Lesen oeffnen

			if ($separator) {
				while ( ($fields_read = fgetcsv ($handle, 2000, $delimiter, $separator)) !== FALSE ) {
					if ($nr==0) {
						//$fields_names = $Felder;
					} else if ($fields_read[0]) {
						$result = $this->insertLine($fields_names, $fields_values, $fields_read, $simulate, $convert);
						if ($simulate) {
							$insert[] = $result;
						} else if (!$result) {
							$successfullyExecuted = FALSE;
						}
					}
					$nr++;
				}
			} else {
				while ( ($fields_read = fgetcsv ($handle, 2000, $delimiter)) !== FALSE ) {
					if ($nr==0) {
						//$fields_names = $Felder;
					} else if ($fields_read[0]) {
						$result = $this->insertLine($fields_names, $fields_values, $fields_read, $simulate, $convert);
						if ($simulate) {
							$insert[] = $result;
						} else if (!$result) {
							$successfullyExecuted = FALSE;
						}
					}
					$nr++;
				}
			}
			
			fclose ($handle);
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
	 * Inserts a line to the database
	 *
	 * @return	mixed
	 */
	function insertLine($names, $values, $fields, $simulate, $convert) {
		$success_global = TRUE;
		for ($i=0; $i<count($names); $i++) {
			$feld = trim($names[$i]);
			
				if ($convert) {
					$values[$feld] = trim(iconv('iso-8859-1','utf-8',$fields[$i]));
				} else {
					$values[$feld] = trim($fields[$i]);
				}
			
		}
		if (!$simulate) {
			/*
			$success_insert = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_fpmasterquiz_domain_model_question', $values);
			if ($success_insert) {
				$values['uid'] = $GLOBALS['TYPO3_DB']->sql_insert_id();
			} else {
				$values['uid'] = 0;
				$success_global = FALSE;
			}
			*/
		} else {
			$values['uid'] = 0;
		}
		
		if ($simulate) {
			return $values;
		} else {
			return $success_global;
		}
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
		foreach( $array as $key=>$value){
			$html .= '<tr>';
			foreach($value as $key2=>$value2){
				$html .= '<td>' . strip_tags($value2) . '</td>';
			}
			$html .= '</tr>';
		}
	
		// finish table and return it
		$html .= '</table>';
		return $html;
	}
}