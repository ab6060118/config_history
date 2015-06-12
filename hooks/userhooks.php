<?php
namespace OCA\OwnNotes\Hooks;

use OCA\OwnNotes\Service\NoteService;

class UserHooks {

    private $userManager;

    public function __construct($userManager){
        $this->userManager = $userManager;
    }

    public function register() {
        $callback = function($node) {
            return NoteService::create('123', '123', 'user');
        };
        $userManager->listen('\OC\Files', 'postCreate', $callback);
    }

}
