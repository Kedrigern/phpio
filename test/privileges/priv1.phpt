<?php

/**
 * Access file without privileges for read
 */

require_once __DIR__ . '/../bootstrap.php';

Tester\Environment::lock('priv.lock', __DIR__);

$file = "test.txt";

touch($file);
chmod($file, 0000);

$files = new \Kedrigern\phpIO\Files();

\Tester\Assert::exception(function() use ($files) {
	$files->dir('*.txt');
}, 'Kedrigern\phpIO\NotEnoughPrivileges');

unlink($file);