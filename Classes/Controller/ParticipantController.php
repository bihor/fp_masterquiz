<?php
namespace Fixpunkt\FpMasterquiz\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * ParticipantController
 */
class ParticipantController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * participantRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository
     * @inject
     */
    protected $participantRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $pid = (int)GeneralUtility::_GP('id');
        $qid = $this->request->hasArgument('quiz') ? intval($this->request->getArgument('quiz')) : 0;
        if ($qid) {
        	$participants = $this->participantRepository->findFromPidAndQuiz($pid, $qid);
        } else {
        	$participants = $this->participantRepository->findFromPid($pid);
        }
        $this->view->assign('pid', $pid);
        $this->view->assign('qid', $qid);
        $this->view->assign('participants', $participants);
    }
    
    /**
     * action detail
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant
     * @return void
     */
    public function detailAction(\Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant)
    {
        $this->view->assign('participant', $participant);
    }
    
    /**
     * action delete
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant
     * @return void
     */
    public function deleteAction(\Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant)
    {
    	if ($participant->getUid() > 0) {
    		$this->addFlashMessage($participant->getName() . ' deleted.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
    		$this->participantRepository->remove($participant);
    	}
    	$this->redirect('list');
    }
}
