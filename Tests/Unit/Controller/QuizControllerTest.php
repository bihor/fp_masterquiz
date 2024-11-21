<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use Fixpunkt\FpMasterquiz\Controller\QuizController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\QuizRepository;
use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class QuizControllerTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\QuizController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(QuizController::class))
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
    public function listActionFetchesAllQuizzesFromRepositoryAndAssignsThemToView(): void
    {
        $allQuizzes = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $quizRepository = $this->getMockBuilder(QuizRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $quizRepository->expects(self::once())->method('findAll')->will(self::returnValue($allQuizzes));
        $this->subject->_set('quizRepository', $quizRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('quizzes', $allQuizzes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenQuizToView(): void
    {
        $quiz = new Quiz();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('quiz', $quiz);

        $this->subject->showAction($quiz);
    }
}
