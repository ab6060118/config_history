<?php
namespace OCA\OwnNotes\Hooks;

class UserHooks {
    public static function createFile($parms) {
        return \OCA\OwnNotes\OwnNotes::createFile();
    }
}
