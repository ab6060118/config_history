<?php

namespace OCA\OwnNotes;

interface IMessageHandler {

    /*
     * @param String
     * 
     */
    public function handle();

    /*
     *
     * @return String
     */
    public function getAppName();
}
