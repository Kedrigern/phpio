<?php

/**
 * Log with all callback results
 */

require_once __DIR__ . '/../bootstrap.php';

$dataFiles = array("a.txt", "b.txt");
foreach($dataFiles as $file) {
	touch($file);
}

$files = new \Kedrigern\phpIO\Files();
$call = function($file) {
	return $file;
};
$post = function($results) {
	return 'post';
};

$files->dir('*.txt')->call($call, $post, $log);

\Tester\Assert::same(
	array(0=>"a.txt", 1=>"b.txt", 'post'=>'post'),
	$log
);

foreach($dataFiles as $file) {
	unlink($file);
}
