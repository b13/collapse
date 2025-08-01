<?php

declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'Content Element Collapse or Expand View in TYPO3 Page Module',
    'description' => 'Collapse large content element previews in TYPO3\'s Page Module.',
    'category' => 'be',
    'state' => 'stable',
    'author' => 'b13 GmbH',
    'author_email' => 'typo3@b13.com',
    'author_company' => '',
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
