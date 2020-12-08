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
 * Quiz / Test / Umfrage
 */
class Quiz extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Name / Title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $name = '';

    /**
     * Text about this quiz
     *
     * @var string
     */
    protected $about = '';

    /**
     * Questions
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Question>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $questions = null;

    /**
     * Evaluations
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Evaluation>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $evaluations = null;

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
    	$this->questions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    	$this->evaluations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    	$this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Adds a Question
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $question
     * @return void
     */
    public function addQuestion(\Fixpunkt\FpMasterquiz\Domain\Model\Question $question)
    {
        $this->questions->attach($question);
    }

    /**
     * Removes a Question
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(\Fixpunkt\FpMasterquiz\Domain\Model\Question $questionToRemove)
    {
        $this->questions->detach($questionToRemove);
    }

    /**
     * Returns the questions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Question> $questions
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Sets the questions
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Question> $questions
     * @return void
     */
    public function setQuestions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Adds a Evaluation
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation $evaluation
     * @return void
     */
    public function addEvaluation(\Fixpunkt\FpMasterquiz\Domain\Model\Evaluation $evaluation)
    {
        $this->evaluations->attach($evaluation);
    }

    /**
     * Removes a Evaluation
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Evaluation $evaluationToRemove The Evaluation to be removed
     * @return void
     */
    public function removeEvaluation(\Fixpunkt\FpMasterquiz\Domain\Model\Evaluation $evaluationToRemove)
    {
        $this->evaluations->detach($evaluationToRemove);
    }

    /**
     * Returns the evaluations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Evaluation> $evaluations
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Sets the evaluations
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Evaluation> $evaluations
     * @return void
     */
    public function setEvaluations(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
     * Returns the about
     *
     * @return string $about
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Sets the about
     *
     * @param string $about
     * @return void
     */
    public function setAbout($about)
    {
        $this->about = $about;
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
    
    /**
     * Sets the category
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }
    
    /**
     * Adds a category
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category) {
        $this->categories->attach($category);
    }
    
    /**
     * Removes a category
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category) {
        $this->categories->detach($category);
    }
    				
    /**
     * Returns the maximum points for this quiz
     *
     * @return int $maximum2
     */
    public function getMaximum2()
    {
        $maximum2 = 0;
        foreach ($this->getQuestions() as $question) {
            $maximum2 += $question->getMaximum1();
        }
        return $maximum2;
    }
}
