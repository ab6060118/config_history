<?php
\OCP\Util::addScript('ownnotes', 'settings');

$entries = \OCA\OwnNotes\Data::getEntries('admin_operation');

$tmpl = new \OCP\Template('ownnotes', 'settings-admin');
$tmpl->assign('entries', $entries);

return $tmpl->fetchPage();
