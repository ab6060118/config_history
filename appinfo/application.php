<?php
namespace OCA\OwnNotes\AppInfo;

use OCP\AppFramework\App;

use OCA\OwnNotes\MyAppConfig;

class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('ownnotes', $urlParams);

        $container = $this->getContainer();

        $container->getServer()->registerService('AppConfig', function($c) {
            return new \OCA\OwnNotes\MyAppConfig(\OC_DB::getConnection());
        });

        $container->getServer()->getActivityManager()->registerExtension(function() {
            return new \OCA\OwnNotes\Activity(
                \OC::$server->query('L10NFactory'),
                \OC::$server->getURLGenerator()
            ); 
        });
    }
}
