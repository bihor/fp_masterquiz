<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Domain\Model\Selected;
use Fixpunkt\FpMasterquiz\Domain\Model\Question;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Model\Answer;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class SelectedTest extends UnitTestCase
{
    /**
     * @var Selected
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new Selected();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     */
    public function getPointsReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPoints()
        );
    }

    /**
     * @test
     */
    public function setPointsForIntSetsPoints()
    {
        $this->subject->setPoints(12);

        self::assertAttributeEquals(
            12,
            'points',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEnteredReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEntered()
        );
    }

    /**
     * @test
     */
    public function setEnteredForStringSetsEntered()
    {
        $this->subject->setEntered('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'entered',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQuestionReturnsInitialValueForQuestion()
    {
        self::assertEquals(
            null,
            $this->subject->getQuestion()
        );
    }

    /**
     * @test
     */
    public function setQuestionForQuestionSetsQuestion()
    {
        $questionFixture = new Question();
        $this->subject->setQuestion($questionFixture);

        self::assertAttributeEquals(
            $questionFixture,
            'question',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAnswersReturnsInitialValueForAnswer()
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAnswers()
        );
    }

    /**
     * @test
     */
    public function setAnswersForObjectStorageContainingAnswerSetsAnswers()
    {
        $answer = new Answer();
        $objectStorageHoldingExactlyOneAnswers = new ObjectStorage();
        $objectStorageHoldingExactlyOneAnswers->attach($answer);
        $this->subject->setAnswers($objectStorageHoldingExactlyOneAnswers);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneAnswers,
            'answers',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addAnswerToObjectStorageHoldingAnswers()
    {
        $answer = new Answer();
        $answersObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $answersObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($answer));
        $this->inject($this->subject, 'answers', $answersObjectStorageMock);

        $this->subject->addAnswer($answer);
    }

    /**
     * @test
     */
    public function removeAnswerFromObjectStorageHoldingAnswers()
    {
        $answer = new Answer();
        $answersObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $answersObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($answer));
        $this->inject($this->subject, 'answers', $answersObjectStorageMock);

        $this->subject->removeAnswer($answer);
    }
}
