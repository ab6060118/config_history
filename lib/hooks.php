<?php
namespace OCA\OwnNotes;

use OCP\DB;
use OCP\Util;

class Hooks {
    public static function registerHooks() {
        Util::connectHook('OC_Filesystem', 'post_create', 'OCA\OwnNotes\Hooks', 'createFile');
        Util::connectHook('OC_User', 'post_createUser', 'OCA\OwnNotes\UserHooks', 'userCreate');
    }

    public static function createFile () {
        $query = DB::prepare("INSERT INTO `*PREFIX*ownnotes_notes` (`title`,`user_id`,`content`) VALUES (?,?,?)");
        $query->execute(array('123','user','test'));
    }
}
