<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class SelectedControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\SelectedController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Fixpunkt\FpMasterquiz\Controller\SelectedController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllSelectedsFromRepositoryAndAssignsThemToView()
    {

        $allSelecteds = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $selectedRepository = $this->getMockBuilder(\Fixpunkt\FpMasterquiz\Domain\Repository\SelectedRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $selectedRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSelecteds));
        $this->inject($this->subject, 'selectedRepository', $selectedRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('selecteds', $allSelecteds);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
