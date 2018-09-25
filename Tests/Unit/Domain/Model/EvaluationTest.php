<?php
namespace Fixpunkt\FpMasterquiz\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Kurt Gusbeth <k.gusbeth@fixpunkt.com>
 */
class EvaluationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getEvaluateReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getEvaluate()
        );
    }

    /**
     * @test
     */
    public function setEvaluateForBoolSetsEvaluate()
    {
        $this->subject->setEvaluate(true);

        self::assertAttributeEquals(
            true,
            'evaluate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMinimumReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getMinimum()
        );
    }

    /**
     * @test
     */
    public function setMinimumForFloatSetsMinimum()
    {
        $this->subject->setMinimum(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'minimum',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getMaximumReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getMaximum()
        );
    }

    /**
     * @test
     */
    public function setMaximumForFloatSetsMaximum()
    {
        $this->subject->setMaximum(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'maximum',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getCeReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getCe()
        );
    }

    /**
     * @test
     */
    public function setCeForIntSetsCe()
    {
        $this->subject->setCe(12);

        self::assertAttributeEquals(
            12,
            'ce',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPageReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPage()
        );
    }

    /**
     * @test
     */
    public function setPageForIntSetsPage()
    {
        $this->subject->setPage(12);

        self::assertAttributeEquals(
            12,
            'page',
            $this->subject
        );
    }
}
