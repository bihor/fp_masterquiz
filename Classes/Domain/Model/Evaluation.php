<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\Category;
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
class Evaluation extends AbstractEntity
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
     * @var FileReference
     */
    #[Cascade(['value' => 'remove'])]
    protected $image;
    
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
     * @var ObjectStorage<Category>
     */
    protected $categories;

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
        $this->categories = new ObjectStorage();
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
    public function setEvaluate($evaluate): void
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
    public function setBodytext($bodytext): void
    {
    	$this->bodytext = $bodytext;
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
    public function setImage(FileReference $image): void
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
    public function setCe($ce): void
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
    public function setMinimum($minimum): void
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
    public function setMaximum($maximum): void
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
    public function setPage($page): void
    {
        $this->page = $page;
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
}
