<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use Fixpunkt\FpMasterquiz\Domain\Model\Participant;
use Fixpunkt\FpMasterquiz\Domain\Model\Quiz;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Fixpunkt\FpMasterquiz\Domain\Model\Selected;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class ParticipantTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Participant|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            Participant::class,
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
    public function getEmailReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail(): void
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('email'));
    }

    /**
     * @test
     */
    public function getHomepageReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getHomepage()
        );
    }

    /**
     * @test
     */
    public function setHomepageForStringSetsHomepage(): void
    {
        $this->subject->setHomepage('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('homepage'));
    }

    /**
     * @test
     */
    public function getUserReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getUser()
        );
    }

    /**
     * @test
     */
    public function setUserForIntSetsUser(): void
    {
        $this->subject->setUser(12);

        self::assertEquals(12, $this->subject->_get('user'));
    }

    /**
     * @test
     */
    public function getIpReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getIp()
        );
    }

    /**
     * @test
     */
    public function setIpForStringSetsIp(): void
    {
        $this->subject->setIp('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('ip'));
    }

    /**
     * @test
     */
    public function getSessionReturnsInitialValueForString(): void
    {
        // @extensionScannerIgnoreLine
        self::assertSame('', $this->subject->getSession());
    }

    /**
     * @test
     */
    public function setSessionForStringSetsSession(): void
    {
        $this->subject->setSession('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('session'));
    }

    /**
     * @test
     */
    public function getSessionstartReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getSessionstart()
        );
    }

    /**
     * @test
     */
    public function setSessionstartForIntSetsSessionstart(): void
    {
        $this->subject->setSessionstart(12);

        self::assertEquals(12, $this->subject->_get('sessionstart'));
    }

    /**
     * @test
     */
    public function getRandompagesReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getRandompages()
        );
    }

    /**
     * @test
     */
    public function setRandompagesForStringSetsRandompages(): void
    {
        $this->subject->setRandompages('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('randompages'));
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
    public function getMaximum1ReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getMaximum1()
        );
    }

    /**
     * @test
     */
    public function setMaximum1ForIntSetsMaximum1(): void
    {
        $this->subject->setMaximum1(12);

        self::assertEquals(12, $this->subject->_get('maximum1'));
    }

    /**
     * @test
     */
    public function getMaximum2ReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getMaximum2()
        );
    }

    /**
     * @test
     */
    public function setMaximum2ForIntSetsMaximum2(): void
    {
        $this->subject->setMaximum2(12);

        self::assertEquals(12, $this->subject->_get('maximum2'));
    }

    /**
     * @test
     */
    public function getCompletedReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getCompleted());
    }

    /**
     * @test
     */
    public function setCompletedForBoolSetsCompleted(): void
    {
        $this->subject->setCompleted(true);

        self::assertEquals(true, $this->subject->_get('completed'));
    }

    /**
     * @test
     */
    public function getPageReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPage()
        );
    }

    /**
     * @test
     */
    public function setPageForIntSetsPage(): void
    {
        $this->subject->setPage(12);

        self::assertEquals(12, $this->subject->_get('page'));
    }

    /**
     * @test
     */
    public function getQuizReturnsInitialValueForQuiz(): void
    {
        self::assertEquals(
            null,
            $this->subject->getQuiz()
        );
    }

    /**
     * @test
     */
    public function setQuizForQuizSetsQuiz(): void
    {
        $quizFixture = new Quiz();
        $this->subject->setQuiz($quizFixture);

        self::assertEquals($quizFixture, $this->subject->_get('quiz'));
    }

    /**
     * @test
     */
    public function getSelectionsReturnsInitialValueForSelected(): void
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
    public function setSelectionsForObjectStorageContainingSelectedSetsSelections(): void
    {
        $selection = new Selected();
        $objectStorageHoldingExactlyOneSelections = new ObjectStorage();
        $objectStorageHoldingExactlyOneSelections->attach($selection);
        
        $this->subject->setSelections($objectStorageHoldingExactlyOneSelections);

        self::assertEquals($objectStorageHoldingExactlyOneSelections, $this->subject->_get('selections'));
    }

    /**
     * @test
     */
    public function addSelectionToObjectStorageHoldingSelections(): void
    {
        $selection = new Selected();
        $selectionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $selectionsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($selection));
        $this->subject->_set('selections', $selectionsObjectStorageMock);

        $this->subject->addSelection($selection);
    }

    /**
     * @test
     */
    public function removeSelectionFromObjectStorageHoldingSelections(): void
    {
        $selection = new Selected();
        $selectionsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $selectionsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($selection));
        $this->subject->_set('selections', $selectionsObjectStorageMock);

        $this->subject->removeSelection($selection);
    }
}
