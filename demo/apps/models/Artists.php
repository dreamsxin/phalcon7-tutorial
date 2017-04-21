<?php

class Artists extends Phalcon\Mvc\Model {

	public function validation()
    {
        $validation = new Phalcon\Validation;

		$validation->add('name', new Phalcon\Validation\Validator\StringLength(
			array(
			   'max' => 10,
			   'min' => 2,
			)
		));

        return $this->validate($validation);
    }
}
