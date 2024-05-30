<?php
declare(strict_types=1);
namespace B13\Collapse\ViewHelpers\Collapse;

use B13\Container\Backend\Grid\ContainerGridColumnItem;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\AbstractGridObject;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentViewHelper extends CollapsibleViewHelper
{

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('row', 'array', 'Content record array', true);
        $this->registerArgument('type', AbstractGridObject::class, '', true);
    }

    public function render(): string
    {
        $type = $this->arguments['type'];
        $row = $this->arguments['row'];
        $contentElementId = $row['uid'];
        $identifier = 'tt_content_' . $contentElementId;

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        if ($type instanceof GridColumnItem && !$type instanceof ContainerGridColumnItem) {
            $recordTitle = BackendUtility::getRecordTitle('tt_content', $row);
            $typeLabel = $this->getTypeLabel($row);

            $isCollapsed = in_array($identifier, $this->getCollapsedItems(), true);

            return '<button type="button" 
            aria-expanded="' . ($isCollapsed ? 'false' : 'true') . '" 
            data-bs-toggle="collapse" 
            data-bs-target="#element-tt_content-' . $contentElementId . ' > .t3-page-ce-dragitem > .t3-page-ce-body > .element-preview" 
            class="btn btn-default btn-borderless" 
            data-b13-collapse="' . $identifier . '"
            data-b13-title="' . GeneralUtility::jsonEncodeForHtmlAttribute(['title' => $recordTitle, 'type' => $typeLabel]) . '"
            >'
                . $iconFactory->getIcon('actions-chevron-up', Icon::SIZE_SMALL)->render()
                . $iconFactory->getIcon('actions-chevron-down', Icon::SIZE_SMALL)->render()
                . '</button>';
        }

        return '';
    }

    public function getCollapsedItems(): array
    {
        $collapsedItems = parent::getCollapsedItems();
        return array_map(fn(int|string $item) => str_starts_with((string) $item, 'tt_content_') ? (string) $item : 'tt_content_' . $item, $collapsedItems);
    }

    protected function getTypeLabel(array $row): string
    {
        $typeValue = BackendUtility::getTCAtypeValue('tt_content', $row);
        $label = '';
        foreach ($GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'] as $itm) {
            if ($itm['value'] == $typeValue) {
                $label = $itm['label'];
                break;
            }
        }
        if ($label !== '') {
            return $GLOBALS['LANG']->sL($label);
        }

        return '';
    }
}
