<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Fixpunkt\FpMasterquiz\Widgets\Provider;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\WidgetApi;
use TYPO3\CMS\Dashboard\Widgets\ChartDataProviderInterface;

class ParticipantsDataProvider implements ChartDataProviderInterface
{
    /**
     * Number of days to gather information for.
     *
     * @var int
     */
    protected $days = 31;

    /**
     * @var array
     */
    protected $labels = [];

    /**
     * @var array
     */
    protected $data = [];

    public function __construct(int $days = 31)
    {
        $this->days = $days;
    }

    /**
     * @inheritDoc
     */
    public function getChartData(): array
    {
        $this->calculateDataForLastDays();

        return [
            'labels' => $this->labels,
            'datasets' => [
                [
                    'label' => $this->getLanguageService()->sL('LLL:EXT:fp_masterquiz/Resources/Private/Language/locallang_mod1.xlf:votes'),
                    'backgroundColor' => WidgetApi::getDefaultChartColors()[0],
                    'border' => 0,
                    'data' => $this->data,
                ],
            ],
        ];
    }

    protected function getNumberOfVotesInPeriod(int $start, int $end): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
        return (int)$queryBuilder
            ->count('*')
            ->from('tx_fpmasterquiz_domain_model_participant')
            ->where(
                $queryBuilder->expr()->gte(
                    'tstamp',
                    $queryBuilder->createNamedParameter($start, Connection::PARAM_INT)
                ),
                $queryBuilder->expr()->lte(
                    'tstamp',
                    $queryBuilder->createNamedParameter($end, Connection::PARAM_INT)
                )
            )
            ->executeQuery()
            ->fetchOne();
    }

    protected function calculateDataForLastDays(): void
    {
        $format = $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy'] ?: 'Y-m-d';

        for ($daysBefore = $this->days; $daysBefore >= 0; $daysBefore--) {
            $this->labels[] = date($format, (int)strtotime('-' . $daysBefore . ' day'));
            $startPeriod = (int)strtotime('-' . $daysBefore . ' day 0:00:00');
            $endPeriod = (int)strtotime('-' . $daysBefore . ' day 23:59:59');

            $this->data[] = $this->getNumberOfVotesInPeriod($startPeriod, $endPeriod);
        }
    }

    public function getRecentParticipants(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
        $dataArray = $queryBuilder
            ->select('tx_fpmasterquiz_domain_model_participant.uid AS partid', 'tx_fpmasterquiz_domain_model_participant.crdate AS startdate', 'tx_fpmasterquiz_domain_model_participant.name AS username', 'points', 'maximum2', 'quiztable.name AS quizname')
            ->from('tx_fpmasterquiz_domain_model_participant')
            ->join(
                'tx_fpmasterquiz_domain_model_participant',
                'tx_fpmasterquiz_domain_model_quiz',
                'quiztable',
                $queryBuilder->expr()->eq('quiztable.uid', $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_participant.quiz'))
            )
            ->orderBy('startdate', 'DESC')
            ->setMaxResults(7)
            ->executeQuery()
            ->fetchAllAssociative();
        $i = 0;
        foreach ($dataArray as $result) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_selected');
            $answerArray = $queryBuilder
                ->select('participant', 'answertable.title AS answertitle', 'questiontable.title AS questiontitle')
                ->from('tx_fpmasterquiz_domain_model_selected')
                ->where($queryBuilder->expr()->eq('participant', $queryBuilder->createNamedParameter((int) $result['partid'], \TYPO3\CMS\Core\Database\Connection::PARAM_INT)))
                ->join(
                    'tx_fpmasterquiz_domain_model_selected',
                    'tx_fpmasterquiz_selected_answer_mm',
                    'mmrel',
                    $queryBuilder->expr()->eq(
                        'mmrel.uid_local',
                        $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_selected.uid')
                    )
                )
                ->join(
                    'mmrel',
                    'tx_fpmasterquiz_domain_model_answer',
                    'answertable',
                    $queryBuilder->expr()->eq(
                        'answertable.uid',
                        $queryBuilder->quoteIdentifier('mmrel.uid_foreign')
                    )
                )
                ->join(
                    'tx_fpmasterquiz_domain_model_selected',
                    'tx_fpmasterquiz_domain_model_question',
                    'questiontable',
                    $queryBuilder->expr()->eq(
                        'questiontable.uid',
                        $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_selected.question')
                    )
                )
                ->orderBy('tx_fpmasterquiz_domain_model_selected.sorting', 'ASC')
                ->setMaxResults(1)
                ->executeQuery()
                ->fetchAllAssociative();
            foreach ($answerArray as $oneAnswer) {
                $dataArray[$i]['question1'] = $oneAnswer['questiontitle'];
                $dataArray[$i]['answer1'] = $oneAnswer['answertitle'];
            }
            
            $i++;
        }
        
        return $dataArray;
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}