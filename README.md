![Image](http://i.imgur.com/EIIWanz.png)

# EasyRouter

EasyRouter is a simple php routing-system.

- Beautiful URL for every page on your website
- Search Engine Optimization
- Easy to use in new and existing projects

### Installation

> Alternatively you can use our [start_route.php](https://gist.github.com/Teddy95/8387632) file!

Move .htaccess from src into the root directory of your website. After that you have to move the route.php from src into one directory of your website.

**Important:** The [`.htaccess`](https://github.com/Teddy95/EasyRouter/blob/master/src/.htaccess) file redirects to the `index.php` file, so the code should be written into the `index.php` file! - _Alternatively you can rewrite the [`.htaccess`](https://github.com/Teddy95/EasyRouter/blob/master/src/.htaccess) file!_

Now you have to start routing on your website:

```php
<?php
	include('route.php');
	Teddy95\EasyRouter\route::start();
?>
```
or:

```php
<?php
	include('route.php');
	$_GET = Teddy95\EasyRouter\route::start(null, null, null, false);
?>
```

The parameters from your URL are now in the ```$_GET``` array.

### The routing-function and their parameters

```php
$route->startRouting([ string $base_directory = null [, array $parameters = null [, array $exceptions = null [, bool $load_GET = true ]]] )
```

```$base_directory``` = URL to the root-directory of your website.

```$parameters``` = Names of parameters in the URI.

```$exceptions``` = Exceptions for parameters. If a value of a parameter not a value of an exception for this parameter, the parameter will be ignored.

```$load_GET``` = True -> Params will be loaded in the `$_GET` array.

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
	Teddy95\EasyRouter\route::start($base_directory, $parameters, $exceptions);
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

#### The option parameter

The option parameter is inside the exception parameter and transform the active $\_GET[$i] to lowercase, uppercase or something else before it will parsed.

Little example:

```php
<?php
	$basedir = "http://www.yourwebsite.com";
	$params = array("page", "subpage");
	$exceptions = array();
	$exceptions[] = array(
		"param" => "page",
		"exceptions" => array("contributions", "hellostats", "commits"),
		"options" => array(
			"strtolower" => true,
			"additionBefore" => "hello"
		)
	);
	Teddy95\EasyRouter\route::start($basedir, $params, $exceptions);
?>
```

```
http://www.yourwebsite.com/StAtS/test
will generate:
$_GET["page"] = "hellostats"
$_GET["subpage"] = "test"
```

The options are:  
strtolower (bool)  
strtoupper (bool)  
strtotime (bool)  
strtoint (bool)  
inttobinary (bool)  
addition (string)  
additionBefore (string)  
replace (array) [includes: "search" => string, "replace" => string, "ireplace" => bool]  
pregreplace (array) [includes: "pattern" => string, "replace" => string]  

```php
<?php
	$exceptions[] = array(
		"param" => "param",
		"exceptions" => array("exception1", "exception2"),
		"options" => array(
			"strtolower" => false, // default set false
			"strtoupper" => false,
			"strtotime" => false,
			"strtoint" => false,
			"inttobinary" => false,
			"addition" => null, // default set null
			"additionBefore" => null,
			"replace" => array(
				"search" => null,
				"replace" => null,
				"ireplace" => false
				),
			"pregreplace" => array(
				"pattern" => null,
				"replace" => null
				)
		)
	);
?>
```

### Fix version 0.1

Please update to version 0.2 if you have not already done so!  
You can use our [`fix_route.php`](https://gist.github.com/Teddy95/548c8c3e3c9cd4346841) file, so you needn't rewrite your code.

If you **don't want to update**, there are still interesting links:
- Version 0.1 [`src/route.php`](https://github.com/Teddy95/EasyRouter/blob/88b5b9c5baf1405af9fbc399fcf0fe02cecce325/src/route.php)
- Version 0.1 [`README.md`](https://github.com/Teddy95/EasyRouter/blob/5fa588cb935cf77f30e1743a583d551f5b86b7b7/README.md)

### License

The MIT License (MIT)

Copyright (c) 2014 EasyRouter

Permission is hereby granted, free of charge, to any person obtaining a copy  
of this software and associated documentation files (the "Software"), to deal  
in the Software without restriction, including without limitation the rights  
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell  
copies of the Software, and to permit persons to whom the Software is  
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in  
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR  
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,  
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE  
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER  
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,  
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN  
THE SOFTWARE.
