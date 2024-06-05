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
class TagTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Tag|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Fixpunkt\FpMasterquiz\Domain\Model\Tag::class,
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
}
