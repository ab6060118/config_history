<?php
namespace OCA\OwnNotes\AppInfo;

use OCP\AppFramework\App;

use OC\Files\View;
use OCA\Activity\Data;
use OCA\Activity\GroupHelper;
use OCA\Activity\UserSettings;
use OCA\Activity\DataHelper;
use OCA\Activity\ParameterHelper;

use OCA\OwnNotes\Activity;
use OCA\OwnNotes\MyAppConfig;
use OCA\OwnNotes\AdminActivityManager;
use OCA\OwnNotes\Controller\AdminActivities;

class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('ownnotes', $urlParams);

        $container = $this->getContainer();

        $container->getServer()->registerService('AppConfig', function($c) {
            return new \OCA\OwnNotes\MyAppConfig(\OC_DB::getConnection());
        });

        $container->registerService('AdminActivityManager', function($c) {
            $serverContainer = $c->getServer();
            return new AdminActivityManager(
                $serverContainer->getRequest(),
                $serverContainer->getUserSession(),
                $serverContainer->getConfig()
            );
        });

		$container->registerService('AdminActivityL10N', function($c) {
			return $c->getServer()->getL10N('ownnotes');
		});

        $container->registerService('ActivityData', function($c) {
            return new Data($c->query('AdminActivityManager'));
        });

		$container->registerService('DataHelper', function($c) {
            $serverContainer = $c->getServer();
			/** @var \OC\Server $server */
			return new DataHelper(
                $c->query('AdminActivityManager'),
				new ParameterHelper (
                    $c->query('AdminActivityManager'),
					$serverContainer->getUserManager(),
					new View(''),
					$serverContainer->getConfig(),
					$c->query('AdminActivityL10N'),
					$c->query('CurrentUID')
				),
				$c->query('AdminActivityL10N')
			);
		});

		$container->registerService('GroupHelper', function($c) {
			return new GroupHelper(
                $c->query('AdminActivityManager'),
				$c->query('DataHelper'),
				true
			);
		});

        $container->registerService('UserSettings', function($c) {
            $serverContainer = $c->getServer();
			return new UserSettings(
				$c->query('AdminActivityManager'),
				$serverContainer->getConfig(),
				$c->query('ActivityData')
			);
        });

		$container->registerService('CurrentUID', function($c) {
            $serverContainer = $c->getServer();
			$user = $serverContainer->getUserSession()->getUser();
            
			return ($user) ? $user->getUID() : '';
		});


        $container->registerService('AdminActivitiesController', function($c) {
            return new AdminActivities(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('ActivityData'),
				$c->query('GroupHelper'),
				$c->query('UserSettings'),
				$c->query('CurrentUID')
            );
        });


        $container->query('AdminActivityManager')->registerExtension(function() {
            return new Activity(
                \OC::$server->query('L10NFactory'),
                \OC::$server->getURLGenerator()
            ); 
        });
    }
}
