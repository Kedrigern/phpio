<?php

/**
 * Move to exists dir
 */

require_once __DIR__ . '/../bootstrap.php';

Tester\Environment::lock('move.lock', __DIR__);

$correct = array("a.testf", "b.testf", "c.testf", "d.testf");
$dir = 'done';

foreach($correct as $file) {
	touch($file); // create files
}
Tester\Helpers::purge($dir);

$files = new \Kedrigern\phpIO\Files();

$files->dir('./*.testf');

\Tester\Assert::same(__DIR__, $files->getDir());
\Tester\Assert::same('*.testf', $files->getFilter());
\Tester\Assert::same($correct, $files->getFiles());

$files->move($dir);

$array = array_map(function($file) use ($dir) { return $dir.'/'. $file; }, $correct);
\Tester\Assert::same($array, glob($dir.'/*'));

foreach($array as $file) {
	unlink($file);
}

rmdir($dir);