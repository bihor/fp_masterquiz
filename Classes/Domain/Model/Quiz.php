<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

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
     * Period in seconds
     *
     * @var int
     */
    protected $timeperiod = 0;

    /**
     * media
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $media = null;

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
    	$this->media = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the timeperiod
     *
     * @return int timeperiod
     */
    public function getTimeperiod()
    {
        return $this->timeperiod;
    }

    /**
     * Sets the timeperiod
     *
     * @param int $timeperiod
     * @return void
     */
    public function setTimeperiod($timeperiod)
    {
        $this->timeperiod = $timeperiod;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getMedia(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        return $this->media;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     */
    public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media): void
    {
        $this->media = $media;
    }

    /**
     * Adds a medium
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
     * @return void
     */
    public function addMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $media) {
        $this->media->attach($media);
    }

    /**
     * Removes a medium
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
     * @return void
     */
    public function removeMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $media) {
        $this->media->detach($media);
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
     * Returns the questions
     *
     * @param integer $page Seite 1..n
     * @param bool $random Zufällig ordnen?
     * @param array $randomNumbers andere Seitenreihenfolge?
     * @return array
     */
    public function getQuestionsSortByTag(int $page, bool $random, array $randomNumbers)
    {
        // wir brauchen last-page und current-page
        $pages = 0;
        $tags = [];
        $pagetags = [];
        $questions = [];
        $result = [];
        if ($random && !(count($randomNumbers)>1)) {
            // Seitenanzahl bestimmen
            foreach ($this->questions as $question) {
                $tag = $question->getTag();
                if ($tag) {
                    if (!$tags[$tag->getName()]) {
                        $pages++;
                        $tags[$tag->getName()] = 1;
                    }
                }
            }
            // jeder Seite eine zufällige Reihenfolge zuordnen
            $randomNumbers = range(1, $pages);
            shuffle($randomNumbers);
            $tags = [];
            $pages = 0;
        }
        foreach ($this->questions as $question) {
            $tag = $question->getTag();
            if ($tag) {
                // Nur Fragen mit einem Tag interessieren uns hier!
                if ($tags[$tag->getName()]) {
                    $forpage = $tags[$tag->getName()];
                } else {
                    $pages++;
                    if ($random) {
                        // Die Seitennummer kommt aus einem random Array 0 .. $pages-1
                        $forpage = $randomNumbers[$pages - 1];
                        //echo "### Seite: " . $pages . ' wird zu ' . $forpage . '/' . $tag->getName();
                    } else {
                        // Die Seitennummer erhöht sich kontinuierlich
                        $forpage = $pages;
                    }
                    $pagetags[$forpage] = $tag->getName();
                    $tags[$tag->getName()] = $forpage;
                }
                if ($page == $forpage) {
                    $questions[] = $question;
                }
            }
        }
        if ($random && (count($randomNumbers)>1)) {
            ksort($pagetags);
        }
        $result['page'] = $page;
        $result['pages'] = $pages;
        $result['pagetags'] = $pagetags;
        $result['tags'] = $tags;
        $result['randomNumbers'] = $randomNumbers;
        $result['questions'] = $questions;
        return $result;
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
