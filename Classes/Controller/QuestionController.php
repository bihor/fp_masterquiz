<?php
namespace Fixpunkt\FpMasterquiz\Controller;

/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
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
     * @inject
     */
    protected $questionRepository = null;

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
}
