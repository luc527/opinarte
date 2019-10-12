<?php
require_once "autoload.php";

abstract class AbsId {
	private $id;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}
}

?>