<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
 *
 ***/

/**
 * Selected question with answers
 */
class Selected extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Points for this question
     *
     * @var int
     */
    protected $points = 0;

    /**
     * Entered text to this question
     *
     * @var string
     */
    protected $entered = '';

    /**
     * Question
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Question
     */
    protected $question = null;

    /**
     * Answers to this question
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Answer>
     */
    protected $answers = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->answers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the points
     *
     * @return int $points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Sets the points
     *
     * @param string $points
     * @return void
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * Returns the entered
     *
     * @return string $entered
     */
    public function getEntered()
    {
        return $this->entered;
    }

    /**
     * Sets the entered
     *
     * @param string $entered
     * @return void
     */
    public function setEntered($entered)
    {
        $this->entered = $entered;
    }

    /**
     * Returns the question
     *
     * @return \Fixpunkt\FpMasterquiz\Domain\Model\Question $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion(\Fixpunkt\FpMasterquiz\Domain\Model\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Adds a Answer
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Answer $answer
     * @return void
     */
    public function addAnswer(\Fixpunkt\FpMasterquiz\Domain\Model\Answer $answer)
    {
        $this->answers->attach($answer);
    }

    /**
     * Removes a Answer
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Answer $answerToRemove The Answer to be removed
     * @return void
     */
    public function removeAnswer(\Fixpunkt\FpMasterquiz\Domain\Model\Answer $answerToRemove)
    {
        $this->answers->detach($answerToRemove);
    }

    /**
     * Returns the answers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Answer> $answers
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Sets the answers
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Answer> $answers
     * @return void
     */
    public function setAnswers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $answers)
    {
        $this->answers = $answers;
    }

    /**
     * Returns the maximum points for this question
     *
     * @return int $maximumPoints
     */
    public function getMaximumPoints()
    {
        return $this->question->getMaximum1();
    }
}
