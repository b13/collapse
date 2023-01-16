<?php
declare(strict_types=1);

namespace B13\Collapse;

/*
 * This file is part of TYPO3 CMS-based extension "collapse" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageModuleModifier
{
    protected PageRenderer $pageRenderer;
    protected IconFactory $iconFactory;

    public function __construct(PageRenderer $pageRenderer, IconFactory $iconFactory)
    {
        $this->pageRenderer = $pageRenderer;
        $this->iconFactory = $iconFactory;
    }

    public function addCollapseButton(array $parameters, $parentObject): string
    {
        if ($parentObject instanceof PageLayoutView || $parentObject instanceof GridColumnItem) {
            $contentElementId = (int)$parameters[1];
            $isCollapsed = in_array($contentElementId, $this->getCollapsedItems(), true);
            return '<button type="button" aria-expanded="' . ($isCollapsed ? 'false' : 'true') . '" data-bs-toggle="collapse" data-bs-target="#element-tt_content-' . $contentElementId . ' > .t3-page-ce-dragitem > .t3-page-ce-body > .t3-page-ce-body-inner" class="btn btn-default btn-sm" data-b13-collapse="' . $contentElementId . '">'
                . $this->iconFactory->getIcon('actions-chevron-up', Icon::SIZE_SMALL)->render()
                . $this->iconFactory->getIcon('actions-chevron-down', Icon::SIZE_SMALL)->render()
            . '</button>';
        }
        return '';
    }

    public function addJavaScript(): string
    {
        $this->pageRenderer->loadRequireJsModule('TYPO3/CMS/Collapse/PageModuleCollapse');
        return '';
    }

    public function getCollapsedItems(): array
    {
        $result = $GLOBALS['BE_USER']->uc['B13']['Collapse'] ?? '';
        $collapsedItems = GeneralUtility::intExplode(',', $result);
        return array_filter($collapsedItems);
    }
}
