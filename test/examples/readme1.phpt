<?php

/**
 * Readme first example
 */

require_once __DIR__ . '/../bootstrap.php';

$files = new \Kedrigern\phpIO\Files();

$cat = function($file) {
	echo "Filename: $file \n";
	echo file_get_contents($file);
	echo "\n";
};

$files->dir('*.txt')->call($cat)->delete();

\Tester\Assert::same(__DIR__, $files->getDir());
\Tester\Assert::same('*.txt', $files->getFilter());
\Tester\Assert::count(0,$files->getFiles());
