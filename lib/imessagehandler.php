<?php

namespace OCA\Config_History;

interface IMessageHandler {

    /*
     * @param Array
     * @param String
     * @return Array 
     */
    public function handle($params, $appName);

    /*
     * @return string
     */
    public function getAppName();

    /*
     * @param String
     * @return String
     */
    public function keyGenerator($key, $appName);
}
