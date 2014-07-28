<?php

/**
 * Sum numbers from files
 */

require_once __DIR__ . '/../bootstrap.php';

$files = new \Kedrigern\phpIO\Files();

for($i = 1; $i <= 10; $i++) {
	file_put_contents($i.'.num', $i);
}

$parseIntFromFile = function($file) {
	return intval(file_get_contents($file));
};

$postSum = function($results) {
	return array_sum($results);
};

$files->dir('*.num')->call($parseIntFromFile, $postSum, $log);

\Tester\Assert::count(11, $log);    // 10 files + post
\Tester\Assert::same(55, $log['post']);

for($i = 1; $i <= 10; $i++) {
	unlink($i.'.num');
}
