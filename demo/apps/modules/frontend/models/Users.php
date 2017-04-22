<?php

namespace Frontend;

class Users extends \Phalcon\Mvc\Model {

	public function validation()
    {
        $validation = new \Phalcon\Validation;

		$validation->add('username', new \Phalcon\Validation\Validator\StringLength(
			array(
			   'max' => 30,
			   'min' => 6,
			)
		));
		$validation->add('username', new \Phalcon\Validation\Validator\Uniqueness);
		$validation->add('password', new \Phalcon\Validation\Validator\PresenceOf);

        return $this->validate($validation);
    }
}
