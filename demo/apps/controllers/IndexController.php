<?php

class IndexController extends Phalcon\Mvc\Controller {

	/*
	public function beforeSendResponse($response){
		$response->setContent('Hello');
	}
	*/

	// Action 默认使用的后缀，可以设置修改。
	public function indexAction() {
		$artists = Artists::find();
		$this->view->artists = $artists;
	}

	public function responseAction() {
		$viewmodel = new Phalcon\Mvc\View\Model(NULL, 'models/parent');
		$viewmodel->addChild(new Phalcon\Mvc\View\Model(NULL, 'models/child1'), 'child1');
		$viewmodel->addChild(new Phalcon\Mvc\View\Model(NULL, 'models/child2'), 'child2');
		$this->view->viewmodel = $viewmodel;

		return $this->response->setContent('response');
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
		return $this->response->redirect('/');
	}

	public function editAction($id) {
		$artist = Artists::findFirst($id);
		if (!$artist) {
			$this->response->redirect('/')->send();exit;
		}
		if ($this->request->isPost()) {
			$artist->name = $this->request->getPost('name');
			if ($artist->save()) {
				return $this->response->redirect('/');
			}
		}
		$this->view->artist = $artist;
	}

	public function searchAction() {
		// 获取页码，设置过滤类型 int
		$page = $this->request->get('page', 'int');
		// 获取查询关键字
		$keyword = $this->request->get('keyword', 'string');
		/*
		if (true) {
			$this->view->pick('index/list');
			$this->view->artists = Artists::find();
			throw new \Phalcon\ContinueException('提前结束');
		}
		*/

		// 创建 QueryBuilder
		$querybuilder = $this->modelsManager->createBuilder()->from('Artists');
		if ($keyword) {
			$querybuilder->where('name like :name:', ['name' => $keyword]);
		}

		$paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
		      "builder" => $querybuilder,
		      "limit"=> 5,
		      "page" => $page
		));
		$this->view->artists = $paginator->getPaginate();
	}
}
