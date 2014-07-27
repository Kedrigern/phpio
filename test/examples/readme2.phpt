<?php

/**
 * Readme second example
 */

require_once __DIR__ . '/../bootstrap.php';

$files = new \Kedrigern\phpIO\Files();

$fill = function($file) {
	file_put_contents($file, "Some data.");
};

$files->dir('*.txt')->writeable()->call($fill)->move('archive', true);

\Tester\Assert::same(__DIR__, $files->getDir());
\Tester\Assert::same('*.txt', $files->getFilter());
\Tester\Assert::count(0, $files->getFiles());

rmdir('archive');
