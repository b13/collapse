<?php
declare(strict_types=1);
namespace B13\Collapse\ViewHelpers;

use B13\Container\Backend\Grid\ContainerGridColumnItem;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\AbstractGridObject;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class CollapseViewHelper extends AbstractViewHelper
{

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('contentElementId', 'int', 'Content Element UID', true);
        $this->registerArgument('row', 'array', 'Content record array', true);
        $this->registerArgument('type', AbstractGridObject::class, '', true);
    }

    public function render(): string
    {
        $type = $this->arguments['type'];
        $row = $this->arguments['row'];
        $contentElementId = $this->arguments['contentElementId'];

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        if ($type instanceof GridColumnItem && !$type instanceof ContainerGridColumnItem) {
            $recordTitle = BackendUtility::getRecordTitle('tt_content', $row);
            $typeLabel = $this->getTypeLabel($row);
            $isCollapsed = in_array($contentElementId, $this->getCollapsedItems(), true);

            return '<button type="button" aria-expanded="' . ($isCollapsed ? 'false' : 'true') . '" data-bs-toggle="collapse" data-bs-target="#element-tt_content-' . $contentElementId . ' > .t3-page-ce-dragitem > .t3-page-ce-body > .element-preview" class="btn btn-default btn-sm" data-b13-collapse="' . $contentElementId . '" data-b13-title="' . GeneralUtility::jsonEncodeForHtmlAttribute(['title' => $recordTitle, 'type' => $typeLabel]) . '">'
                . $iconFactory->getIcon('actions-chevron-up', Icon::SIZE_SMALL)->render()
                . $iconFactory->getIcon('actions-chevron-down', Icon::SIZE_SMALL)->render()
                . '</button>';
        }

        return '';
    }

    public function getCollapsedItems(): array
    {
        $result = $GLOBALS['BE_USER']->uc['B13']['Collapse'] ?? '';
        $collapsedItems = GeneralUtility::intExplode(',', $result);

        return array_filter($collapsedItems);
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
