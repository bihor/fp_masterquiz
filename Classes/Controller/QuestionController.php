<?php
namespace Fixpunkt\FpMasterquiz\Controller;

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
class QuestionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $questions = $this->questionRepository->findAll();
        $this->view->assign('questions', $questions);
    }

    /**
     * action show
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $question
     * @return void
     */
    public function showAction(\Fixpunkt\FpMasterquiz\Domain\Model\Question $question)
    {
        $this->view->assign('question', $question);
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
        $pid = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');
        if ($question) {
            $this->questionRepository->moveToQuiz($question->getUid(), $quiz->getUid());
        }
        $questions = $this->questionRepository->findOtherThan($pid, $quiz->getUid());
        $this->view->assign('question', $question);
        $this->view->assign('questions', $questions);
        $this->view->assign('quiz', $quiz);
    }

}
