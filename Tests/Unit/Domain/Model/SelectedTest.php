<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class SelectedTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Selected|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Fixpunkt\FpMasterquiz\Domain\Model\Selected::class,
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
    public function getPointsReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPoints()
        );
    }

    /**
     * @test
     */
    public function setPointsForIntSetsPoints(): void
    {
        $this->subject->setPoints(12);

        self::assertEquals(12, $this->subject->_get('points'));
    }

    /**
     * @test
     */
    public function getEnteredReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEntered()
        );
    }

    /**
     * @test
     */
    public function setEnteredForStringSetsEntered(): void
    {
        $this->subject->setEntered('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('entered'));
    }

    /**
     * @test
     */
    public function getQuestionReturnsInitialValueForQuestion(): void
    {
        self::assertEquals(
            null,
            $this->subject->getQuestion()
        );
    }

    /**
     * @test
     */
    public function setQuestionForQuestionSetsQuestion(): void
    {
        $questionFixture = new \Fixpunkt\FpMasterquiz\Domain\Model\Question();
        $this->subject->setQuestion($questionFixture);

        self::assertEquals($questionFixture, $this->subject->_get('question'));
    }

    /**
     * @test
     */
    public function getAnswersReturnsInitialValueForAnswer(): void
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAnswers()
        );
    }

    /**
     * @test
     */
    public function setAnswersForObjectStorageContainingAnswerSetsAnswers(): void
    {
        $answer = new \Fixpunkt\FpMasterquiz\Domain\Model\Answer();
        $objectStorageHoldingExactlyOneAnswers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAnswers->attach($answer);
        $this->subject->setAnswers($objectStorageHoldingExactlyOneAnswers);

        self::assertEquals($objectStorageHoldingExactlyOneAnswers, $this->subject->_get('answers'));
    }

    /**
     * @test
     */
    public function addAnswerToObjectStorageHoldingAnswers(): void
    {
        $answer = new \Fixpunkt\FpMasterquiz\Domain\Model\Answer();
        $answersObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $answersObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($answer));
        $this->subject->_set('answers', $answersObjectStorageMock);

        $this->subject->addAnswer($answer);
    }

    /**
     * @test
     */
    public function removeAnswerFromObjectStorageHoldingAnswers(): void
    {
        $answer = new \Fixpunkt\FpMasterquiz\Domain\Model\Answer();
        $answersObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $answersObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($answer));
        $this->subject->_set('answers', $answersObjectStorageMock);

        $this->subject->removeAnswer($answer);
    }
}
