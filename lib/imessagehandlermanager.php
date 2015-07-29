<?php

namespace OCA\OwnNotes;

interface IMessageHandlerManager {

    /**
     *
     * @param OCA\OwnNotes\IMessageHandler $messageHandler
     * @return void
     */
    public function registerMessageHandler(IMessageHandler $messageHandler);

}
