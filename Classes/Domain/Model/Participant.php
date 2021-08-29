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
 * Participant
 */
class Participant extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var \DateTime
     */
    protected $tstamp = null;

    /**
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * Name
     *
     * @var string
     */
    protected $name = '';

    /**
     * E-Mail
     *
     * @var string
     */
    protected $email = '';

    /**
     * Homepage
     *
     * @var string
     */
    protected $homepage = '';

    /**
     * fe-user
     *
     * @var int
     */
    protected $user = 0;

    /**
     * IP-address
     *
     * @var string
     */
    protected $ip = '';

    /**
     * Session-key
     *
     * @var string
     */
    protected $session = '';

    /**
     * Start time of the session
     *
     * @var int
     */
    protected $sessionstart = 0;

    /**
     * Reached points for this quiz
     *
     * @var int
     */
    protected $points = 0;

    /**
     * Maximum points for the answered questions
     *
     * @var int
     */
    protected $maximum1 = 0;

    /**
     * Maximum points for this quiz
     *
     * @var int
     */
    protected $maximum2 = 0;
    
    /**
     * Reached page
     *
     * @var int
     */
    protected $page = 0;
    
    /**
     * Quiz completed?
     *
     * @var bool
     */
    protected $completed = false;
    
    /**
     * Participated quiz: darf in TYPO3 10 nicht lazy sein!
     *
     * @var \Fixpunkt\FpMasterquiz\Domain\Model\Quiz
     */
    protected $quiz = null;

    /**
     * Answered questions
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Selected>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $selections = null;
    
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
    	$this->selections = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the creation date
     *
     * @return \DateTime $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Returns the last modified date
     *
     * @return \DateTime $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Returns the creation date - start-session-time in seconds
     *
     * @return \DateTime $crdate
     */
    public function getStartdate()
    {
        if ($this->sessionstart > 0) {
            $date = clone $this->crdate;
            return $date->sub(new \DateInterval('PT' . $this->sessionstart . 'S'));
        } else {
            return $this->crdate;
        }
    }

    /**
     * Returns the time passed till now
     *
     * @return int
     */
    public function getTimePassed()
    {
        if ($this->crdate && $this->crdate->getTimestamp()) {
            // Seite 3-x
            return time() - ($this->crdate->getTimestamp() - $this->sessionstart);
        } elseif ($this->sessionstart) {
            // Seite 2
            return $this->sessionstart;
        } else {
            // Seite 1
            return 0;
        }
    }

    /**
     * Returns the dates are equal?
     *
     * @return bool
     */
    public function getDatesNotEqual()
    {
        return ($this->getStartdate() != $this->tstamp);
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
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the homepage
     *
     * @return string $homepage
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Sets the homepage
     *
     * @param string $homepage
     * @return void
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * Returns the user
     *
     * @return int $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     *
     * @param int $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Returns the session
     *
     * @return string $session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Sets the session
     *
     * @param string $session
     * @return void
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Returns the session start time
     *
     * @return int $sessionstart
     */
    public function getSessionstart()
    {
        return $this->sessionstart;
    }

    /**
     * Sets the session start time
     *
     * @param int $sessionstart
     * @return void
     */
    public function setSessionstart($sessionstart)
    {
        $this->sessionstart = $sessionstart;
    }

    /**
     * Returns the quiz
     *
     * @return \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Sets the quiz
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz
     * @return void
     */
    public function setQuiz(\Fixpunkt\FpMasterquiz\Domain\Model\Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * Returns the ip
     *
     * @return string $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Sets the ip
     *
     * @param string $ip
     * @return void
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
     * @param int $points
     * @return void
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * Sets the more points
     *
     * @param int $points
     * @return void
     */
    public function addPoints($points)
    {
        $this->points += $points;
    }

    /**
     * Sets the minus points
     *
     * @param int $points
     * @return void
     */
    public function subtractPoints($points)
    {
        $this->points -= $points;
    }

    /**
     * Returns the maximum1
     *
     * @return int maximum1
     */
    public function getMaximum1()
    {
        return $this->maximum1;
    }

    /**
     * Returns the maximum1 in percent
     *
     * @return int percent1
     */
    public function getPercent1()
    {
        return 100 * ($this->points / $this->maximum1);
    }

    /**
     * Sets the maximum1
     *
     * @param int $maximum1
     * @return void
     */
    public function setMaximum1($maximum1)
    {
        $this->maximum1 = $maximum1;
    }

    /**
     * Increments the maximum1
     *
     * @param int $maximum1
     * @return void
     */
    public function addMaximum1($maximum1)
    {
        $this->maximum1 += $maximum1;
    }

    /**
     * Returns the maximum2
     *
     * @return int maximum2
     */
    public function getMaximum2()
    {
        return $this->maximum2;
    }

    /**
     * Returns the maximum2 in percent
     *
     * @return int maximum2
     */
    public function getPercent2()
    {
        return 100 * ($this->points / $this->maximum2);
    }

    /**
     * Sets the maximum2
     *
     * @param int $maximum2
     * @return void
     */
    public function setMaximum2($maximum2)
    {
        $this->maximum2 = $maximum2;
    }
    
    /**
     * Sets the page
     *
     * @param int $page
     * @return void
     */
    public function setPage($page)
    {
    	$this->page = $page;
    }
    
    /**
     * Get the page
     *
     * @return int $page
     */
    public function getPage()
    {
    	return $this->page;
    }
    
    /**
     * Returns the completed
     *
     * @return bool
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Sets the completed
     *
     * @param bool $completed
     * @return void
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * Returns the boolean state of completed
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->completed;
    }
    
    /**
     * Adds a Selected
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Selected $selection
     * @return void
     */
    public function addSelection(\Fixpunkt\FpMasterquiz\Domain\Model\Selected $selection)
    {
        $this->selections->attach($selection);
    }

    /**
     * Removes a Selected
     *
     * @param \Fixpunkt\FpMasterquiz\Domain\Model\Selected $selectionToRemove The Selected to be removed
     * @return void
     */
    public function removeSelection(\Fixpunkt\FpMasterquiz\Domain\Model\Selected $selectionToRemove)
    {
        $this->selections->detach($selectionToRemove);
    }

    /**
     * Returns the selections
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Selected> selections
     */
    public function getSelections()
    {
        return $this->selections;
    }

    /**
     * Returns the selections by tag
     *
     * @param string $tag Tag-Name
     * @return array $sortedSelections
     */
    public function getSelectionsByTag($tag)
    {
        $sortedSelections = [];
        $i = 0;
        foreach ($this->selections as $selection) {
            $sorting = $selection->getSorting();
            if ($sorting == 0) {
                $sorting = $i;
            }
            if ($selection->getQuestion()->getTag()->getName() == $tag) {
                $sortedSelections[$sorting] = $selection;
            }
            $i++;
        }
        ksort($sortedSelections);
        return $sortedSelections;
    }

    /**
     * Returns the sorted selections
     *
     * @return array sortedSelections
     */
    public function getSortedSelections()
    {
    	$sortedSelections = [];
    	$i = 0;
    	foreach ($this->selections as $selection) {
    		$sorting = $selection->getSorting();
    		if ($sorting == 0) {
    			$sorting = $i;
    		}
    		$sortedSelections[$sorting] = $selection;
    		$i++;
    	}
    	ksort($sortedSelections);
    	return $sortedSelections;
    }
    
    /**
     * Sets the selections
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Fixpunkt\FpMasterquiz\Domain\Model\Selected> $selections
     * @return void
     */
    public function setSelections(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $selections)
    {
        $this->selections = $selections;
    }
}
