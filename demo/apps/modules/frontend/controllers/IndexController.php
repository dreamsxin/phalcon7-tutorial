<?php

namespace Frontend;

class IndexController extends ControllerBase {

	public function indexAction() {
		if (!$this->user) {
			$this->response->redirect('frontend/auth/index');
		}
	}
}
