<?php

$EM_CONF['news_filter'] = [
    'title' => 'Filter for news',
    'description' => 'Filter news by categories, tags and time',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'mail@ringer.it',
    'state' => 'beta',
    'version' => '13.4.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'news' => '12.3.0-12.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
