<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

use Fixpunkt\FpMasterquiz\Domain\Model\Evaluation;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class EvaluationTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            Evaluation::class,
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
    public function getEvaluateReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getEvaluate());
    }

    /**
     * @test
     */
    public function setEvaluateForBoolSetsEvaluate(): void
    {
        $this->subject->setEvaluate(true);

        self::assertEquals(true, $this->subject->_get('evaluate'));
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
    public function getMinimumReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getMinimum()
        );
    }

    /**
     * @test
     */
    public function setMinimumForFloatSetsMinimum(): void
    {
        $this->subject->setMinimum(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('minimum'));
    }

    /**
     * @test
     */
    public function getMaximumReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->subject->getMaximum()
        );
    }

    /**
     * @test
     */
    public function setMaximumForFloatSetsMaximum(): void
    {
        $this->subject->setMaximum(3.14159265);

        self::assertEquals(3.14159265, $this->subject->_get('maximum'));
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
        $fileReferenceFixture = new FileReference();
        $this->subject->setImage($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('image'));
    }

    /**
     * @test
     */
    public function getPageReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPage()
        );
    }

    /**
     * @test
     */
    public function setPageForStringSetsPage(): void
    {
        $this->subject->setPage('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('page'));
    }

    /**
     * @test
     */
    public function getCeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCe()
        );
    }

    /**
     * @test
     */
    public function setCeForStringSetsCe(): void
    {
        $this->subject->setCe('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('ce'));
    }
}
