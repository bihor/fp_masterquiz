<?php
namespace Fixpunkt\FpMasterquiz\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
/***
 *
 * This file is part of the "Master-Quiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Kurt Gusbeth <k.gusbeth@fixpunkt.com>, fixpunkt werbeagentur gmbh
 *
 ***/
/**
 * Tag
 */
class Tag extends AbstractEntity
{

    /**
     * Name
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $name = '';

    /**
     * Period in seconds
     * 
     * @var int
     */
    protected $timeperiod = 0;

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
}
