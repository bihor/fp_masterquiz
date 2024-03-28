<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Controller\QuizController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class QuizControllerTest extends UnitTestCase
{
    /**
     * @var QuizController
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(QuizController::class)
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
    public function listActionFetchesAllQuizzesFromRepositoryAndAssignsThemToView()
    {

        $allQuizzes = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $quizRepository = $this->getMockBuilder(QuizRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $quizRepository->expects(self::once())->method('findAll')->will(self::returnValue($allQuizzes));
        $this->inject($this->subject, 'quizRepository', $quizRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('quizzes', $allQuizzes);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenQuizToView()
    {
        $quiz = new Quiz();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('quiz', $quiz);

        $this->subject->showAction($quiz);
    }
}
