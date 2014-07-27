<?php

/**
 * Callback after calls after files are done.
 */

require_once __DIR__ . '/../bootstrap.php';

$dataFiles = array("a.txt", "b.txt");
foreach($dataFiles as $file) {
	file_put_contents($file, $file);
}

$files = new \Kedrigern\phpIO\Files();
$call = function($file) {
	$content = file_get_contents($file);
	\Tester\Assert::same($file, $content);
	return $content;
};
$post = function($results) use ($dataFiles) {
	\Tester\Assert::same($dataFiles[0], $results[0]);
	\Tester\Assert::same($dataFiles[1], $results[1]);
};

$files->dir('*.txt')->call($call, $post);

foreach($dataFiles as $file) {
	unlink($file);
}
