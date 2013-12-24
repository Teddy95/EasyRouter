# EasyRouter

EasyRouter is simple php routing-system.

- Beautiful URL for every page on your website
- Search Engine Optimization
- Easy to use in new and existing projects

### Installation

Move .htaccess from src into the root directory of your website. After that you have to move the route.php from src into one directory of your website.

Now you have to start routing in your website:

```php
<?php
	include('route.php');
    $base_directory = "http://www.yourwebsite.com";
    $_GET = $route->startRouting($base_directory);
?>
```

The parameters from your URL are now in the ```$_GET``` array.

### The routing-function and their parameters

```php
$route->startRouting( string $base_directory [, array $parameters = null [, array $exceptions = null ]] )
```

```$base_directory``` = URL to the root-directory of your website.

```$parameters``` = Names of parameters in the URI.

```$exceptions``` = Exceptions for parameters. If a value of a parameter not a value of an exception for this parameter, the parameter will be ignored.

#### Little example with parameters and exceptions:

```php
<?php
	include('route.php');
    $base_directory = "http://www.yourwebsite.com";
    $parameters = array("language", "page");
    $exceptions = array();
    $exceptions[]= array(
    	"param" => "language",
        "exceptions" => array("en", "de")
    );
    $_GET = $route->startRouting($base_directory, $parameters, $exceptions);
?>
```
