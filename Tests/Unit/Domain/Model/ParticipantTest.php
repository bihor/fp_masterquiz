<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Domain\Model\Participant;
use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Model\Selected;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class ParticipantTest extends UnitTestCase
{
    /**
     * @var Participant
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new Participant();
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
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getHomepageReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getHomepage()
        );
    }

    /**
     * @test
     */
    public function setHomepageForStringSetsHomepage()
    {
        $this->subject->setHomepage('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'homepage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUserReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getUser()
        );
    }

    /**
     * @test
     */
    public function setUserForIntSetsUser()
    {
        $this->subject->setUser(12);

        self::assertAttributeEquals(
            12,
            'user',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getIpReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getIp()
        );
    }

    /**
     * @test
     */
    public function setIpForStringSetsIp()
    {
        $this->subject->setIp('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'ip',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSessionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSession()
        );
    }

    /**
     * @test
     */
    public function setSessionForStringSetsSession()
    {
        $this->subject->setSession('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'session',
            $this->subject
        );
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
    public function getMaximum1ReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getMaximum1()
        );
    }

    /**
     * @test
     */
    public function setMaximum1ForIntSetsMaximum1()
    {
        $this->subject->setMaximum1(12);

        self::assertAttributeEquals(
            12,
            'maximum1',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMaximum2ReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getMaximum2()
        );
    }

    /**
     * @test
     */
    public function setMaximum2ForIntSetsMaximum2()
    {
        $this->subject->setMaximum2(12);

        self::assertAttributeEquals(
            12,
            'maximum2',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQuizReturnsInitialValueForQuiz()
    {
        self::assertEquals(
            null,
            $this->subject->getQuiz()
        );
    }

    /**
     * @test
     */
    public function setQuizForQuizSetsQuiz()
    {
        $quizFixture = new Quiz();
        $this->subject->setQuiz($quizFixture);

        self::assertAttributeEquals(
            $quizFixture,
            'quiz',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSelectionsReturnsInitialValueForSelected()
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSelections()
        );
    }

    /**
     * @test
     */
    public function setSelectionsForObjectStorageContainingSelectedSetsSelections()
    {
        $selection = new Selected();
        $objectStorageHoldingExactlyOneSelections = new ObjectStorage();
        $objectStorageHoldingExactlyOneSelections->attach($selection);
        $this->subject->setSelections($objectStorageHoldingExactlyOneSelections);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneSelections,
            'selections',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addSelectionToObjectStorageHoldingSelections()
    {
        $selection = new Selected();
        $selectionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $selectionsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($selection));
        $this->inject($this->subject, 'selections', $selectionsObjectStorageMock);

        $this->subject->addSelection($selection);
    }

    /**
     * @test
     */
    public function removeSelectionFromObjectStorageHoldingSelections()
    {
        $selection = new Selected();
        $selectionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $selectionsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($selection));
        $this->inject($this->subject, 'selections', $selectionsObjectStorageMock);

        $this->subject->removeSelection($selection);
    }
}
