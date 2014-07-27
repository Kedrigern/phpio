<?php

/**
 * Select proper files (another dir)
 */

require_once __DIR__ . '/../bootstrap.php';

$correct = array("a.testf", "b.testf", "c.testf", "d.testf");
$false = array("e.test", "f.testfa");
$all = array_merge($correct, $false);

Tester\Environment::lock('basic.lock', __DIR__);

$dir = 'tmp-test';
mkdir($dir);

foreach($all as $file) {
	touch($dir.'/'.$file); // create files
}

$files = new \Kedrigern\phpIO\Files();

$files->dir($dir.'/*.testf');

\Tester\Assert::same(__DIR__ . '/' . $dir, $files->getDir());
\Tester\Assert::same('*.testf', $files->getFilter());
\Tester\Assert::same($correct, $files->getFiles());

foreach($all as $file) {
	unlink($dir.'/'.$file);
}

rmdir($dir);