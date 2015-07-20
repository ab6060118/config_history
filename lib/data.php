<?php
namespace OCA\OwnNotes;

use OCA\Activity\GroupHelperj;
use OCA\Activity\UserSettings;

use OCP\AppFramework\Http\JSONResponse;

class Data {

    const DEFAULT_SIZE = 5;

    private $data;
    private $settings;
    private $helper;

    public function __construct(OCA\Activity\Data $data, GroupHelper $helper, UserSettings $settings) {
        $this->data = $data;
        $this->settings = $settings;
        $this->helper = $helper;
    }

    public function getEntries($filter, $offset) {
        $offset = $offset-1;
        // return $this->data->read($this->helper, $this->settings, $offset * self::DEFAULT_SIZE, self::DEFAULT_SIZE, $filter);
    }

}
