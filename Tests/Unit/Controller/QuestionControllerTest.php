<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Controller\QuestionController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Repository\QuestionRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use Fixpunkt\FpMasterquiz\Domain\Model\Question;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class QuestionControllerTest extends UnitTestCase
{
    /**
     * @var QuestionController
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(QuestionController::class)
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
    public function listActionFetchesAllQuestionsFromRepositoryAndAssignsThemToView()
    {

        $allQuestions = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $questionRepository = $this->getMockBuilder(QuestionRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $questionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allQuestions));
        $this->inject($this->subject, 'questionRepository', $questionRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('questions', $allQuestions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenQuestionToView()
    {
        $question = new Question();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('question', $question);

        $this->subject->showAction($question);
    }
}
