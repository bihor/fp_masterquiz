<?php

namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\Category;
/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2023 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt für digitales GmbH
 *
 ***/
/**
 * Answer of a question
 */
class Answer extends AbstractEntity
{
    /**
     * Answer-text
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
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
     * all category answers (for question mode 8): uid and title
     *
     * @var array
     */
    protected $allCategoryAnswers = [];

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
     * @var ObjectStorage<Category>
     */
    protected $categories;

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
        $this->categories = new ObjectStorage();
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
        $title = str_replace(["'"], "\'", $this->title);
        return str_replace(["\r\n", "\r", "\n"], "<br />", $title);
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title): void
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
    public function setPoints($points): void
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
    public function setJokerAnswer($jokerAnswer): void
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
    public function setOwnAnswer($nr): void
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
    public function setOwnCategoryAnswer($array): void
    {
        $this->ownCategoryAnswer = $array;
    }

    /**
     * Returns all Category Answers
     *
     * @return array $allCategoryAnswers
     */
    public function getAllCategoryAnswers()
    {
        return $this->allCategoryAnswer;
    }

    /**
     * Sets all category answers
     *
     * @param array $array uid and title of a category
     * @return void
     */
    public function setAllCategoryAnswers($array): void
    {
        $this->allCategoryAnswer = $array;
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
    public function setAllAnswers($nr): void
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
        return number_format($this->allPercent, 2);
    }

    /**
     * Sets the percent
     *
     * @param float $percent
     * @return void
     */
    public function setAllPercent($percent): void
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
        return number_format($this->totalPercent, 2);
    }

    /**
     * Sets the percent
     *
     * @param float $percent
     * @return void
     */
    public function setTotalPercent($percent): void
    {
        $this->totalPercent = $percent;
    }

    /**
     * Adds a Category
     *
     * @return void
     */
    public function addCategory(Category $category): void {
        $this->categories->attach($category);
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
