<?php
/**
 * ownCloud - ownnotes
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author dauba <ab6060118@gmail.com>
 * @copyright dauba 2015
 */

namespace OCA\OwnNotes\Controller;

use OCP\IRequest;

use OCA\OwnNotes\Data;

class AdminActivitiesController extends Controller {

    private $data;

	public function __construct($AppName, IRequest $request Data $data){
		parent::__construct($AppName, $request);
        $this->data = $data;
	}

    public function getEntries($filter, $count, $start) {
        return DataResponse($this->data->getEntries($filter, $count, $start));
    }
}
