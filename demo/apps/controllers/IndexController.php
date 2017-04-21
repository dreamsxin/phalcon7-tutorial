<?php

class IndexController extends Phalcon\Mvc\Controller {

	// Action 默认使用的后缀，可以设置修改。
	public function indexAction() {
		$artists = Artists::find();
		$this->view->artists = $artists;
	}

	public function addAction() {
		$messages = [];
		if ($this->request->isPost()) {
			$artist = new Artists;
			$artist->name = $this->request->getPost('name');
			if ($artist->save()) {
				$this->response->redirect('/')->send();exit;
			} else {
				foreach($artist->getMessages() as $message) {
					$messages[$message->getField()] = $message->getMessage();
				}
			}
		}
		$this->view->messages = $messages;
	}

	public function delAction($id) {
		$artist = Artists::findFirst($id);
		if ($artist) {
			if ($artist->delete()) {
				// 删除成功
			}
		}
		$this->response->redirect('/')->send();exit;
	}

	public function editAction($id) {
		$artist = Artists::findFirst($id);
		if (!$artist) {
			$this->response->redirect('/')->send();exit;
		}
		if ($this->request->isPost()) {
			$artist->name = $this->request->getPost('name');
			if ($artist->save()) {
				$this->response->redirect('/')->send();exit;
			}
		}
		$this->view->artist = $artist;
	}
}
