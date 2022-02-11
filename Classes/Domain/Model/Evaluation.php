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
 * Evaluation of a quiz/test
 */
class Evaluation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Evaluate points (unchecked) or percentage (checked)?
     *
     * @var bool
     */
    protected $evaluate = false;

    /**
     * Minimum value
     *
     * @var float
     */
    protected $minimum = 0;

    /**
     * Maximum value
     *
     * @var float
     */
    protected $maximum = 0;
    
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
     * Show this content element at the final page
     *
     * @var int
     */
    protected $ce = 0;

    /**
     * Or redirect to this page
     *
     * @var int
     */
    protected $page = 0;

    /**
     * category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories = null;

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
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the evaluate
     *
     * @return bool $evaluate
     */
    public function getEvaluate()
    {
        return $this->evaluate;
    }

    /**
     * Sets the evaluate
     *
     * @param bool $evaluate
     * @return void
     */
    public function setEvaluate($evaluate)
    {
        $this->evaluate = $evaluate;
    }

    /**
     * Returns the boolean state of evaluate
     *
     * @return bool
     */
    public function isEvaluate()
    {
        return $this->evaluate;
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
     * Returns the ce
     *
     * @return int $ce
     */
    public function getCe()
    {
        return $this->ce;
    }

    /**
     * Sets the ce
     *
     * @param int $ce
     * @return void
     */
    public function setCe($ce)
    {
        $this->ce = $ce;
    }

    /**
     * Returns the minimum
     *
     * @return float minimum
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * Sets the minimum
     *
     * @param int $minimum
     * @return void
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;
    }

    /**
     * Returns the maximum
     *
     * @return float maximum
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * Sets the maximum
     *
     * @param int $maximum
     * @return void
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;
    }

    /**
     * Returns the page
     *
     * @return int page
     */
    public function getPage()
    {
        return $this->page;
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
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
