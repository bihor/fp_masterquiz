<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

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
 * Answer of a question
 */
class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Answer-text
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * Points (if the answer is true, type here a number greater than 0)
     *
     * @var int
     */
    protected $points = 0;
    
    /**
     * joker answer (0: ok; 1: deactivate)
     *
     * @var int
     */
    protected $jokerAnswer = 0;
    
    /**
     * own answer (0: no; 1: yes)
     *
     * @var int
     */
    protected $ownAnswer = 0;

    /**
     * own category answer (for question mode 8): uid and title
     *
     * @var array
     */
    protected $ownCategoryAnswer = [];

    /**
     * total answers of all users
     *
     * @var int
     */
    protected $allAnswers = 0;
    
    /**
     * total percent of all users (checkbox counted ounce)
     *
     * @var float
     */
    protected $allPercent = 0.0;

    /**
     * total percent of all users (all checkboxes counted)
     *
     * @var float
     */
    protected $totalPercent = 0.0;

    /**
     * category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories = null;

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
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the title for JS
     *
     * @return string $title
     */
    public function getTitleJS()
    {
        $title = str_replace(array("'"), "\'", $this->title);
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $title);
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Returns the jokerAnswer
     *
     * @return int $jokerAnswer
     */
    public function getJokerAnswer()
    {
        return $this->jokerAnswer;
    }
    
    /**
     * Sets the jokerAnswer
     *
     * @param int $joker
     * @return void
     */
    public function setJokerAnswer($jokerAnswer)
    {
        $this->jokerAnswer = $jokerAnswer;
    }
    
    /**
     * Returns the ownAnswer
     *
     * @return int $ownAnswer
     */
    public function getOwnAnswer()
    {
        return $this->ownAnswer;
    }
    
    /**
     * Sets the own answer
     *
     * @param int $nr
     * @return void
     */
    public function setOwnAnswer($nr)
    {
        $this->ownAnswer = $nr;
    }

    /**
     * Returns the own Category Answer
     *
     * @return array $ownCategoryAnswer
     */
    public function getOwnCategoryAnswer()
    {
        return $this->ownCategoryAnswer;
    }

    /**
     * Sets the own category answer
     *
     * @param array $array uid and title of a category
     * @return void
     */
    public function setOwnCategoryAnswer($array)
    {
        $this->ownCategoryAnswer = $array;
    }

    /**
     * Returns no. of all answers
     *
     * @return int $allAnswers
     */
    public function getAllAnswers()
    {
        return $this->allAnswers;
    }
    
    /**
     * Sets the points/votes
     *
     * @param int $nr
     * @return void
     */
    public function setAllAnswers($nr)
    {
        $this->allAnswers = $nr;
    }
    
    /**
     * Returns percent of all answers
     *
     * @return string $allPercent
     */
    public function getAllPercent()
    {
        return number_format ( $this->allPercent, 2 );
    }
    
    /**
     * Sets the percent
     *
     * @param float $percent
     * @return void
     */
    public function setAllPercent($percent)
    {
        $this->allPercent = $percent;
    }

    /**
     * Returns percent of all answers (all checkboxes counted)
     *
     * @return string $totalPercent
     */
    public function getTotalPercent()
    {
        return number_format ( $this->totalPercent, 2 );
    }

    /**
     * Sets the percent
     *
     * @param float $percent
     * @return void
     */
    public function setTotalPercent($percent)
    {
        $this->totalPercent = $percent;
    }

    /**
     * Adds a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category) {
        $this->categories->attach($category);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
