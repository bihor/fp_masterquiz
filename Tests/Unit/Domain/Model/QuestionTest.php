<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Domain\Model\Question;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Model\Answer;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class QuestionTest extends UnitTestCase
{
    /**
     * @var Question
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new Question();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQmodeReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getQmode()
        );
    }

    /**
     * @test
     */
    public function setQmodeForIntSetsQmode()
    {
        $this->subject->setQmode(12);

        self::assertAttributeEquals(
            12,
            'qmode',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $fileReferenceFixture = new FileReference();
        $this->subject->setImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'image',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBodytextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBodytext()
        );
    }

    /**
     * @test
     */
    public function setBodytextForStringSetsBodytext()
    {
        $this->subject->setBodytext('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'bodytext',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getExplanationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getExplanation()
        );
    }

    /**
     * @test
     */
    public function setExplanationForStringSetsExplanation()
    {
        $this->subject->setExplanation('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'explanation',
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
