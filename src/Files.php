<?php namespace Kedrigern\phpIO;

class Files {

	/** @var string */
	protected $originDir;

	/** @var string */
	protected $dir;

	/** @var array */
	protected $files;

	/** @var string */
	protected $filter;

	/**
	 * @return string
	 */
	public function getDir() {
		return $this->dir;
	}

	/**
	 * @return array
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * @return string
	 */
	public function getFilter() {
		return $this->filter;
	}

	/**
	 * @param string $path
	 * @return Files $this
	 * @throws PathIsNotDir
	 * @throws NotEnoughPrivileges
	 */
	public function dir($path) {
		$this->originDir = getcwd();
		$this->dir = realpath(dirname($path));
		$this->filter = basename($path);

		if(is_dir($this->dir)) {
			chdir($this->dir);
		} else {
			throw new PathIsNotDir($this->dir);
		}

		$this->files = glob($this->filter);

		foreach($this->files as $file) {
			if(!is_readable($file)) {
				throw new NotEnoughPrivileges('read', fileperms($file), $file);
			}
		}

		chdir($this->originDir);
		return $this;
	}

	/**
	 * Is files writeable? If not exception is throw.
	 * @return Files $this
	 * @throws NotEnoughPrivileges
	 */
	public function writeable() {
		chdir($this->dir);
		foreach($this->files as $file) {
			if(!is_writeable($file)) {
				throw new NotEnoughPrivileges('write', fileperms($file), $file);
			}
		}
		chdir($this->originDir);
		return $this;
	}

	/**
	 * @param callable $function apply to the files
	 * @param null|callable $post function called after process all files
	 * @param null|array $log array of callback results (event post callback)
	 * @return Files $this
	 */
	public function call($function, $post = null, &$log = null) {
		$results = array();
		chdir($this->dir);

		if(is_callable($function)) {
			foreach($this->files as $key => $file) {
				if(is_file($file)) {
					$results[$key] = call_user_func($function, $file);
				}
			}
		}

		if(is_callable($post)) {
			$results['post'] = call_user_func($post, $results);
		}
		$log = $results;

		chdir($this->originDir);
		return $this;
	}

	/**
	 * Move files to the $path
	 * @param string $path
	 * @param bool $create
	 * @return Files $this
	 * @throws PathIsNotDir
	 */
	public function move($path, $create = false) {
		chdir($this->dir);

		if(!is_dir($path)) {
			if($create) {
				mkdir($path);
			} else {
				throw new PathIsNotDir($path);
			}
		}

		foreach($this->files as $file) {
			rename($file, $path.'/'.$file);
		}

		chdir($this->originDir);
		return $this;
	}

	/**
	 * Delete files
	 * @throws NotEnoughPrivileges
	 */
	public function delete() {
		chdir($this->dir);

		foreach($this->files as $file) {
			if(!is_writeable($file)) {
				throw new NotEnoughPrivileges('write', fileperms($file), $file);
			}
			unlink($file);
		}

		chdir($this->originDir);
	}
}