<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use Fixpunkt\FpMasterquiz\Controller\ParticipantController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\ParticipantRepository;
use Fixpunkt\FpMasterquiz\Domain\Model\Participant;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class ParticipantControllerTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\ParticipantController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(ParticipantController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllParticipantsFromRepositoryAndAssignsThemToView(): void
    {
        $allParticipants = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $participantRepository = $this->getMockBuilder(ParticipantRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $participantRepository->expects(self::once())->method('findAll')->will(self::returnValue($allParticipants));
        $this->subject->_set('participantRepository', $participantRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('participants', $allParticipants);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenParticipantFromParticipantRepository(): void
    {
        $participant = new Participant();

        $participantRepository = $this->getMockBuilder(ParticipantRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $participantRepository->expects(self::once())->method('remove')->with($participant);
        $this->subject->_set('participantRepository', $participantRepository);

        $this->subject->deleteAction($participant);
    }
}
