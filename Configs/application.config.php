<?php
return [
    'routes' => [
        '/reports/turn-over-per-brand' => [
            'controller' => 'Reports\\TurnOverReports\\TurnOverReportsController',
            'action' => 'turnOverPerBrandAction',
            'request-method' => 'GET',
        ],

        '/reports/turn-over-per-day' => [
            'controller' => 'Reports\\TurnOverReports\\TurnOverReportsController',
            'action' => 'turnOverPerDayAction',
            'request-method' => 'GET',
        ],

        '/reports/turn-over-per-day-per-brand' => [
            'controller' => 'Reports\\TurnOverReports\\TurnOverReportsController',
            'action' => 'turnOverPerDayPerBrandAction',
            'request-method' => 'GET',
        ]

    ]
];
