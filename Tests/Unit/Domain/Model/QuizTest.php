<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Model\Question;
use Fixpunkt\FpMasterquiz\Domain\Model\Evaluation;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class QuizTest extends UnitTestCase
{
    /**
     * @var Quiz
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new Quiz();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAboutReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAbout()
        );
    }

    /**
     * @test
     */
    public function setAboutForStringSetsAbout()
    {
        $this->subject->setAbout('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'about',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQuestionsReturnsInitialValueForQuestion()
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getQuestions()
        );
    }

    /**
     * @test
     */
    public function setQuestionsForObjectStorageContainingQuestionSetsQuestions()
    {
        $question = new Question();
        $objectStorageHoldingExactlyOneQuestions = new ObjectStorage();
        $objectStorageHoldingExactlyOneQuestions->attach($question);
        $this->subject->setQuestions($objectStorageHoldingExactlyOneQuestions);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneQuestions,
            'questions',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addQuestionToObjectStorageHoldingQuestions()
    {
        $question = new Question();
        $questionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $questionsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($question));
        $this->inject($this->subject, 'questions', $questionsObjectStorageMock);

        $this->subject->addQuestion($question);
    }

    /**
     * @test
     */
    public function removeQuestionFromObjectStorageHoldingQuestions()
    {
        $question = new Question();
        $questionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $questionsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($question));
        $this->inject($this->subject, 'questions', $questionsObjectStorageMock);

        $this->subject->removeQuestion($question);
    }

    /**
     * @test
     */
    public function getEvaluationsReturnsInitialValueForEvaluation()
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getEvaluations()
        );
    }

    /**
     * @test
     */
    public function setEvaluationsForObjectStorageContainingEvaluationSetsEvaluations()
    {
        $evaluation = new Evaluation();
        $objectStorageHoldingExactlyOneEvaluations = new ObjectStorage();
        $objectStorageHoldingExactlyOneEvaluations->attach($evaluation);
        $this->subject->setEvaluations($objectStorageHoldingExactlyOneEvaluations);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneEvaluations,
            'evaluations',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addEvaluationToObjectStorageHoldingEvaluations()
    {
        $evaluation = new Evaluation();
        $evaluationsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $evaluationsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($evaluation));
        $this->inject($this->subject, 'evaluations', $evaluationsObjectStorageMock);

        $this->subject->addEvaluation($evaluation);
    }

    /**
     * @test
     */
    public function removeEvaluationFromObjectStorageHoldingEvaluations()
    {
        $evaluation = new Evaluation();
        $evaluationsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $evaluationsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($evaluation));
        $this->inject($this->subject, 'evaluations', $evaluationsObjectStorageMock);

        $this->subject->removeEvaluation($evaluation);
    }
}
