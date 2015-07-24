<?php

namespace OCA\OwnNotes;

use OC\AppConfig;
use OC\DB\Connection;

use OCA\Activity\Data;

use OCP\User;

class MyAppConfig extends AppConfig{

    private $exceptionKey = ['lastcron', 'lastjob', 'lastupdateResult', 'lastupdatedat'];

    public function __construct(Connection $conn) {
        parent::__construct($conn);
    }

    public function setValue($app, $key, $value) {
        $type = Extension\User::ADMIN_OPERATION;
        $user = User::getUser();
        $inserted = false; 

		if (!$this->hasKey($app, $key)) {
			$inserted = (bool) $this->conn->insertIfNotExist('*PREFIX*appconfig', [
				'appid' => $app,
				'configkey' => $key,
				'configvalue' => $value,
			], [
				'appid',
				'configkey',
			]);
		}

		if (!$inserted) 
            $subject = 'update_value';
        else 
            $subject = 'create_value';

        if(!in_array($key, $this->exceptionKey)) {
            $usersInGroup = \OC_Group::usersInGroup('admin');
            foreach($usersInGroup as $affecteduser)
                Data::send($app, $subject, array($user, $key, $value), '', '', '', '', $affecteduser, $type);
        }

        parent::setValue($app, $key, $value);
    }

}
