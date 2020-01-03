# Grouping - PHP library for generating grouped statistical series

The library allows you to create grouped out of simple statistical series, subject to the use of large amounts of data.

Setup
-----

Add the library to your `composer.json` file in your project:

```javascript
{
  "require": {
      "soandso/grouping": "0.*"
  }
}
```

Use [composer](http://getcomposer.org) to install the library:

```bash
$ php composer.phar install
```

Composer will install Grouping inside your vendor folder. Then you can add the following to your
.php files to use the library with Autoloading.

```php
require_once(__DIR__ . '/vendor/autoload.php');
```

You can also use composer on the command line to require and install Grouping:

```bash
$ php composer.phar require soandso/grouping:0.*
```

## Minimum Requirements
 * PHP 7

## Description

To get started, you need to create an object of the core class of the library Grouping:

```php
$object = new Grouping();
```

Next, you need to add the source data for the calculation:

```php
$object->putSource($source_data);
```

$source_data is the source data presented in the view of a simply non-associative array.

The peculiarity of the library is that you can pull out the method of adding source data many times.

```php
$object->putSource($source_data1);
$object->putSource($source_data2);
$object->putSource($source_data3);

........
```

This may be important when dealing with large amounts of data. For example, you can upload a large file in parts
Example,

```php
function readFile($path) {
    $handle = fopen($path, "r");

    while(!feof($handle)) {
        yield $object->putSource(sourceToarray(trim(fgets($handle))));
    }

    fclose($handle);
}

```

After this construction of the grouped statistical series, you need to call the method buildGss:

```php
$result = $object->buildGss($output, $path_file);
```

$output - parameter defining the format of the returned result. The parameter is required and can take such values ​​as 'array', 'json' and 'file'.
$path_file - parameter, defines the system path to the directory where the result file will be written. The parameter is optional. Must end with a slash '/'. Example:

```bash
/var/www/domain/folder/
```

As a result of constructing a guided statistical series, the library presents the following data: the number of partial intervals, the values ​​at the boundaries of the partial intervals, interval frequencies, random values ​​at the midpoints of partial intervals, interval frequencies.
For example, the output in array format will look like:

```
[1]=>
  array(5) {
    ["left_border"]=>
    float(-9.4)
    ["right_border"]=>
    float(-7.85)
    ["middle_partial_interval"]=>
    float(-8.625)
    ["interval_frequency"]=>
    int(4)
    ["relative_frequency"]=>
    float(0.11428571428571)
  }
  [2]=>
  array(5) {
    ["left_border"]=>
    float(-7.85)
    ["right_border"]=>
    float(-6.3)
    ["middle_partial_interval"]=>
    float(-7.075)
    ["interval_frequency"]=>
    int(2)
    ["relative_frequency"]=>
    float(0.057142857142857)
  }
  [3]=>.....................
```

Standards
---------

Grouping conforms to the following standards:

 * PSR-1  - Basic coding standard (http://www.php-fig.org/psr/psr-1/)
 * PSR-4  - Autoloader (http://www.php-fig.org/psr/psr-4/)
 * PSR-12 - Extended coding style guide (http://www.php-fig.org/psr/psr-12/)

License
-------

Grouping is licensed under the GPLv2 (https://www.gnu.org/licenses/old-licenses/gpl-2.0.html) License.
