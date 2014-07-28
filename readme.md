#phpIO

Contains class for manipulation with files.
It is simple wrapper over internal functions, but in pretty object form.

##Examples
We suppose:
```php
$files = new \Kedrigern\phpIO\Files();
```

Cat all *.txt files and after delete them:

```php
$cat = function($file) {
	echo "Filename: $file \n";
	echo file_get_contents($file);
	echo "\n";
};

$files->dir('*.txt')->call($cat)->delete();
```

Write "Some data" to all *.txt files and after move them to the directory archive.
If files are not writable throw exception with description of problem (exact file, privileges etc.)

```php
$fill = function($file) {
	file_put_contents($file, "Some data.");
};

$files->dir('*.txt')->writeable()->call($fill)->move('archive', true);
```

Sum numbers from files (with num sufix):
```php
$parseIntFromFile = function($file) {
	return intval(file_get_contents($file));
};

$postSum = function($results) {
	return array_sum($results);
};

$files->dir('*.num')->call($parseIntFromFile, $postSum, $log);

// now $log['post'] contains sum
```

##Authors and contact
 * [Ondřej Profant](https://github.com/Kedrigern)
 * [issues](https://github.com/Kedrigern/phpIO/issues)