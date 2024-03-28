<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Controller\SelectedController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class SelectedControllerTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\SelectedController
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(SelectedController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     */
    public function listActionFetchesAllSelectedsFromRepositoryAndAssignsThemToView()
    {

        $allSelecteds = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $selectedRepository = $this->getMockBuilder(SelectedRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $selectedRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSelecteds));
        $this->inject($this->subject, 'selectedRepository', $selectedRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('selecteds', $allSelecteds);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
