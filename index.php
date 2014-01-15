<?php
// move src/.htaccess to your root directory

// include the routing-system
require('src/route.php');

// infos to start the routing system
$basedir = "http://www.example.com/routing"; // this variable is required! - root directory of your website
$params = array("Language", "Page", "Subpage"); // this variable is optional! - in this example: http://www.example.com/routing/Language/Page/Subpage
$exceptions = array(); // this variable is optional! - you can create an exception, for example you navigate to http://www.example.com/routing/users; users is not a language, but a page (watch the exception below)
$exceptions[] = array(
	"param" => "Language",
	"exceptions" => array("en", "de"),
	);



// start routing an load the parameters into the $_GET array
Teddy95\EasyRouter\route::start($basedir, $params, $exceptions);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>EasyRouter - Simple php routing system by Andre Sieverding!</title>
	</head>
	<body>
		<?php
		// show params
		if (isset($_GET)) {
			foreach ($_GET as $key => $value) {
				echo "<p style='font-family: arial; font-size: 16px; line-height: 0.5;'>" . $key . ": <span style='color: red;'>" . $value . "</span></p>";
			}
		} 		else {
			echo "<p>Please open this file in an editor and study the code!</p>";
		}
		/**
		 * the script above will show something like this:
		 * 
		 * http://www.example.com/routing/en/user/Admin will generate this:
		 * Language: en
		 * Page: user
		 * Subpage: Admin
		 * 
		 * http://www.example.com/routing/user/Admin will generate this:
		 * Page: user
		 * Subpage: Admin
		 * 
		 * http://www.example.com/routing/user/Admin/settings will generate this:
		 * Page: user
		 * Subpage: Admin
		 * 2: settings
		 * 
		 * http://www.example.com/routing/user/Admin/settings/notifications will generate this:
		 * Page: user
		 * Subpage: Admin
		 * 2: settings
		 * 3: notifications
		 * 
		 * http://www.example.com/routing/user/Admin?tab=followers will generate this:
		 * Page: user
		 * Subpage: Admin
		 * tab: followers
		 * 
		 * http://www.example.com/routing/user/Admin?tab=followers&lists=20 will generate this:
		 * Page: user
		 * Subpage: Admin
		 * tab: followers
		 * lists: 20
		 */
		?>
	</body>
</html>
