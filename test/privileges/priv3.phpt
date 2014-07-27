<?php

/**
 * Delete file without privileges for write
 */

require_once __DIR__ . '/../bootstrap.php';

Tester\Environment::lock('priv.lock', __DIR__);

$file = "test.txt";

touch($file);
chmod($file, 0444);

$files = new \Kedrigern\phpIO\Files();

$files->dir('*.txt');

\Tester\Assert::exception(function() use ($files) {
	$files->delete();
}, 'Kedrigern\phpIO\NotEnoughPrivileges');

unlink($file);