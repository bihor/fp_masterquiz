<?php
namespace Fixpunkt\FpMasterquiz\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

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
     */
    protected $participantRepository = null;

    /**
     * Injects the participant-Repository
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository $participantRepository
     */
    public function injectParticipantRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    /**
     * action list
     *
     * @param int $currentPage
     * @return void
     */
    public function listAction(int $currentPage = 1)
    {
        $pid = (int)GeneralUtility::_GP('id');
        $qid = $this->request->hasArgument('quiz') ? intval($this->request->getArgument('quiz')) : 0;
        if ($qid) {
        	$participants = $this->participantRepository->findFromPidAndQuiz($pid, $qid);
        } else {
        	$participants = $this->participantRepository->findFromPid($pid);
        }
        if ($participants) {
            $participantArray = $participants->toArray();
        } else {
            $participantArray = [];
        }
        $participantPaginator = new ArrayPaginator($participantArray, $currentPage, $this->settings['pagebrowser']['itemsPerPage']);
        $participantPagination = new SimplePagination($participantPaginator);

        $this->view->assign('pid', $pid);
        $this->view->assign('qid', $qid);
        $this->view->assign('participants', $participants);
        $this->view->assign('paginator', $participantPaginator);
        $this->view->assign('pagination', $participantPagination);
        $this->view->assign('pages', range(1, $participantPagination->getLastPageNumber()));
    }
    
    /**
     * action detail
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant
     * @return void
     */
    public function detailAction(\Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant)
    {
        foreach ($participant->getSelections() as $selection) {
            if ($selection->getQuestion()->getQmode() == 8) {
                $categoriesArray = [];
                foreach ($selection->getQuestion()->getCategories() as $category) {
                    $categoriesArray[$category->getUid()] = $category->getTitle();
                }
                $ownCategoryAnswers = unserialize($selection->getEntered());
                foreach ($selection->getAnswers() as $answer) {
                    foreach ($ownCategoryAnswers as $key => $ownCategoryAnswer) {
                        if ($key == $answer->getUid()) {
                            $answer->setOwnCategoryAnswer([$ownCategoryAnswer, $categoriesArray[$ownCategoryAnswer]]);
                        }
                    }
                }
            }
        }
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
