<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\Category;
/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
 *
 ***/
/**
 * Selected question with answers
 */
class Selected extends AbstractEntity
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
     * @var Question
     */
    protected $question;

    /**
     * Answers to this question
     *
     * @var ObjectStorage<Answer>
     */
    protected $answers;
    
    /**
     * Question-sorting
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * category
     *
     * @var ObjectStorage<Category>
     */
    protected $categories;

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
        $this->answers = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }
    
    /**
     * Returns the sorting
     *
     * @return int sorting
     */
    public function getSorting()
    {
    	return $this->sorting;
    }
    
    /**
     * Sets the sorting
     *
     * @param int $sorting
     * @return void
     */
    public function setSorting($sorting): void
    {
    	$this->sorting = $sorting;
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
    public function setPoints($points): void
    {
        $this->points = $points;
    }
    
    /**
     * Sets the more points
     *
     * @param int $points
     * @return void
     */
    public function addPoints($points): void
    {
        $this->points += $points;
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
    public function setEntered($entered): void
    {
        $this->entered = $entered;
    }

    /**
     * Returns the question
     *
     * @return Question $question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @return void
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    /**
     * Adds an Answer
     *
     * @return void
     */
    public function addAnswer(Answer $answer): void
    {
        $this->answers->attach($answer);
    }

    /**
     * Removes an Answer
     *
     * @param Answer $answerToRemove The Answer to be removed
     * @return void
     */
    public function removeAnswer(Answer $answerToRemove): void
    {
        $this->answers->detach($answerToRemove);
    }

    /**
     * Returns the answers
     *
     * @return ObjectStorage<Answer> $answers
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Sets the answers
     *
     * @param ObjectStorage<Answer> $answers
     * @return void
     */
    public function setAnswers(ObjectStorage $answers): void
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

    /**
     * Returns the categories
     *
     * @return ObjectStorage<Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
