<?php

defined('TYPO3') or die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook']['collapse'] = \B13\Collapse\PageModuleModifier::class . '->addJavaScript';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['recStatInfoHooks']['collapse'] = \B13\Collapse\PageModuleModifier::class . '->addCollapseButton';
