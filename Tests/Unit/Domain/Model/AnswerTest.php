<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Tests\UnitTestCase;
use Fixpunkt\FpMasterquiz\Domain\Model\Answer;
/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class AnswerTest extends UnitTestCase
{
    /**
     * @var Answer
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = new Answer();
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
