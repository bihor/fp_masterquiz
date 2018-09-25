<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class ParticipantControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\ParticipantController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Fixpunkt\FpMasterquiz\Controller\ParticipantController::class)
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
    public function listActionFetchesAllParticipantsFromRepositoryAndAssignsThemToView()
    {

        $allParticipants = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $participantRepository = $this->getMockBuilder(\Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $participantRepository->expects(self::once())->method('findAll')->will(self::returnValue($allParticipants));
        $this->inject($this->subject, 'participantRepository', $participantRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('participants', $allParticipants);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
