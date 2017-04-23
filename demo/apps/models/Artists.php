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

	public function afterFetch() {
		$this->name = '歌手：'.$this->name;
	}

	public function afterToArray($data) {
		$data['name'] = '我是'.$data['name'];
		// 这里必须返回格式化后的数据
		return $data;
	}
}
