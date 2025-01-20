<?php
namespace Fixpunkt\FpMasterquiz\Task;

use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Scheduler\AbstractAdditionalFieldProvider;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Scheduler\Task\Enumeration\Action;

class DeleteParticipantAdditionalFieldProvider extends AbstractAdditionalFieldProvider
{
	/**
	 * Render additional information fields within the scheduler backend.
	 *
	 * @param array $taskInfo Array information of task to return
	 * @param ValidatorTask|null $task The task object being edited. Null when adding a task!
	 * @param SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
	 * @return array Additional fields
	 * @see AdditionalFieldProviderInterface->getAdditionalFields($taskInfo, $task, $schedulerModule)
	 */
	public function getAdditionalFields(array &$taskInfo, $task, SchedulerModuleController $schedulerModule)
	{
		$additionalFields = [];
		$currentSchedulerModuleAction = $schedulerModule->getCurrentAction();
		if (empty($taskInfo['page'])) {
			if ($currentSchedulerModuleAction == \TYPO3\CMS\Scheduler\SchedulerManagementAction::ADD) {
				$taskInfo['page'] = '';
			} else {
				$taskInfo['page'] = $task->getPage();
			}
		}
  
		if (empty($taskInfo['days'])) {
			if ($currentSchedulerModuleAction == \TYPO3\CMS\Scheduler\SchedulerManagementAction::ADD) {
				$taskInfo['days'] = '0';
			} else {
				$taskInfo['days'] = $task->getDays();
			}
		}
  
		if (empty($taskInfo['flag'])) {
			if ($currentSchedulerModuleAction == \TYPO3\CMS\Scheduler\SchedulerManagementAction::ADD) {
		        $taskInfo['flag'] = 0;
		    } else {
		        $taskInfo['flag'] = $task->getFlag();
		    }
		}
		
		// Ordner
		$fieldId = 'task_page';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][page]" id="' . $fieldId . '" value="' . htmlspecialchars((string) $taskInfo['page']) . '"/>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.page');
		$additionalFields[$fieldId] = ['code' => $fieldCode, 'label' => $label];
		// Days
		$fieldId = 'task_days';
		$fieldCode = '<input type="text" name="tx_scheduler[fp_masterquiz][days]" id="' . $fieldId . '" value="' . htmlspecialchars((string) $taskInfo['days']) . '"/>';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.days');
		$additionalFields[$fieldId] = ['code' => $fieldCode, 'label' => $label];
		// flag or real delete?
		$fieldId = 'task_flag';
		$checked = ($taskInfo['flag']) ? ' checked="checked"' : '';
		$fieldCode = '<input type="checkbox" name="tx_scheduler[fp_masterquiz][flag]" id="' . $fieldId . '" value="1"' . $checked . ' />';
		$label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.flag');
		$additionalFields[$fieldId] = ['code' => $fieldCode, 'label' => $label];
		return $additionalFields;
	}
	
	/**
	 * This method checks any additional data that is relevant to the specific task.
	 * If the task class is not relevant, the method is expected to return TRUE.
	 *
	 * @param array $submittedData Reference to the array containing the data submitted by the user
	 * @param SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
	 * @return bool TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, SchedulerModuleController $schedulerModule)
	{
		$isValid = TRUE;
        if ($submittedData['fp_masterquiz']['page'] > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $count = $queryBuilder
                ->count('uid')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$submittedData['fp_masterquiz']['page'], \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
                )
                ->executeQuery()
                ->fetchOne();
			if ($count == 0) {
				$isValid = FALSE;
				$this->addMessage(
					$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidPage'),
					ContextualFeedbackSeverity::ERROR
				);
			}
		} else {
			$isValid = FALSE;
			$this->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidPage'),
				ContextualFeedbackSeverity::ERROR
			);
		}
        
		if (intval($submittedData['fp_masterquiz']['days']) < 1) {
			$isValid = FALSE;
			$this->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidDays'),
				ContextualFeedbackSeverity::ERROR
			);
		}
  
		return $isValid;
	}
	
	/**
	 * This method is used to save any additional input into the current task object
	 * if the task class matches.
	 *
	 * @param array $submittedData Array containing the data submitted by the user
	 * @param AbstractTask $task Reference to the current task object
	 */
	public function saveAdditionalFields(array $submittedData, AbstractTask $task)
	{
		/** @var $task ValidatorTask */
		$task->setPage(intval($submittedData['fp_masterquiz']['page']));
		$task->setDays(intval($submittedData['fp_masterquiz']['days']));
        if (isset($submittedData['fp_masterquiz']['flag'])) {
            $task->setFlag(intval($submittedData['fp_masterquiz']['flag']));
        } else {
            $task->setFlag(0);
        }
	}
}