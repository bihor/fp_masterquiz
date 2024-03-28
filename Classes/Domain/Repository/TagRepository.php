<?php
namespace Fixpunkt\FpMasterquiz\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
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
 * The repository for Tags
 */
class TagRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = ['sorting' => QueryInterface::ORDER_ASCENDING];
}
