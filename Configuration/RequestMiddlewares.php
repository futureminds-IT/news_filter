<?php
return [
    'frontend' => [
        'georgringer-newsfilter-noncacheable' => [
            'target' => \GeorgRinger\NewsFilter\Middleware\NewsFilterNonCacheableMiddleware::class,
            'after' => [
                'typo3/cms-frontend/maintenance-mode',
            ],
        ],
    ],
];
