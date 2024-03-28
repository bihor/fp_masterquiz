<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
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
class Question extends AbstractEntity
{
    /**
     * Title
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
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
     * @var FileReference
     */
    #[Cascade(['value' => 'remove'])]
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
     * @var Tag
     */
    protected $tag = null;

    /**
     * Beantwortung optional?
     *
     * @var bool
     */
    protected $optional = false;

    /**
     * Frage geschlossen?
     *
     * @var bool
     */
    protected $closed = false;

    /**
     * Answers of this question
     *
     * @var ObjectStorage<Answer>
     */
    #[Cascade(['value' => 'remove'])]
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
     * @var ObjectStorage<Category>
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
     * @return FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @return void
     */
    public function setImage(FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the tag
     *
     * @return Tag $tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets the tag
     *
     * @return void
     */
    public function setTag(Tag $tag)
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
     * Returns the Closed
     *
     * @return bool
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Sets the Closed
     *
     * @param bool $closed
     * @return void
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * Returns the boolean state of Closed
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * Adds a Answer
     *
     * @return void
     */
    public function addAnswer(Answer $answer)
    {
        $this->answers->attach($answer);
    }

    /**
     * Removes a Answer
     *
     * @param Answer $answerToRemove The Answer to be removed
     * @return void
     */
    public function removeAnswer(Answer $answerToRemove)
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
    public function setAnswers(ObjectStorage $answers)
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
            	// several Answers are possible, all should be chosen
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
     * @return ObjectStorage<Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Returns the categories as array
     *
     * @return array
     */
    public function getCategoriesArray()
    {
        $catArray = [];
        foreach ($this->categories as $category) {
            $catArray[$category->getUid()] = $category->getTitle();
        }
        return $catArray;
    }

    /**
     * Returns the categories as array in sorting order
     *
     * @return array
     */
    public function getSortedCategoriesArray() {
        $table = 'sys_category';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        return $queryBuilder
            ->select('uid','title')
            ->from($table)
            ->join(
                $table,
                'sys_category_record_mm',
                'mm',
                $queryBuilder->expr()->eq('mm.uid_local', $queryBuilder->quoteIdentifier('sys_category.uid'))
            )
            ->where(
                $queryBuilder->expr()->eq('mm.uid_foreign', $queryBuilder->createNamedParameter($this->uid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('mm.tablenames', $queryBuilder->createNamedParameter('tx_fpmasterquiz_domain_model_question'))
            )
            ->orderBy('sys_category.sorting')
            ->executeQuery();
    }
}
