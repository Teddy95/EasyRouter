# EasyRouter

EasyRouter is simple php routing-system.

- Beautiful URL for every page on your website
- Search Engine Optimization
- Easy to use in new and existing projects

### Installation

Move .htaccess from src into the root directory of your website. After that you have to move the route.php from src into one directory of your website.

Now you have to start routing on your website:

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

```
http://www.yourwebsite.com/en/user will generate this:
$_GET['language'] = 'en'
$_GET['page'] = 'user'

http://www.yourwebsite.com/user/en will generate this:
$_GET['page'] = 'user'
$_GET[1] = 'en'

http://www.yourwebsite.com/en will generate this:
$_GET['language'] = 'en'

http://www.yourwebsite.com/user will generate this:
$_GET['page'] = 'user'

http://www.yourwebsite.com/de/user?tab=contributions will generate this:
$_GET['language'] = 'de'
$_GET['page'] = 'user'
$_GET['tab'] = 'contributions'
```
