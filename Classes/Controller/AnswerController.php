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
 * AnswerController
 */
class AnswerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * answerRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository
     * @inject
     */
    protected $answerRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $answers = $this->answerRepository->findAll();
        $this->view->assign('answers', $answers);
    }

    /**
     * action show
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Answer $answer
     * @return void
     */
    public function showAction(\Fixpunkt\FpMasterquiz\Domain\Model\Answer $answer)
    {
        $this->view->assign('answer', $answer);
    }
}
