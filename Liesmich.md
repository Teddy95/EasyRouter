![Image](http://i.imgur.com/EIIWanz.png)

# EasyRouter

EasyRouter ist ein einfaches PHP Routing System.

- Schicke URI für jede Web- und Unterseite
- Suchmaschinenoptimiert
- Sehr einfach zu nutzen
- Schnell verbaut, in neuen, alten und aktuellen Projekten

### Installation

> Alternativ zur normalen Installation kann auch unsere [start_route.php](https://gist.github.com/Teddy95/c931ca04a7db73716042) Datei genutzt werden!

Zu Beginn muss die .htaccess Datei des Routing-Systems in das Root-Verzeichnis der Webseite kopiert/verschoben werden, in der es zum Einsatz kommen soll.

**Wichtig:** Die [`.htaccess`](https://github.com/Teddy95/EasyRouter/blob/master/src/.htaccess) Datei leitet zur `index.php` Datei, daher sollte der Code auch in der `index.php` Datei oder in einer Datei welche in die `index.php` Datei implementiert ist, ausgeführt werden! - _Alternativ kann die [`.htaccess`](https://github.com/Teddy95/EasyRouter/blob/master/src/.htaccess) Datei auch umgeschrieben werden!_

Nun starten wir das Routen:

```php
<?php
	include('EasyRouter.php');
	Teddy95\EasyRouter\route::start();
?>
```
oder:

```php
<?php
	include('EasyRouter.php');
	$_GET = Teddy95\EasyRouter\route::start(null, null, null, false);
?>
```

Die Parameter der URI sind nun in dem ```$_GET```-Array. Das wars auch schon, das Routing-System sollte nun funktionieren.  
Im folgenden Teil der Dokumentation stehen weiteren Optionen und Möglichkeiten, z.B. um den Parametern Namen zuzuweisen.

-------------

### Dokumentation

[https://github.com/Teddy95/EasyRouter/wiki](https://github.com/Teddy95/EasyRouter/wiki)

-------------

### Download

- [Veröffentlichungen auf Github](https://github.com/Teddy95/EasyRouter/releases)
- **[Letzte Version von Github runterladen](https://github.com/Teddy95/EasyRouter/archive/v0.4.1.zip)**
- [master Branch von Github runterladen](https://github.com/Teddy95/EasyRouter/archive/master.zip)

-------------

### Contributors

- [Teddy95](https://github.com/Teddy95)

-------------

### Lizenz

The MIT License (MIT) - [LICENSE.md aufrufen](https://github.com/Teddy95/EasyRouter/blob/master/LICENSE.md)
