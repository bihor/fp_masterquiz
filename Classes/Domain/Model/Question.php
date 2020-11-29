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
     * Answers of this question
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Answer>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $answers = null;
    
    /**
     * total answers of all users
     *
     * @var int
     */
    protected $allAnswers = 0;
    
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
     * Returns no. of all answers/votes
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
     * Returns the no. of answers for this question
     *
     * @return int
     */
    public function getNumberOfAnswers()
    {
    	return count($this->answers);
    }
    
    /**
     * Returns the an array with no. of answers for this question
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
}
