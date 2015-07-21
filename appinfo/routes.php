<?php

namespace OCA\OwnNotes\AppInfo;

$application = new Application();
$application->registerRoutes($this, ['routes' => [
    ['name' => 'AdminActivities#fetch', 'url' => '/fetch', 'verb' => 'GET'],
]]);
