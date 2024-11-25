<?php

declare(strict_types=1);

namespace Fixpunkt\FpMasterquiz\Widgets;

use Fixpunkt\FpMasterquiz\Widgets\Provider\ParticipantsDataProvider;
use TYPO3\CMS\Dashboard\Widgets\RequestAwareWidgetInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Backend\View\BackendViewFactory;
use Psr\Http\Message\ServerRequestInterface;

class RecentParticipantsWidget implements WidgetInterface, RequestAwareWidgetInterface
{
    /**
     * @var array
     */
    private $options;
    private ?ServerRequestInterface $request = null;

    public function __construct(
        private readonly WidgetConfigurationInterface $configuration,
        private readonly BackendViewFactory $backendViewFactory,
        private readonly ParticipantsDataProvider     $dataProvider,
        array            $options = []
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

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function renderWidgetContent(): string
    {
        $view = $this->backendViewFactory->create($this->request, ['typo3/cms-dashboard', 'fixpunkt/fp-masterquiz']);
        $view->assignMultiple([
            'configuration' => $this->configuration,
            'participants' => $this->dataProvider->getRecentParticipants()
        ]);
        return $view->render('Widget/RecentParticipantsWidget');
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
