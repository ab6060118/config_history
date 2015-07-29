<?php

namespace OCA\OwnNotes;

class EncryptionMessageHandler implements IMessageHandler {

    const MESSAGE_HANDLER_APP = 'encryption';

    protected $appName;

    protected $l;

    public function __construct(IL10N $l) {
        $this->l = $l;
    }

    public function handle() {
    }

    public function getAppName() {
        return self::MESSAGE_HANDLER_APP;
    }
}
