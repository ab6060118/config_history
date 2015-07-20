<?php
\OCP\Util::addScript('ownnotes', 'settings');

$activityData = new \OCA\OwnNotes\Data();
$entries = $activityData->getEntries('admin_activity', 1);

$tmpl = new \OCP\Template('ownnotes', 'settings-admin');
$tmpl->assign('entries', $entries);

return $tmpl->fetchPage();
