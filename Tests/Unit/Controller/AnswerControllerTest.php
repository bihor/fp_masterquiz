<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Controller\AnswerController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\AnswerRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use Fixpunkt\FpMasterquiz\Domain\Model\Answer;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class AnswerControllerTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\AnswerController
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(AnswerController::class)
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
    public function listActionFetchesAllAnswersFromRepositoryAndAssignsThemToView()
    {

        $allAnswers = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $answerRepository = $this->getMockBuilder(AnswerRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $answerRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAnswers));
        $this->inject($this->subject, 'answerRepository', $answerRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('answers', $allAnswers);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAnswerToView()
    {
        $answer = new Answer();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('answer', $answer);

        $this->subject->showAction($answer);
    }
}
