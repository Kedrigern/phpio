<?php

/**
 * Move to non-exists dir (exception)
 */

require_once __DIR__ . '/../bootstrap.php';

Tester\Environment::lock('move.lock', __DIR__);

$dir = 'done';

$files = new \Kedrigern\phpIO\Files();

$files->dir('./*.testf');

\Tester\Assert::same(__DIR__, $files->getDir());
\Tester\Assert::same('*.testf', $files->getFilter());

\Tester\Assert::exception(function() use ($files, $dir) {
	$files->move($dir);
}, 'Kedrigern\phpIO\PathIsNotDir');
