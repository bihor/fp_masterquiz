<?php
namespace Fixpunkt\FpMasterquiz\Controller;


/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
 *
 ***/
/**
 * TagController
 */
class TagController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * tagRepository
     * 
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\TagRepository
     */
    protected $tagRepository = null;

    /**
     * @param \Fixpunkt\FpMasterquiz\Domain\Repository\TagRepository $tagRepository
     */
    public function injectTagRepository(\Fixpunkt\FpMasterquiz\Domain\Repository\TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $tags = $this->tagRepository->findAll();
        $this->view->assign('tags', $tags);
    }
}
