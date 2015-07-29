<?php

namespace OCA\ConfigHistory;

interface IMessageHandlerManager {

    /**
     *
     * @param OCA\ConfigHistory\IMessageHandler $messageHandler
     * @return void
     */
    public function registerMessageHandler(IMessageHandler $messageHandler);

}
