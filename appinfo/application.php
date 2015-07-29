<?php
namespace OCA\ConfigHistory\AppInfo;

use OCP\AppFramework\App;

use OC\Files\View;
use OCA\Activity\Data;
use OCA\Activity\GroupHelper;
use OCA\Activity\UserSettings;
use OCA\Activity\DataHelper;
use OCA\Activity\ParameterHelper;

use OCA\ConfigHistory\Activity;
use OCA\ConfigHistory\MyAppConfig;
use OCA\ConfigHistory\EncryptionMessageHandler;
use OCA\ConfigHistory\FilesExternalMessageHandler;
use OCA\ConfigHistory\DefaultMessageHandler;
use OCA\ConfigHistory\AdminActivityManager;
use OCA\ConfigHistory\Controller\ConfigurationHistory;

class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('confighistory', $urlParams);

        $container = $this->getContainer();

        $container->getServer()->registerService('AppConfig', function($c) {
            return new \OCA\ConfigHistory\MyAppConfig(\OC_DB::getConnection());
        });

        $container->registerService('AdminActivityManager', function($c) {
            $serverContainer = $c->getServer();
            return new AdminActivityManager(
                $serverContainer->getRequest(),
                $serverContainer->getUserSession(),
                $serverContainer->getConfig()
            );
        });

        $container->registerService('AdminActivity', function($c) {
            $serverContainer = $c->getServer();
            return new Activity(
                $serverContainer->query('L10NFactory'),
                $serverContainer->getURLGenerator(),
                $c->query('Config')
            );
        });

		$container->registerService('L10N', function($c) {
			return $c->getServer()->getL10N('confighistory');
		});

        $container->registerService('ActivityData', function($c) {
            return new Data($c->query('AdminActivityManager'));
        });

        $container->registerService('Config', function($c) {
            return $c->getServer()->getConfig();
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
					$c->query('L10N'),
					$c->query('CurrentUID')
				),
				$c->query('L10N')
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
			$user = $c->getServer()->getUserSession()->getUser();
            
			return ($user) ? $user->getUID() : '';
		});


        $container->registerService('ConfigurationHistoryController', function($c) {
            return new ConfigurationHistory(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('ActivityData'),
				$c->query('GroupHelper'),
				$c->query('UserSettings'),
				$c->query('CurrentUID')
            );
        });

        $container->query('AdminActivityManager')->registerExtension(function() use ($container) {
            return $container->query('AdminActivity');
        });

        $container->query('AdminActivity')->registerMessageHandler(
            new EncryptionMessageHandler(
                $container->query('L10N')
            )
        );

        $container->query('AdminActivity')->registerMessageHandler(
            new FilesExternalMessageHandler(
                $container->query('L10N')
            )
        );

        $container->query('AdminActivity')->registerMessageHandler(
            new DefaultMessageHandler(
                $container->query('L10N')
            )
        );
    }
}
