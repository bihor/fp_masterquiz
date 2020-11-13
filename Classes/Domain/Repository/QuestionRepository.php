<?php
namespace Fixpunkt\FpMasterquiz\Domain\Repository;

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
 * The repository for Questions
 */
class QuestionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];
    
    /**
     * Fetches questions of with no relation.
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findLostQuestions($pageId) {
    	$query = $this->createQuery();
    	$query->getQuerySettings()->setRespectStoragePage(FALSE);
    	$query->matching(
    		$query->logicalAnd(
    			$query->equals('pid', $pageId),
    			$query->equals('quiz', 0)
    		)
    	);
    	return $query->execute();
    }
    
    /**
     * Get the PIDs
     *
     * @return array
     */
    public function getStoragePids() {
    	$query = $this->createQuery();
    	return $query->getQuerySettings()->getStoragePageIds();
    }
}
