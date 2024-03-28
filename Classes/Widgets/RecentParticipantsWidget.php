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
     * @var array
     */
    private $options;

    public function __construct(
        private readonly WidgetConfigurationInterface $configuration,
        private readonly StandaloneView               $view,
        private readonly ParticipantsDataProvider     $dataProvider,
        array                        $options = []
    )
    {
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

    public function getOptions(): array
    {
        return $this->options;
    }
}
