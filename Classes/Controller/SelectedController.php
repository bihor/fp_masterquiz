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
 * SelectedController
 */
class SelectedController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * selectedRepository
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $selectedRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
		$selecteds = $this->selectedRepository->findAll();
		$this->view->assign('selecteds', $selecteds);
    }
}
