<?php

require_once __DIR__ . '/../bootstrap.php';

$correct = array("a.testf", "b.testf", "c.testf", "d.testf");

Tester\Environment::lock('delete.lock', __DIR__);

foreach($correct as $file) {
	touch($file); // create files
}

$files = new \Kedrigern\phpIO\Files();

$files->dir('./*.testf');

\Tester\Assert::same(__DIR__, $files->getDir());
\Tester\Assert::same('*.testf', $files->getFilter());
\Tester\Assert::same($correct, $files->getFiles());

$files->delete();

\Tester\Assert::same(array(), glob('*.testf'));
