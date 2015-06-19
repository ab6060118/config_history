<?php
namespace OCA\OwnNotes;

use OCA\OwnNotes\Service\NoteService;
use OCP\DB;

class OwnNotes {
    public static function registerHooks() {
        \OCP\Util::connectHook('OC_Filesystem', 'post_create', 'OCA\OwnNotes\OwnNotes', 'createFile');
    }

    public static function createFile () {
        $query = DB::prepare("INSERT INTO `*PREFIX*ownnotes_notes` (`title`,`user_id`,`content`) VALUES (?,?,?)");
        $query->execute(array('123','test','test'));
        // return \OCA\OwnNotes\Service\NoteService::create('123', '123', 'user');
    }
}
