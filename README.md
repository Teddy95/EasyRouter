# EasyRouter

<p align="center">
	<img src="http://root.andre-sieverding.de/briefkasten/GithubRepoLogos/EasyRouter.png" alt="">
	<p align="center">EasyRouter is a simple php routing-system.</p>
</p>

-------------

![](http://i.imgur.com/EIIWanz.png)

### Benefits

- Beautiful URL for every page on your website
- Search Engine Optimization
- Easy to use in new and existing projects

-------------

### Installation

Move .htaccess from src into the root directory of your website. After that you have to move the EasyRouter.php from src into one directory of your website.

**Important:** The [`.htaccess`](https://github.com/Teddy95/EasyRouter/blob/master/src/.htaccess) file redirects to the `index.php` file, so the code should be written into the `index.php` file! - _Alternatively you can rewrite the [`.htaccess`](https://github.com/Teddy95/EasyRouter/blob/master/src/.htaccess) file!_

Now you have to start routing on your website:

```php
<?php
	include('EasyRouter.php');
	EasyRouter\main::start();
?>
```
or:

```php
<?php
	include('EasyRouter.php');
	$_GET = EasyRouter\main::start(null, null, null, false);
?>
```

The parameters from your URL are now in the ```$_GET``` array.

-------------

### Documentaion

[https://github.com/Teddy95/EasyRouter/wiki](https://github.com/Teddy95/EasyRouter/wiki)

-------------

### Download

- [Releases on Github](https://github.com/Teddy95/EasyRouter/releases)
- **[Download latest version from Github](https://github.com/Teddy95/EasyRouter/archive/0.7.2.zip)**
- [Download master from Github](https://github.com/Teddy95/EasyRouter/archive/master.zip)

-------------

### Contributors

- [Teddy95](https://github.com/Teddy95)

-------------

### License

The MIT License (MIT) - [View LICENSE.md](https://github.com/Teddy95/EasyRouter/blob/master/LICENSE.md)
