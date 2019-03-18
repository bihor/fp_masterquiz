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
 * The repository for Participants
 */
class ParticipantRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    
    /**
     * Fetches entries of a folder.
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFromPid($pageId) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->setOrderings([
            'tstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ]);
        $query->matching($query->equals('pid', $pageId));
        return $query->execute();
    }
}
