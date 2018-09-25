<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class QuizTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Quiz
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Fixpunkt\FpMasterquiz\Domain\Model\Quiz();
    }

    protected function tearDown()
    {
        parent::tearDown();
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
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
        $question = new \Fixpunkt\FpMasterquiz\Domain\Model\Question();
        $objectStorageHoldingExactlyOneQuestions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
        $question = new \Fixpunkt\FpMasterquiz\Domain\Model\Question();
        $questionsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
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
        $question = new \Fixpunkt\FpMasterquiz\Domain\Model\Question();
        $questionsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
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
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
        $evaluation = new \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation();
        $objectStorageHoldingExactlyOneEvaluations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
        $evaluation = new \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation();
        $evaluationsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
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
        $evaluation = new \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation();
        $evaluationsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $evaluationsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($evaluation));
        $this->inject($this->subject, 'evaluations', $evaluationsObjectStorageMock);

        $this->subject->removeEvaluation($evaluation);
    }
}
