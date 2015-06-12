<?php
namespace OCA\OwnNotes\AppInfo;

use \OCP\AppFramework\App;

use \OCA\OwnNotes\Hooks\UserHooks;


class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('ownnotes', $urlParams);

        $container = $this->getContainer();

        /**
         * Controllers
         */
        $container->registerService('UserHooks', function($c) {
            return new UserHooks(
                $c->query('ServerContainer')->getUserManager()
            );
        });
    }
}
