<?php

namespace Fixpunkt\FpMasterquiz\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
 * QuestionController
 */
class QuestionController extends ActionController
{
    /**
     * questionRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\QuestionRepository
     */
    protected $questionRepository = null;

    /**
     * Injects the question-Repository
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\QuestionRepository $questionRepository
     */
    public function injectQuestionRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * action move
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $question
     * @return void
     */
    public function moveAction(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz, \Fixpunkt\FpMasterquiz\Domain\Model\Question $question = NULL)
    {
        $pid = (int)GeneralUtility::_GP('id');
        if ($question) {
            $this->questionRepository->moveToQuiz($question->getUid(), $quiz->getUid());
        }
        $questions = $this->questionRepository->findOtherThan($pid, $quiz->getUid());
        $this->view->assign('question', $question);
        $this->view->assign('questions', $questions);
        $this->view->assign('quiz', $quiz);
    }

}
