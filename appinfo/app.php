<?php
/**
 * ownCloud - ownnotes
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author dauba <ab6060118@gmail.com>
 * @copyright dauba 2015
 */

namespace OCA\OwnNotes\AppInfo;

$app = new Application();
$container = $app->getContainer();

\OCP\App::registerAdmin('ownnotes', 'settings-admin');
