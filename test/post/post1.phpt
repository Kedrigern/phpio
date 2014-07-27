<?php

/**
 * Callback after calls after files are done.
 */

require_once __DIR__ . '/../bootstrap.php';

$files = new \Kedrigern\phpIO\Files();
$post = function() {
	throw new \Exception();
};

$files->dir('*.testf');
\Tester\Assert::exception(function() use ($files, $post) {
	$files->call(null, $post);
}, 'Exception');

