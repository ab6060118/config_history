<?php

namespace OCA\OwnNotes;

use OCA\Activity\Data;
use OCA\OwnNotes\Extension\User;

class UserHooks {
    public static function userCreate($params) {
        $type = User::TYPE_USER_CREATE;
        $affectuser= \OCP\User::getUser();
        Data::send('ownnote', 'test', array('test' => 1234), '', $params, 'None', 'None', $affectuser, $type);
    }
}
