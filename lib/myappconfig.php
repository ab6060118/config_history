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
        $type = User::TYPE_USER_CREATE;
        $affectuser= \OCP\User::getUser();
        Data::send($app, $key, array('test' => 1234), $value, '', 'None', 'None', $affectuser, $type);
        parent::setValue($app, $key, $value);
    }

}
