<?php

/**
 * Select proper files (relative path)
 */

require_once __DIR__ . '/../bootstrap.php';

$correct = array("a.testf", "b.testf", "c.testf", "d.testf");
$false = array("e.test", "f.testfa");
$all = array_merge($correct, $false);

Tester\Environment::lock('basic.lock', __DIR__);

foreach($all as $file) {
	touch($file); // create files
}

$files = new \Kedrigern\phpIO\Files();

$files->dir('./*.testf');

\Tester\Assert::same(__DIR__, $files->getDir());
\Tester\Assert::same('*.testf', $files->getFilter());
\Tester\Assert::same($correct, $files->getFiles());

foreach($all as $file) {
	unlink($file);
}