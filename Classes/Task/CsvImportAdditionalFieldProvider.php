<?php
namespace Fixpunkt\FpMasterquiz\Task;

use TYPO3\CMS\Backend\Utility\BackendUtility;

class CsvImportAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {
	
	/**
	 * Render additional information fields within the scheduler backend.
	 *
	 * @param array $taskInfo Array information of task to return
	 * @param ValidatorTask $task Task object
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
	 * @return array Additional fields
	 * @see \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface->getAdditionalFields($taskInfo, $task, $schedulerModule)
	 */
	public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule) {
		$additionalFields = array();
		if (empty($taskInfo['page'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['page'] = '';
			} else {
				$taskInfo['page'] = $task->getPage();
			}
		}
		if (empty($taskInfo['language'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['language'] = '0';
			} else {
				$taskInfo['language'] = $task->getLanguage();
			}
		}
		if (empty($taskInfo['csvfile'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['csvfile'] = 'fileadmin/';
			} else {
				$taskInfo['csvfile'] = $task->getCsvfile();
			}
		}
		if (empty($taskInfo['fields'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['fields'] = '';
			} else {
				$taskInfo['fields'] = $task->getFields();
			}
		}
		if (empty($taskInfo['separator'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['separator'] = '"';
			} else {
				$taskInfo['separator'] = $task->getSeparator();
			}
		}
		if (empty($taskInfo['delimiter'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['delimiter'] = ';';
			} else {
				$taskInfo['delimiter'] = $task->getDelimiter();
			}
		}
		if (empty($taskInfo['convert'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['convert'] = 0;
			} else {
				$taskInfo['convert'] = $task->getConvert();
			}
		}
		if (empty($taskInfo['delete'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['delete'] = 0;
			} else {
				$taskInfo['delete'] = $task->getDelete();
			}
		}
		if (empty($taskInfo['simulate'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['simulate'] = 0;
			} else {
				$taskInfo['simulate'] = $task->getSimulate();
			}
		}
		
		// Ordner
		$fieldId = 'task_page';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][page]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['page']) . '"/>';
		$label = 'Ordner';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// Sprache
		$fieldId = 'task_language';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][language]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['language']) . '"/>';
		$label = 'Sprache';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// path to csv file
		$fieldId = 'task_csvfile';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][csvfile]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['csvfile']) . '" size="50" />';
		$label = 'CSV-Datei';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// fields in the DB
		$fieldId = 'task_fields';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][fields]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['fields']) . '" size="50" />';
		$label = 'Felder';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// separator
		$fieldId = 'task_separator';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][separator]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['separator']) . '" size="5" />';
		$label = 'Separator';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// delimiter
		$fieldId = 'task_delimiter';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][delimiter]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['delimiter']) . '" size="5" />';
		$label = 'Delimiter';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// convert
		$fieldId = 'task_convert';
		$checked = ($taskInfo['convert']) ? ' checked="checked"' : '';
		$fieldCode = '<input type="checkbox" name="tx_scheduler[fp_masterquiz][convert]" id="' . $fieldId . '" value="1"' . $checked . ' />';
		$label = 'Nach UTF-8 konvertieren?';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// delete
		$fieldId = 'task_delete';
		$checked = ($taskInfo['delete']) ? ' checked="checked"' : '';
		$fieldCode = '<input type="checkbox" name="tx_scheduler[fp_masterquiz][delete]" id="' . $fieldId . '" value="1"' . $checked . ' />';
		$label = 'CDs vorher löschen?';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// simulate
		$fieldId = 'task_simulate';
		$checked = ($taskInfo['simulate']) ? ' checked="checked"' : '';
		$fieldCode = '<input type="checkbox" name="tx_scheduler[fp_masterquiz][simulate]" id="' . $fieldId . '" value="1"' . $checked . ' />';
		$label = 'Nur simulieren?';
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		return $additionalFields;
	}
	
	/**
	 * This method checks any additional data that is relevant to the specific task.
	 * If the task class is not relevant, the method is expected to return TRUE.
	 *
	 * @param array $submittedData Reference to the array containing the data submitted by the user
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
	 * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule) {
		$isValid = TRUE;
		if ($res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'pages', 'uid = ' . (int)$submittedData['fp_masterquiz']['page'])) {
			if ($GLOBALS['TYPO3_DB']->sql_num_rows($res) == 0 && $submittedData['fp_masterquiz']['page'] > 0) {
				$isValid = FALSE;
				$schedulerModule->addMessage(
						'Seite existiert nicht!',
						\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
						);
			}
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		} else {
			$isValid = FALSE;
			$schedulerModule->addMessage(
					'Seite existiert nicht!',
					\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
			);
		}
		$lang = (int)$submittedData['fp_masterquiz']['language'];
		if (($lang > 0) && ($res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_language', 'uid = ' . $lang))) {
			if ($GLOBALS['TYPO3_DB']->sql_num_rows($res) == 0) {
				$isValid = FALSE;
				$schedulerModule->addMessage(
						'Sprache existiert nicht!',
						\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
						);
			}
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		}
		if (substr($submittedData['fp_masterquiz']['csvfile'],0,10) != 'fileadmin/') {
			$isValid = FALSE;
			$schedulerModule->addMessage(
					'Die CSV-Datei ist nicht valide!',
					\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
			);
		}
		return $isValid;
	}
	
	/**
	 * This method is used to save any additional input into the current task object
	 * if the task class matches.
	 *
	 * @param array $submittedData Array containing the data submitted by the user
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the current task object
	 * @return void
	 */
	public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
		/** @var $task ValidatorTask */
		$task->setCsvfile($submittedData['fp_masterquiz']['csvfile']);
		$task->setFields($submittedData['fp_masterquiz']['fields']);
		$task->setPage($submittedData['fp_masterquiz']['page']);
		$task->setLanguage($submittedData['fp_masterquiz']['language']);
		$task->setSeparator($submittedData['fp_masterquiz']['separator']);
		$task->setDelimiter($submittedData['fp_masterquiz']['delimiter']);
		$task->setConvert($submittedData['fp_masterquiz']['convert']);
		$task->setDelete($submittedData['fp_masterquiz']['delete']);
		$task->setSimulate($submittedData['fp_masterquiz']['simulate']);
	}
}