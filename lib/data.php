<?php
namespace OCA\OwnNotes;

use OCP\DB;

class Data {
    public function getEntries($type, $conut=3, $start=0) {
        $data = array();
        $query = DB::prepare('SELECT * FROM `*PREFIX*activity` WHERE `type` = ? ORDER BY `timestamp` DESC', $conut, $start);
        $result= $query->execute(array($type));
        array_push($data, $result->fetchRow());

        return $result;
    }
}
