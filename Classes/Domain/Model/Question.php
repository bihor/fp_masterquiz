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
 * Question for a quiz/test/poll
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Title
     *
     * @var string
     * @validate NotEmpty
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
     * @cascade remove
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
     * @cascade remove
     * @lazy
     */
    protected $answers = null;

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
            $maximum1 += $answer->getPoints();
        }
        return $maximum1;
    }
}
