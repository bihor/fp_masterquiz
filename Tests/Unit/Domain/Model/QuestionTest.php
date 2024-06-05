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
class QuestionTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Question|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Fixpunkt\FpMasterquiz\Domain\Model\Question::class,
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
    public function getTitleReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle(): void
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('title'));
    }

    /**
     * @test
     */
    public function getQmodeReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getQmode()
        );
    }

    /**
     * @test
     */
    public function setQmodeForIntSetsQmode(): void
    {
        $this->subject->setQmode(12);

        self::assertEquals(12, $this->subject->_get('qmode'));
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setImage($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('image'));
    }

    /**
     * @test
     */
    public function getBodytextReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getBodytext()
        );
    }

    /**
     * @test
     */
    public function setBodytextForStringSetsBodytext(): void
    {
        $this->subject->setBodytext('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('bodytext'));
    }

    /**
     * @test
     */
    public function getExplanationReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getExplanation()
        );
    }

    /**
     * @test
     */
    public function setExplanationForStringSetsExplanation(): void
    {
        $this->subject->setExplanation('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('explanation'));
    }

    /**
     * @test
     */
    public function getSpanReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getSpan());
    }

    /**
     * @test
     */
    public function setSpanForBoolSetsSpan(): void
    {
        $this->subject->setSpan(true);

        self::assertEquals(true, $this->subject->_get('span'));
    }

    /**
     * @test
     */
    public function getOptionalReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getOptional());
    }

    /**
     * @test
     */
    public function setOptionalForBoolSetsOptional(): void
    {
        $this->subject->setOptional(true);

        self::assertEquals(true, $this->subject->_get('optional'));
    }

    /**
     * @test
     */
    public function getClosedReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getClosed());
    }

    /**
     * @test
     */
    public function setClosedForBoolSetsClosed(): void
    {
        $this->subject->setClosed(true);

        self::assertEquals(true, $this->subject->_get('closed'));
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

    /**
     * @test
     */
    public function getTagReturnsInitialValueForTag(): void
    {
        self::assertEquals(
            null,
            $this->subject->getTag()
        );
    }

    /**
     * @test
     */
    public function setTagForTagSetsTag(): void
    {
        $tagFixture = new \Fixpunkt\FpMasterquiz\Domain\Model\Tag();
        $this->subject->setTag($tagFixture);

        self::assertEquals($tagFixture, $this->subject->_get('tag'));
    }
}
