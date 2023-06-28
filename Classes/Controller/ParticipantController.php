<?php

namespace Fixpunkt\FpMasterquiz\Controller;

use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

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
class ParticipantController extends ActionController
{
    protected int $id;

    protected ModuleTemplate $moduleTemplate;

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

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    ) {
    }

    public function initializeAction()
    {
        $this->id = (int)($this->request->getQueryParams()['id'] ?? 0);
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    }

    /**
     * action list
     *
     * @param int $currentPage
     * @return ResponseInterface
     */
    public function listAction(int $currentPage = 1): ResponseInterface
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
        $this->addDocHeaderDropDown('list');
        return $this->defaultRendering();
    }

    /**
     * action detail
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant
     * @return ResponseInterface
     */
    public function detailAction(\Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant): ResponseInterface
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
        $this->addDocHeaderDropDown('list');
        return $this->defaultRendering();
    }

    /**
     * action delete
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant
     * @return ResponseInterface
     */
    public function deleteAction(\Fixpunkt\FpMasterquiz\Domain\Model\Participant $participant): ResponseInterface
    {
        if ($participant->getUid() > 0) {
            $this->addFlashMessage($participant->getName() . ' deleted.', '', AbstractMessage::WARNING);
            $this->participantRepository->remove($participant);
        }
        return $this->responseFactory->createResponse(307)
            ->withHeader('Location', $this->uriBuilder->reset()->uriFor('list'));
    }

    /*
    * Fürs Backend-Modul
    */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    protected function defaultRendering(): ResponseInterface
    {
        $this->moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($this->moduleTemplate->renderContent());
    }

    protected function addDocHeaderDropDown(string $currentAction): void
    {
        $languageService = $this->getLanguageService();
        $actionMenu = $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $actionMenu->setIdentifier('masterquizSelector');
        $actions = ['Quiz,index', 'Participant,list'];
        foreach ($actions as $controller_action_string) {
            $controller_action_array = explode(",", $controller_action_string);
            $actionMenu->addMenuItem(
                $actionMenu->makeMenuItem()
                    ->setTitle($languageService->sL(
                        'LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_mod1.xlf:index.' .
                        strtolower($controller_action_array[0])
                    ))
                    ->setHref($this->getModuleUri($controller_action_array[0], $controller_action_array[1]))
                    ->setActive($currentAction === $controller_action_array[1])
            );
        }
        $this->moduleTemplate->getDocHeaderComponent()->getMenuRegistry()->addMenu($actionMenu);
    }

    protected function getModuleUri(string $controller = null, string $action = null): string
    {
        return $this->uriBuilder->reset()->uriFor($action, null, $controller, 'mod1');
    }
}