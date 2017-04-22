<?php

namespace Frontend;

class ControllerBase extends \Phalcon\Mvc\Controller {

	public $user;
	public function beforeExecuteRoute() {
		if ($this->session->get('id')) {
			$this->user = Users::findFirst($this->session->get('id'));
		}
	}
}
