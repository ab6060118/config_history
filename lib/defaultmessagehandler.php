<?php

namespace OCA\ConfigHistory;

class DefaultMessageHandler implements IMessageHandler {
    const MESSAGE_HANDLER_APP = 'default';

    const SUBJECT_INSTALLED_VERSION = 'installed_version';
    const SUBJECT_TYPES = 'types';
    const SUBJECT_OCSID = 'ocsid';
    const SUBJECT_ENABLED = 'enabled';

    protected $l;

    public function __construct(IL10N $l) {
        $this->l = $l;
    }

    /*
     * @param Array
     * @return Array
     */
    public function handle($params, $appName = '') {
        switch($params[1]) {
            case self::SUBJECT_OCSID:
            case self::SUBJECT_ENABLED:
            case self::SUBJECT_TYPES:
            case self::SUBJECT_INSTALLED_VERSION:
                $params[1] = $this->keyGenerator($params[1], $appName);
        }
        return $params;
    }

    public function getAppName() {
        return self::MESSAGE_HANDLER_APP;
    }

    /*
     *
     * @param String
     * @return String
     */
    public function keyGenerator($key, $appName = '') {
        return $appName.'_'.$key;
    }
}
