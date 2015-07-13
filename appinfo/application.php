<?php
namespace OCA\OwnNotes\AppInfo;

use OCP\AppFramework\App;

use OCA\OwnNotes\MyAppConfig;

class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('ownnotes', $urlParams);

        $container = $this->getContainer();

        $container->getServer()->registerService('AppConfig', function($c) {
            // echo 'alert("test");';
            return new \OCA\OwnNotes\MyAppConfig(\OC_DB::getConnection());
        });
    }
}
