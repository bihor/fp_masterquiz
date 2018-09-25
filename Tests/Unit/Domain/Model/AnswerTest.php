<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class AnswerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Answer
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Fixpunkt\FpMasterquiz\Domain\Model\Answer();
    }

    protected function tearDown()
    {
        parent::tearDown();
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
}
