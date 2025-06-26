<?php

declare(strict_types=1);

defined('TYPO3') or die('Access denied.');

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets'] ?? null)) {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets'] = [];
}
$GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['b13/collapse'] = 'EXT:collapse/Resources/Public/Css/';
