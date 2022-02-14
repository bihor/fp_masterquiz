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
 * Question for a quiz/test/poll
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * Question-mode
     *
     * @var int
     */
    protected $qmode = 0;

    /**
     * Image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * Description
     *
     * @var string
     */
    protected $bodytext = '';

    /**
     * Explanation to the question/answers
     *
     * @var string
     */
    protected $explanation = '';

    /**
     * Tag
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Tag
     */
    protected $tag = null;

    /**
     * Beantwortung optional?
     *
     * @var bool
     */
    protected $optional = false;

    /**
     * Answers of this question
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Answer>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $answers = null;
    
    /**
     * no. of answers of all users (checkboxes: counted once)
     *
     * @var int
     */
    protected $allAnswers = 0;

    /**
     * no. of answers of all users (checkboxes: counted all)
     *
     * @var int
     */
    protected $totalAnswers = 0;

    /**
     * Array with text answers
     *
     * @var array
     */
    protected $textAnswers = [];

    /**
     * Question-sorting
     *
     * @var int
     */
    protected $sorting = 0;

    /**
     * category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories = null;

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
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
    public function setSorting($sorting)
    {
    	$this->sorting = $sorting;
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
     * Returns the bodytext
     *
     * @return string $bodytext
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * Sets the bodytext
     *
     * @param string $bodytext
     * @return void
     */
    public function setBodytext($bodytext)
    {
        $this->bodytext = $bodytext;
    }

    /**
     * Returns the explanation
     *
     * @return string $explanation
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * Sets the explanation
     *
     * @param string $explanation
     * @return void
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the tag
     *
     * @return \Fixpunkt\FpMasterquiz\Domain\Model\Tag $tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets the tag
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Tag $tag
     * @return void
     */
    public function setTag(\Fixpunkt\FpMasterquiz\Domain\Model\Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Returns the Optional
     *
     * @return bool
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * Sets the Optional
     *
     * @param bool $optional
     * @return void
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;
    }

    /**
     * Returns the boolean state of Optional
     *
     * @return bool
     */
    public function isOptional()
    {
        return $this->optional;
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
     * Returns the qmode
     *
     * @return int qmode
     */
    public function getQmode()
    {
        return $this->qmode;
    }

    /**
     * Sets the qmode
     *
     * @param int $qmode
     * @return void
     */
    public function setQmode($qmode)
    {
        $this->qmode = $qmode;
    }

    /**
     * Returns SELECT option
     *
     * @return array selectOptions
     */
    public function getSelectOptions()
    {
        $options = ['0' => '---'];
        foreach ($this->getAnswers() as $answer) {
            $options[$answer->getUid()] = $answer->getTitle();
        }
        return $options;
    }

    /**
     * Returns the maximum points for this question
     *
     * @return int maximum1
     */
    public function getMaximum1()
    {
        $maximum1 = 0;
        foreach ($this->getAnswers() as $answer) {
            $points = $answer->getPoints();
            if ($this->qmode >= 1 && $this->qmode <= 3) {
            	// only one answer is possible
            	if ($points > $maximum1) {
            		$maximum1 = $points;
            	}
            } else {
            	// several Answers are possible, all should be choosen
	            if ($points > 0) {
    	            $maximum1 += $points;
        	    }
            }
        }
        return $maximum1;
    }
    
    /**
     * Returns no. of all answers/votes (checkboxes once counted)
     *
     * @return int $allAnswers
     */
    public function getAllAnswers()
    {
        return $this->allAnswers;
    }
    
    /**
     * Sets the points/votes/answers
     *
     * @param int $nr
     * @return void
     */
    public function setAllAnswers($nr)
    {
        $this->allAnswers = $nr;
    }

    /**
     * Returns no. of all answers/votes (all checkboxes)
     *
     * @return int $totalAnswers
     */
    public function getTotalAnswers()
    {
        return $this->totalAnswers;
    }

    /**
     * Sets the points/votes/answers
     *
     * @param int $nr
     * @return void
     */
    public function setTotalAnswers($nr)
    {
        $this->totalAnswers = $nr;
    }

    /**
     * Returns an array with text answers
     *
     * @return array $textAnswers
     */
    public function getTextAnswers()
    {
        return $this->textAnswers;
    }

    /**
     * Sets the array with text answers
     *
     * @param array $textAnswers
     * @return void
     */
    public function setTextAnswers($textAnswers)
    {
        $this->textAnswers = $textAnswers;
    }

    /**
     * Returns the no. of answers for this question
     *
     * @return int
     */
    public function getNumberOfAnswers()
    {
    	return count($this->answers);
    }
    
    /**
     * Returns an array with no. of answers for this question
     *
     * @return array
     */
    public function getArrayOfAnswers()
    {
    	$array = [];
    	for ($i=0; $i<count($this->answers); $i++) {
    		$array[] = count($this->answers) - $i;
    	}
    	return $array;
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
