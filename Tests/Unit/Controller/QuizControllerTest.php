<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class QuizControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\QuizController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Fixpunkt\FpMasterquiz\Controller\QuizController::class)
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
    public function listActionFetchesAllQuizzesFromRepositoryAndAssignsThemToView()
    {

        $allQuizzes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $quizRepository = $this->getMockBuilder(\Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $quizRepository->expects(self::once())->method('findAll')->will(self::returnValue($allQuizzes));
        $this->inject($this->subject, 'quizRepository', $quizRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('quizzes', $allQuizzes);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenQuizToView()
    {
        $quiz = new \Fixpunkt\FpMasterquiz\Domain\Model\Quiz();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('quiz', $quiz);

        $this->subject->showAction($quiz);
    }
}
