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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

abstract class CollapsibleViewHelper extends AbstractViewHelper
{

    protected $escapeOutput = false;

    public function getCollapsedItems(): array
    {
        $result = $GLOBALS['BE_USER']->uc['B13']['Collapse'] ?? '';
        $collapsedItems = GeneralUtility::trimExplode(',', $result);

        return array_filter($collapsedItems);
    }
}
