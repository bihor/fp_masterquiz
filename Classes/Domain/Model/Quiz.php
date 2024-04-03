<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
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
 * Quiz / Test / Umfrage
 */
class Quiz extends AbstractEntity
{
    /**
     * Name / Title
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
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
     * Quiz-mode/type
     *
     * @var int
     */
    protected $qtype = 0;

    /**
     * Quiz geschlossen?
     *
     * @var bool
     */
    protected $closed = false;

    /**
     * media
     *
     * @var ObjectStorage<FileReference>
     */
    #[Cascade(['value' => 'remove'])]
    protected $media = null;

    /**
     * Questions
     *
     * @var ObjectStorage<Question>
     */
    #[Cascade(['value' => 'remove'])]
    protected $questions = null;

    /**
     * Evaluations
     *
     * @var ObjectStorage<Evaluation>
     */
    #[Cascade(['value' => 'remove'])]
    protected $evaluations = null;

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
    	$this->media = new ObjectStorage();
    	$this->questions = new ObjectStorage();
    	$this->evaluations = new ObjectStorage();
    	$this->categories = new ObjectStorage();
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
     * Returns the qtype
     *
     * @return int qtype
     */
    public function getQtype()
    {
        return $this->qtype;
    }

    /**
     * Sets the qtype
     *
     * @param int $qtype
     * @return void
     */
    public function setQtype($qtype)
    {
        $this->qtype = $qtype;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getMedia(): ObjectStorage
    {
        return $this->media;
    }

    /**
     * @param ObjectStorage<FileReference> $media
     */
    public function setMedia(ObjectStorage $media): void
    {
        $this->media = $media;
    }

    /**
     * Adds a medium
     *
     * @return void
     */
    public function addMedia(FileReference $media) {
        $this->media->attach($media);
    }

    /**
     * Removes a medium
     *
     * @return void
     */
    public function removeMedia(FileReference $media) {
        $this->media->detach($media);
    }

    /**
     * Adds a Question
     *
     * @return void
     */
    public function addQuestion(Question $question)
    {
        $this->questions->attach($question);
    }

    /**
     * Removes a Question
     *
     * @param Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(Question $questionToRemove)
    {
        $this->questions->detach($questionToRemove);
    }

    /**
     * Returns the questions
     *
     * @return ObjectStorage<Question> $questions
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Sets the questions
     *
     * @param ObjectStorage<Question> $questions
     * @return void
     */
    public function setQuestions(ObjectStorage $questions)
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
                    if (!isset($tags[$tag->getName()]) || !$tags[$tag->getName()]) {
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
                if (isset($tags[$tag->getName()]) && $tags[$tag->getName()]) {
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
     * @return void
     */
    public function addEvaluation(Evaluation $evaluation)
    {
        $this->evaluations->attach($evaluation);
    }

    /**
     * Removes a Evaluation
     *
     * @param Evaluation $evaluationToRemove The Evaluation to be removed
     * @return void
     */
    public function removeEvaluation(Evaluation $evaluationToRemove)
    {
        $this->evaluations->detach($evaluationToRemove);
    }

    /**
     * Returns the evaluations
     *
     * @return ObjectStorage<Evaluation> $evaluations
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Sets the evaluations
     *
     * @param ObjectStorage<Evaluation> $evaluations
     * @return void
     */
    public function setEvaluations(ObjectStorage $evaluations)
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
     * @return ObjectStorage<Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    /**
     * Sets the category
     *
     * @param ObjectStorage<Category> $categories
     * @return void
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }
    
    /**
     * Adds a category
     *
     * @return void
     */
    public function addCategory(Category $category) {
        $this->categories->attach($category);
    }
    
    /**
     * Removes a category
     *
     * @return void
     */
    public function removeCategory(Category $category) {
        $this->categories->detach($category);
    }
    				
    /**
     * Returns the maximum points for this quiz
     *
     * @return int $maximum2
     */
    public function getMaximum2($mode = 0)
    {
        $maximum2 = 0;
        foreach ($this->getQuestions() as $question) {
            $maximum1 = $question->getMaximum1();
            $add = 0;
            if ($maximum1 > 0) {
                $add = ($mode == 4) ? 1 : $maximum1;
            }
            $maximum2 += $add;
        }
        return $maximum2;
    }

    /**
     * @return int
     */
    public function getLocalizedUid() {
        return $this->_localizedUid;
    }
}
