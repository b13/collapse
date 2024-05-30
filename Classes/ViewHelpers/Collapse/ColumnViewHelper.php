<?php
declare(strict_types=1);
namespace B13\Collapse\ViewHelpers\Collapse;

use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumn;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ColumnViewHelper extends CollapsibleViewHelper
{

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('page', 'array', 'Page record array', true);
        $this->registerArgument('column', GridColumn::class, '', true);
    }

    public function render(): string
    {
        $page = $this->arguments['page'];
        /** @var GridColumn $column */
        $column = $this->arguments['column'];

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        if ($column instanceof GridColumn) {
            $identifier = sprintf('column_%s_%s', $column->getColumnNumber(), $page['uid']);
            $isCollapsed = in_array($identifier, $this->getCollapsedItems(), true);

            return '<button type="button" 
            aria-expanded="' . ($isCollapsed ? 'false' : 'true') . '" 
            data-bs-toggle="collapse" 
            data-bs-target=".t3-page-column-' . $column->getColumnNumber() .' > .t3-page-ce-wrapper" 
            class="btn btn-default btn-borderless" 
            data-b13-collapse="' . $identifier . '">'
                . $iconFactory->getIcon('actions-chevron-up', Icon::SIZE_SMALL)->render()
                . $iconFactory->getIcon('actions-chevron-down', Icon::SIZE_SMALL)->render()
                . '</button>';
        }

        return '';
    }

}
