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

##Authors and contact
 * [Ondřej Profant](https://github.com/Kedrigern)
 * [issues](https://github.com/Kedrigern/phpIO/issues)