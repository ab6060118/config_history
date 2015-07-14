<?php

namespace OCA\OwnNotes;

use OC\AppConfig;
use OC\DB\Connection;

use OCA\Activity\Data;
use OCA\OwnNotes\Extension\User;

class MyAppConfig extends AppConfig{
    public function __construct(Connection $conn) {
        parent::__construct($conn);
    }

    public function setValue($app, $key, $value) {
        $type = User::ADMIN_OPERATION;
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

        Data::send($app, $subject, array($key=>$value), '', '', '', '', '', $type);
        parent::setValue($app, $key, $value);
    }

}
