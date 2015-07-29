<?php
/**
 * ownCloud - confighistory
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author dauba <ab6060118@gmail.com>
 * @copyright dauba 2015
 */

namespace OCA\ConfigHistory\AppInfo;

$app = new Application();

\OCP\App::registerAdmin('confighistory', 'settings-admin');
