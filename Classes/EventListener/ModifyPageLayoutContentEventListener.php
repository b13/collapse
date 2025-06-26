<?php

declare(strict_types=1);

namespace B13\Collapse\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;
use TYPO3\CMS\Core\Page\PageRenderer;

final class ModifyPageLayoutContentEventListener
{
    public function __construct(private readonly PageRenderer $pageRenderer)
    {
    }

    public function __invoke(ModifyPageLayoutContentEvent $event): void
    {
        $this->pageRenderer->loadJavaScriptModule('@b13/collapse/PageModuleCollapse.js');
    }
}
