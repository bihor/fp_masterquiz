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

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\WidgetApi;
use TYPO3\CMS\Dashboard\Widgets\ChartDataProviderInterface;

class RecentParticipantsDataProvider implements ChartDataProviderInterface
{
    /**
     * @var array
     */
    protected $labels = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @inheritDoc
     */
    public function getChartData(): array
    {
        return [
            'labels' => $this->labels,
            'datasets' => [
                [
                    'label' => $this->getLanguageService()->sL('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.sysLogErrors.chart.dataSet.0'),
                    'backgroundColor' => WidgetApi::getDefaultChartColors()[0],
                    'border' => 0,
                    'data' => $this->data,
                ],
            ],
        ];
    }

    public function getRecentParticipants(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fpmasterquiz_domain_model_participant');
        return $queryBuilder
            ->select('tx_fpmasterquiz_domain_model_participant.crdate AS startdate','tx_fpmasterquiz_domain_model_participant.name AS username', 'points', 'maximum2', 'quiz.name AS quizname')
            ->from('tx_fpmasterquiz_domain_model_participant')
            ->join(
                'tx_fpmasterquiz_domain_model_participant',
                'tx_fpmasterquiz_domain_model_quiz',
                'quiz',
                $queryBuilder->expr()->eq('quiz.uid', $queryBuilder->quoteIdentifier('tx_fpmasterquiz_domain_model_participant.quiz'))
            )
            ->orderBy('startdate', 'DESC')
            ->setMaxResults(8)
            ->execute()
            ->fetchAll();
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}