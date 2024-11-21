<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Tests\Unit\Controller;

use Fixpunkt\FpMasterquiz\Controller\QuestionController;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kurt Gusbeth <news@quizpalme.de>
 */
class QuestionControllerTest extends UnitTestCase
{
    /**
     * @var \Fixpunkt\FpMasterquiz\Controller\QuestionController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(QuestionController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

}
