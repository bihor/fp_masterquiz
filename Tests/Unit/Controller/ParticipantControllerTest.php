<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Controller\ParticipantController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class ParticipantControllerTest extends UnitTestCase
{
    /**
     * @var ParticipantController
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(ParticipantController::class)
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
    public function listActionFetchesAllParticipantsFromRepositoryAndAssignsThemToView()
    {

        $allParticipants = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $participantRepository = $this->getMockBuilder(ParticipantRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $participantRepository->expects(self::once())->method('findAll')->will(self::returnValue($allParticipants));
        $this->inject($this->subject, 'participantRepository', $participantRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('participants', $allParticipants);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
