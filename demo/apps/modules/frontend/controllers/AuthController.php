<?php

namespace Frontend;

class AuthController extends \Phalcon\Mvc\Controller {

	// 登录
	public function indexAction() {
		if ($this->request->isPost()) {
			// 获取用户名和密码
			$username = $this->request->getPost('username', 'string');
			$password = $this->request->getPost('password');
			if (empty($username) || empty($password)) {
				$this->flashSession->error('登录失败');
			} else {
				$user = Users::findFirst([
					'username = :username:',
					'bind' => ['username' => $username]
				]);
				if ($user) {
					if ($this->security->checkHash($password, $user->password)) {
		                $this->flashSession->success('登录成功');
						$this->session->set('id', $user->id);
						return $this->response->redirect('frontend/index/index');
		            } else {
						$this->flashSession->error('密码错误');
					}
				} else {
					$this->flashSession->error('用户不存在');
				}
			}
		}
	}

	// 注册
	public function regAction() {
		$messages = [];
		if ($this->request->isPost()) {
			$user = new Users;
			$user->assign($_POST);
			// 这里我们可以先判断密码是否符合要求
			$validtor = new \Phalcon\Validation\Validator\StringLength;
			if (!$validtor->valid($user->password, 6, 18)) {
				$this->flashSession->success('注册失败');
				$messages['password'] = '密码不符合要求';
			} else {
				$user->password = $this->security->hash($user->password);
				if ($user->save()) {
					$this->flashSession->success('注册成功');
					return $this->response->redirect('frontend/auth/reg');
				} else {
					$this->flashSession->error('注册失败');
					foreach($user->getMessages() as $message) {
						$messages[$message->getField()] = $message->getMessage();
					}
				}
			}
		}
		$this->view->messages = $messages;
	}

	public function logoutAction() {
		$this->session->destroy();
		return $this->response->redirect('frontend/auth/index');
	}
}
