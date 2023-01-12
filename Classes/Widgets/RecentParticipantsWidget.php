<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Widgets;

use Fixpunkt\FpMasterquiz\Widgets\Provider\ParticipantsDataProvider;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class RecentParticipantsWidget implements WidgetInterface
{
    /**
     * @var WidgetConfigurationInterface
     */
    private $configuration;

    /**
     * @var StandaloneView
     */
    private $view;

    /**
     * @var array
     */
    private $options;

    /**
     * @var ParticipantsDataProvider
     */
    private $dataProvider;

    public function __construct(
        WidgetConfigurationInterface $configuration,
        StandaloneView               $view,
        ParticipantsDataProvider     $dataProvider,
        array                        $options = []
    )
    {
        $this->configuration = $configuration;
        $this->view = $view;
        $this->dataProvider = $dataProvider;
        $this->options = array_merge(
            [
                'showErrors' => true,
                'showWarnings' => false
            ],
            $options
        );
    }

    public function renderWidgetContent(): string
    {
        $this->view->setTemplate('Widget/RecentParticipantsWidget');
        $this->view->assignMultiple([
            'configuration' => $this->configuration,
            'participants' => $this->dataProvider->getRecentParticipants()
        ]);
        return $this->view->render();
    }
}
