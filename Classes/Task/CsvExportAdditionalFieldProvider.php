<?php
namespace Fixpunkt\FpMasterquiz\Task;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\BackendWorkspaceRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Scheduler\AbstractAdditionalFieldProvider;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Scheduler\Task\Enumeration\Action;
use TYPO3\CMS\Core\Messaging\FlashMessage;

class CsvExportAdditionalFieldProvider extends AbstractAdditionalFieldProvider
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
        $additionalFields = array();
        $currentSchedulerModuleAction = $schedulerModule->getCurrentAction();
        if (empty($taskInfo['csvfile'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['csvfile'] = 'fileadmin/';
            } else {
                $taskInfo['csvfile'] = $task->getCsvfile();
            }
        }
        if (empty($taskInfo['page'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['page'] = '';
            } else {
                $taskInfo['page'] = $task->getPage();
            }
        }
        if (empty($taskInfo['separator'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['separator'] = '"';
            } else {
                $taskInfo['separator'] = $task->getSeparator();
            }
        }
        if (empty($taskInfo['delimiter'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['delimiter'] = ';';
            } else {
                $taskInfo['delimiter'] = $task->getDelimiter();
            }
        }
        if (empty($taskInfo['ansdelimiter'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['ansdelimiter'] = ', ';
            } else {
                $taskInfo['ansdelimiter'] = $task->getAnswersDelimiter();
            }
        }
        if (empty($taskInfo['convert'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['convert'] = 0;
            } else {
                $taskInfo['convert'] = $task->getConvert();
            }
        }

        // Ordner
        $fieldId = 'task_page';
        $fieldCode = '<input type="text" name="tx_scheduler[fpmasterquiz][page]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['page']) . '"/>';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.page');
        $label = BackendUtility::wrapInHelp('fpmasterquiz', $fieldId, $label);
        $additionalFields[$fieldId] = array(
            'code' => $fieldCode,
            'label' => $label
        );
        // path to csv file
        $fieldId = 'task_csvfile';
        $fieldCode = '<input type="text" name="tx_scheduler[fpmasterquiz][csvfile]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['csvfile']) . '" size="50" />';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.csvfile');
        $label = BackendUtility::wrapInHelp('fpmasterquiz', $fieldId, $label);
        $additionalFields[$fieldId] = array(
            'code' => $fieldCode,
            'label' => $label
        );
        // separator
        $fieldId = 'task_separator';
        $fieldCode = '<input type="text" name="tx_scheduler[fpmasterquiz][separator]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['separator']) . '" size="5" />';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.separator');
        $label = BackendUtility::wrapInHelp('fpmasterquiz', $fieldId, $label);
        $additionalFields[$fieldId] = array(
            'code' => $fieldCode,
            'label' => $label
        );
        // delimiter
        $fieldId = 'task_delimiter';
        $fieldCode = '<input type="text" name="tx_scheduler[fpmasterquiz][delimiter]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['delimiter']) . '" size="5" />';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.delimiter');
        $label = BackendUtility::wrapInHelp('fpmasterquiz', $fieldId, $label);
        $additionalFields[$fieldId] = array(
            'code' => $fieldCode,
            'label' => $label
        );
        // ansdelimiter
        $fieldId = 'task_ansdelimiter';
        $fieldCode = '<input type="text" name="tx_scheduler[fpmasterquiz][ansdelimiter]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['ansdelimiter']) . '" size="5" />';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.ansdelimiter');
        $label = BackendUtility::wrapInHelp('fpmasterquiz', $fieldId, $label);
        $additionalFields[$fieldId] = array(
            'code' => $fieldCode,
            'label' => $label
        );
        // convert
        $fieldId = 'task_convert';
        $checked = ($taskInfo['convert']) ? ' checked="checked"' : '';
        $fieldCode = '<input type="checkbox" name="tx_scheduler[fpmasterquiz][convert]" id="' . $fieldId . '" value="1"' . $checked . ' />';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.convert');
        $label = BackendUtility::wrapInHelp('fpmasterquiz', $fieldId, $label);
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
     * @param SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
     * @return bool TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(array &$submittedData, SchedulerModuleController $schedulerModule)
    {
        $isValid = TRUE;
        if ($submittedData['fpmasterquiz']['page'] > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $count = $queryBuilder
                ->count('uid')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$submittedData['fpmasterquiz']['page'], \PDO::PARAM_INT))
                )
                ->execute()
                ->fetchColumn(0);
            if ($count == 0) {
                $isValid = FALSE;
                $this->addMessage(
                    $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidPage'),
                    FlashMessage::ERROR
                );
            }
        } else {
            $isValid = FALSE;
            $this->addMessage(
                $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidPage'),
                FlashMessage::ERROR
            );
        }
        if (substr($submittedData['fpmasterquiz']['csvfile'],0,10) != 'fileadmin/') {
            $isValid = FALSE;
            $this->addMessage(
                $GLOBALS['LANG']->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_be.xlf:tasks.validate.invalidCsvfile'),
                FlashMessage::ERROR
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
        $task->setCsvfile($submittedData['fpmasterquiz']['csvfile']);
        $task->setPage($submittedData['fpmasterquiz']['page']);
        $task->setSeparator($submittedData['fpmasterquiz']['separator']);
        $task->setDelimiter($submittedData['fpmasterquiz']['delimiter']);
        $task->setAnswersDelimiter($submittedData['fpmasterquiz']['ansdelimiter']);
        $task->setConvert($submittedData['fpmasterquiz']['convert']);
    }
}