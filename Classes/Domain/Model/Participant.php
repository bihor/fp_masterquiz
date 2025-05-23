<?php

namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * Participant
 */
class Participant extends AbstractEntity
{
    /**
     * @var \DateTime
     */
    protected $tstamp;

    /**
     * @var \DateTime
     */
    protected $crdate;

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
     * List of random pages for this user
     *
     * @var string
     */
    protected $randompages = '';

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
     * @var Quiz
     */
    protected $quiz;

    /**
     * Answered questions
     *
     * @var ObjectStorage<Selected>
     */
    #[Cascade(['value' => 'remove'])]
    protected $selections;

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
    	$this->selections = new ObjectStorage();
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
    public function setName($name): void
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
    public function setEmail($email): void
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
    public function setHomepage($homepage): void
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
     * Returns the username
     */
    public function getUsername(): string
    {
        if ($this->user) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
            $statement = $queryBuilder
                ->select('username')
                ->from('fe_users')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter(intval($this->user), \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
                )
                ->setMaxResults(1)
                ->executeQuery();
            $rows = $statement->fetchAllAssociative();
            foreach ($rows as $row) {
                return $row['username'];
            }
        }
        return '';
    }

    /**
     * Sets the user
     *
     * @param int $user
     * @return void
     */
    public function setUser($user): void
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
    public function setSession($session): void
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
    public function setSessionstart($sessionstart): void
    {
        $this->sessionstart = $sessionstart;
    }

    /**
     * Returns the randompages
     *
     * @return array $randompages
     */
    public function getRandompages()
    {
        return explode(',', $this->randompages);
    }

    /**
     * Sets the randompages
     *
     * @param array $randompages
     * @return void
     */
    public function setRandompages($randompages): void
    {
        $this->randompages = implode(',', $randompages);
    }

    /**
     * Returns the quiz
     *
     * @return Quiz $quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Sets the quiz
     *
     * @return void
     */
    public function setQuiz(Quiz $quiz): void
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
    public function setIp($ip): void
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
    public function setPoints($points): void
    {
        $this->points = $points;
    }

    /**
     * Sets the more points
     *
     * @param int $points
     * @return void
     */
    public function addPoints($points): void
    {
        $this->points += $points;
    }

    /**
     * Sets the minus points
     *
     * @param int $points
     * @return void
     */
    public function subtractPoints($points): void
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
     * Sets the maximum1 (maximum bisher)
     *
     * @param int $maximum1
     * @return void
     */
    public function setMaximum1($maximum1): void
    {
        $this->maximum1 = $maximum1;
    }

    /**
     * Increments the maximum1
     *
     * @param int $maximum1
     * @return void
     */
    public function addMaximum1($maximum1): void
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
     * Sets the maximum2 (maximum gesamt)
     *
     * @param int $maximum2
     * @return void
     */
    public function setMaximum2($maximum2): void
    {
        $this->maximum2 = $maximum2;
    }

    /**
     * Sets the page
     *
     * @param int $page
     * @return void
     */
    public function setPage($page): void
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
    public function setCompleted($completed): void
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
     * Returns the most selected category
     *
     * @return array
     */
    public function getCategoryMost()
    {
        $mostValue = 0;
        $mostUid = 0;
        $mostArray = [];
        $mostEntry = [];
        $generalArray = [];
        foreach ($this->selections as $selection) {
            foreach ($selection->getAnswers() as $answer) {
                $cats = $answer->getCategories();
                foreach ($cats as $cat) {
                    $uid = $cat->getUid();
                    if (isset($mostArray[$uid])) {
                        $mostArray[$uid]++;
                    } else {
                        $mostArray[$uid] = 1;
                        $generalArray[$uid] = [];
                        $generalArray[$uid]['title'] = $cat->getTitle();
                    }
                }
            }
        }

        foreach ($mostArray as $key => $value) {
            $generalArray[$key]['count'] = $value;
            if ($value > $mostValue) {
                $mostUid = $key;
                $mostValue = $value;
            }
        }

        $mostEntry['uid'] = $mostUid;
        $mostEntry['count'] = $mostValue;
        $mostEntry['title'] = $generalArray[$mostUid]['title'];
        $mostEntry['all'] = $generalArray;
        return $mostEntry;
    }

    /**
     * Adds a Selected
     *
     * @return void
     */
    public function addSelection(Selected $selection): void
    {
        $this->selections->attach($selection);
    }

    /**
     * Removes a Selected
     *
     * @param Selected $selectionToRemove The Selected to be removed
     * @return void
     */
    public function removeSelection(Selected $selectionToRemove): void
    {
        $this->selections->detach($selectionToRemove);
    }

    /**
     * Returns the selections
     *
     * @return ObjectStorage<Selected> selections
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
     */
    public function getSortedSelections(): array
    {
        $sortedSelections = [];
        $i = 0;
        $hasTags = false;
        foreach ($this->selections as $selection) {
            $sorting = $selection->getSorting();
            if ($sorting == 0) {
                $sorting = $i;
            }

            if (is_object($selection->getQuestion()) && $selection->getQuestion()->getTag()) {
                $hasTags = true;
            }

            $sortedSelections[$sorting] = $selection;
            $i++;
        }

        ksort($sortedSelections);
        if ($hasTags) {
            // prev und next Tag immer setzen, wenn Tags vorhanden sind
            $lastItem = null;
            $lastTag = '';
            foreach ($sortedSelections as $selection) {
                $itemQuestion = $selection->getQuestion();
                if (is_object($itemQuestion)) {
                    if ($lastItem) {
                        $lastItem->setNextTag($itemQuestion->getTag()->getName());
                    }

                    if (($lastTag)) {
                        $itemQuestion->setPrevTag($lastTag);
                    }

                    $lastTag = $itemQuestion->getTag()->getName();
                    $lastItem = $itemQuestion;
                }
            }
        }

        return $sortedSelections;
    }

    /**
     * Sets the selections
     *
     * @param ObjectStorage<Selected> $selections
     * @return void
     */
    public function setSelections(ObjectStorage $selections): void
    {
        $this->selections = $selections;
    }
}
