<?php
namespace Fixpunkt\FpMasterquiz\Task;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\BackendWorkspaceRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

class DeleteParticipantAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {
	
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

		if (empty($taskInfo['days'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['days'] = '0';
			} else {
				$taskInfo['days'] = $task->getDays();
			}
		}
		
		// Ordner
		$fieldId = 'task_page';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][page]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['page']) . '"/>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.page');
		$label = BackendUtility::wrapInHelp('fp_masterquiz', $fieldId, $label);
		$additionalFields[$fieldId] = array(
				'code' => $fieldCode,
				'label' => $label
		);
		// Days
		$fieldId = 'task_days';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][days]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['days']) . '"/>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.days');
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
        if ($submittedData['fp_masterquiz']['page'] > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $count = $queryBuilder
                ->count('uid')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$submittedData['fp_masterquiz']['page'], \PDO::PARAM_INT))
                )
                ->execute()
                ->fetchColumn(0);
			if ($count == 0) {
				$isValid = FALSE;
				$schedulerModule->addMessage(
					$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidPage'),
					\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
				);
			}
		} else {
			$isValid = FALSE;
			$schedulerModule->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidPage'),
				\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
			);
		}
		if (intval($submittedData['fp_masterquiz']['days']) < 1) {
			$isValid = FALSE;
			$schedulerModule->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidDays'),
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
		$task->setPage($submittedData['fp_masterquiz']['page']);
		$task->setDays($submittedData['fp_masterquiz']['days']);
	}
}