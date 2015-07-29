<?php

namespace OCA\ConfigHistory;

class FilesExternalMessageHandler implements IMessageHandler {

    const MESSAGE_HANDLER_APP = 'files_external';

    const SUBJECT_ALLOW_USER_MOUNTING = 'allow_user_mounting';
    const SUBJECT_ENABLED = 'enabled';
    const SUBJECT_INSTALLED_VERSION = 'installed_version';
    const SUBJECT_OCSID = 'ocsid';
    const SUBJECT_TYPES = 'types';
    const SUBJECT_USER_MOUNTING_BACKENDS = 'user_mounting_backends';

    const BACKEND_AMAZONS3 = '\OC\Files\Storage\AmazonS3';
    const BACKEND_DROPBOX = '\OC\Files\Storage\Dropbox';
    const BACKEND_FTP = '\OC\Files\Storage\FTP';
    const BACKEND_GOOGLE = '\OC\Files\Storage\Google';
    const BACKEND_SWIFT = '\OC\Files\Storage\Swift';
    const BACKEND_OWNCLOUD = '\OC\Files\Storage\OwnCloud';
    const BACKEND_SFTP = '\OC\Files\Storage\SFTP';
    const BACKEND_SFTP_KEY = '\OC\Files\Storage\SFTP_Key';
    const BACKEND_DAV = '\OC\Files\Storage\DAV';

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
            case self::SUBJECT_USER_MOUNTING_BACKENDS:
                $params[2] = $this->backendTranstate($params[2]);
            case self::SUBJECT_TYPES:
            case self::SUBJECT_OCSID:
            case self::SUBJECT_INSTALLED_VERSION:
            case self::SUBJECT_ENABLED:
            case self::SUBJECT_ALLOW_USER_MOUNTING:
                $params[1] = $this->keyGenerator($params[1]);
        }

        return $params;
    }

    public function getAppName() {
        return self::MESSAGE_HANDLER_APP;
    }

    private function backendTranstate($backends) {
        $backends = explode(',', $backends);
        foreach($backends as $key => $backend) {
            switch($backend) {
                case self::BACKEND_DAV:
                    $backend = 'WebDAV';
                    break;
                case self::BACKEND_SFTP_KEY:
                    $backend = 'SFTP with secret key login';
                    break;
                case self::BACKEND_SFTP:
                    $backend = 'SFTP';
                    break;
                case self::BACKEND_OWNCLOUD:
                    $backend = 'ownCloud';
                    break;
                case self::BACKEND_SWIFT:
                    $backend = 'OpenStack Object Storage';
                    break;
                case self::BACKEND_GOOGLE:
                    $backend = 'Google Drive';
                    break;
                case self::BACKEND_FTP:
                    $backend = 'FTP';
                    break;
                case self::BACKEND_DROPBOX:
                    $backend = 'Dropbox';
                    break;
                case self::BACKEND_AMAZONS3:
                    $backend = 'Amazon S3 and compliant';
                    break;
            }
            $backends[$key] = $this->l->t($backend);
        }

        return implode(", ", $backends);
    }

    /*
     *
     * @param String
     * @return String
     */
    public function keyGenerator($key, $appName = '') {
        return self::MESSAGE_HANDLER_APP.'_'.$key;
    }
}
