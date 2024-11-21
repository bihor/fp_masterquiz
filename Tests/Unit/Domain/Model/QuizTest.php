<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Model\Question;
use Fixpunkt\FpMasterquiz\Domain\Model\Evaluation;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class QuizTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Quiz|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            Quiz::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName(): void
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('name'));
    }

    /**
     * @test
     */
    public function getAboutReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAbout()
        );
    }

    /**
     * @test
     */
    public function setAboutForStringSetsAbout(): void
    {
        $this->subject->setAbout('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('about'));
    }

    /**
     * @test
     */
    public function getQtypeReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getQtype()
        );
    }

    /**
     * @test
     */
    public function setQtypeForIntSetsQtype(): void
    {
        $this->subject->setQtype(12);

        self::assertEquals(12, $this->subject->_get('qtype'));
    }

    /**
     * @test
     */
    public function getTimeperiodReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getTimeperiod()
        );
    }

    /**
     * @test
     */
    public function setTimeperiodForIntSetsTimeperiod(): void
    {
        $this->subject->setTimeperiod(12);

        self::assertEquals(12, $this->subject->_get('timeperiod'));
    }

    /**
     * @test
     */
    public function getMediaReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getMedia()
        );
    }

    /**
     * @test
     */
    public function setMediaForFileReferenceSetsMedia(): void
    {
        $fileReferenceFixture = new FileReference();
        $this->subject->setMedia($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('media'));
    }

    /**
     * @test
     */
    public function getClosedReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getClosed()
        );
    }

    /**
     * @test
     */
    public function setClosedForIntSetsClosed(): void
    {
        $this->subject->setClosed(12);

        self::assertEquals(12, $this->subject->_get('closed'));
    }

    /**
     * @test
     */
    public function getPathSegmentReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPathSegment()
        );
    }

    /**
     * @test
     */
    public function setPathSegmentForStringSetsPathSegment(): void
    {
        $this->subject->setPathSegment('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('pathSegment'));
    }

    /**
     * @test
     */
    public function getQuestionsReturnsInitialValueForQuestion(): void
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
    public function setQuestionsForObjectStorageContainingQuestionSetsQuestions(): void
    {
        $question = new Question();
        $objectStorageHoldingExactlyOneQuestions = new ObjectStorage();
        $objectStorageHoldingExactlyOneQuestions->attach($question);
        
        $this->subject->setQuestions($objectStorageHoldingExactlyOneQuestions);

        self::assertEquals($objectStorageHoldingExactlyOneQuestions, $this->subject->_get('questions'));
    }

    /**
     * @test
     */
    public function addQuestionToObjectStorageHoldingQuestions(): void
    {
        $question = new Question();
        $questionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $questionsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($question));
        $this->subject->_set('questions', $questionsObjectStorageMock);

        $this->subject->addQuestion($question);
    }

    /**
     * @test
     */
    public function removeQuestionFromObjectStorageHoldingQuestions(): void
    {
        $question = new Question();
        $questionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $questionsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($question));
        $this->subject->_set('questions', $questionsObjectStorageMock);

        $this->subject->removeQuestion($question);
    }

    /**
     * @test
     */
    public function getEvaluationsReturnsInitialValueForEvaluation(): void
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
    public function setEvaluationsForObjectStorageContainingEvaluationSetsEvaluations(): void
    {
        $evaluation = new Evaluation();
        $objectStorageHoldingExactlyOneEvaluations = new ObjectStorage();
        $objectStorageHoldingExactlyOneEvaluations->attach($evaluation);
        
        $this->subject->setEvaluations($objectStorageHoldingExactlyOneEvaluations);

        self::assertEquals($objectStorageHoldingExactlyOneEvaluations, $this->subject->_get('evaluations'));
    }

    /**
     * @test
     */
    public function addEvaluationToObjectStorageHoldingEvaluations(): void
    {
        $evaluation = new Evaluation();
        $evaluationsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $evaluationsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($evaluation));
        $this->subject->_set('evaluations', $evaluationsObjectStorageMock);

        $this->subject->addEvaluation($evaluation);
    }

    /**
     * @test
     */
    public function removeEvaluationFromObjectStorageHoldingEvaluations(): void
    {
        $evaluation = new Evaluation();
        $evaluationsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $evaluationsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($evaluation));
        $this->subject->_set('evaluations', $evaluationsObjectStorageMock);

        $this->subject->removeEvaluation($evaluation);
    }
}
