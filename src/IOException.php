<?php namespace Kedrigern\phpIO;

class PathIsNotDir extends \Exception {

	/** @var string */
	protected $path;

	/**
	 * @param string $path
	 */
	public function __construct($path) {
		$this->path = $path;
		parent::__construct($path . ' is not directory.');
	}
}

class NotEnoughPrivileges extends \Exception {

	/** @var string */
	protected $requiredPriv;

	/** @var int */
	protected $realPriv;

	/** @var string */
	protected $filename;

	/**
	 * @param string $required
	 * @param int $real
	 * @param string $filename
	 */
	public function __construct($required, $real, $filename) {
		$this->requiredPriv = $required;
		$this->realPriv = $real;
		$this->filename = $filename;
		parent::__construct("Not enough privileges for file " . $filename . " (required " . $this->requiredPriv . ")");
	}
}