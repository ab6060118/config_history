<?php

namespace OCA\OwnNotes\AppInfo;

$application = new Application();
$application->registerRoutes($this, ['routes' => [
    ['name' => 'ConfigurationHistory#fetch', 'url' => '/fetch', 'verb' => 'GET'],
]]);
