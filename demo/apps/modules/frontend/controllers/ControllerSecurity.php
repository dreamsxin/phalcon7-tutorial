<?php

namespace Frontend;

class ControllerSecurity extends \Phalcon\Mvc\Controller {

	public function beforeExecuteRoute() {
		parent::beforeExecuteRoute();
		if (!$this->user) {
			$this->flashSession->error('必须登录');
			$this->response->redirect('frontend/auth/index')->send();
		}
	}
}
