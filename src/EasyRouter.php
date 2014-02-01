<?php
/**
 * @author	Andre Sieverding https://github.com/Teddy95
 * @license	MIT http://opensource.org/licenses/MIT
 * 
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 EasyRouter
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Teddy95\EasyRouter;

/**
 * Routing class
 */
class route
{

	/**
	 * Information about EasyRouter and its developer.
	 */
	public static $author = "Andre Sieverding";
	public static $license = "MIT http://opensource.org/licenses/MIT";
	public static $version = "0.2";
	public static $website = "http://www.andre-sieverding.de";
	public static $github = "https://github.com/Teddy95";
	public static $src = "https://github.com/Teddy95/EasyRouter";

	/**
	 * Parameters for functions.
	 */
	private static $paramsCount = 0;
	private static $prepareCount = 0;
	private static $routed = false;
	private static $prepareString = false;

	/**
	 * @param string	$basedir
	 * @param array		$params
	 * @param array		$exceptions
	 * @param bool		$load_GET
	 *
	 * @return array	Returns an array with the uri-params on success or FALSE on failure
	 */
	public static function start ($basedir = null, $params = null, $exceptions = null, $load_GET = true)
	{

		/**
		 * Current path.
		 */
		if (is_null($basedir)) {
			if (!isset($_SERVER['HTTPS'])) {
				$uri = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} else {
				$uri = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			}
		} else {
			if (substr($basedir, 0, 7) == "http://") {
				$uri = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} elseif (substr($basedir, 0, 8) == "https://") {
				$uri = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} else {
				return false;
			}
		}
		
		/**
		 * Generate basedir.
		 */
		if (is_null($basedir)) {
			if (!isset($_SERVER['HTTPS'])) {
				$scheme = 'http://';
			} else {
				$scheme = 'https://';
			}
			$basedir = $scheme . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
			$basedir = str_replace('/' . basename($scheme . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']), '', $basedir);
		}
		
		/**
		 * Delete last slash from the root directory.
		 */
		if (substr($basedir, -1, 1) == "/") {
			$basedir = substr($basedir, 0, strlen($basedir) - 1);
		}
		
		/**
		 * Is there a slash at the end of the path? (only if there are no parameters!)
		 */
		$slash = "";
		if ($uri == $basedir) {
			$slash = "/";
		} elseif ($uri == $basedir . "/") {
			$slash = "";
		} elseif (substr($uri, -1, 1) == "/") {
			$uri = substr($uri, 0, strlen($uri) - 1);
		}
		
		/**
		 * Filter out the index file and the base directory.
		 */
		$uri = str_replace($basedir . "/", "", $uri . $slash);

		if (is_null($params) === TRUE) {

			$paramsCount = 0;
			
			/**
			 * Load the individual parameters in the $_GET array.
			 */
			$__GET = explode("/", urldecode($uri));
			$getCount = count($__GET) - 1;

			if (strpos($__GET[$getCount], '?') == true) { # a question mark must be present in the parameter
				if (substr($__GET[$getCount], -1, 1) == '?') { # is the last character a question mark?
					$__GET[$getCount] = substr($__GET[$getCount], 0, strlen($__GET[$getCount]) - 1);
					$glue = "?";
					$glueGetParam = false;
				} else {
					$glue = "";
					$glueGetParam = false;
				}
				if (strpos($__GET[$getCount], '?') == true) {
					$glueGetParam = true;
					$elements = explode('?', $__GET[$getCount], 2);
					$__GET[$getCount] = $elements[0];
					$elements[1] .= $glue;
					$getParams = explode('&', $elements[1]);
					$trueGetParams = array();
					foreach ($getParams as $getParam) {
						if (strpos($getParam, '=') == true) {
							$paramArray = explode('=', $getParam, 2);
							$trueGetParams[$paramArray[0]] = $paramArray[1];
						}
					}
				}
				$__GET[$getCount] .= $glueGetParam == false ? $glue : '';
			}

			if (isset($trueGetParams) && count($trueGetParams) > 0) {
				foreach ($trueGetParams as $key => $value) {
					$__GET[$key] = $value;
				}
			}

		} else {

			$paramsCount = count($params);
			
			/**
			 * Load the individual parameters in the $route array.
			 */
			$route = explode("/", urldecode($uri));
			
			/**
			 * Count $route.
			 */
			$j = count($route);
			$k = 0;
			$l = 0;
			
			/**
			 * While $i is smaller than $j, load parameters in the $_GET array.
			 */
			for ($i = 0; $i < $j; $i++) {
				
				/**
				 * Load the individual parameters in the $route array.
				 */
				if ($i == $j - 1) {
					if (strpos($route[$i], '?') == true) { # a question mark must be present in the parameter
						if (substr($route[$i], -1, 1) == '?') { # is the last character a question mark?
							$route[$i] = substr($route[$i], 0, strlen($route[$i]) - 1);
							$glue = "?";
							$glueGetParam = false;
						} else {
							$glue = "";
							$glueGetParam = false;
						}
						if (strpos($route[$i], '?') == true) {
							$glueGetParam = true;
							$elements = explode('?', $route[$i], 2);
							$route[$i] = $elements[0];
							$elements[1] .= $glue;
							$getParams = explode('&', $elements[1]);
							$trueGetParams = array();
							foreach ($getParams as $getParam) {
								if (strpos($getParam, '=') == true) {
									$paramArray = explode('=', $getParam, 2);
									$trueGetParams[$paramArray[0]] = $paramArray[1]; # watch paramEnd!
								}
							}
						}
						$route[$i] .= $glueGetParam == false ? $glue : '';
					}
				}
				
				/**
				 * If the current parameter is the exception parameter, then the parameter must be treated specially.
				 */
				if (!is_null($exceptions)) {
					foreach ($exceptions as $exception) {
						$route_i = $route[$i];
						
						/**
						 * Check options.
						 */
						if (!is_null($exception["options"])) {
							if (isset($exception["options"]["strtolower"]) && $exception["options"]["strtolower"] == TRUE) {
								$route_i = strtolower($route_i);
							}
							if (isset($exception["options"]["strtoupper"]) && $exception["options"]["strtoupper"] == TRUE) {
								$route_i = strtoupper($route_i);
							}
							if (isset($exception["options"]["strtotime"]) && $exception["options"]["strtotime"] == TRUE) {
								$route_i = strtotime($route_i);
							}
							if (isset($exception["options"]["strtoint"]) && $exception["options"]["strtoint"] == TRUE) {
								$route_i = intval($route_i);
							}
							if (isset($exception["options"]["inttobinary"]) && $exception["options"]["inttobinary"] == TRUE) {
								$route_i = decbin($route_i);
							}
							if (isset($exception["options"]["addition"])) {
								$route_i = $route_i . $exception["options"]["addition"];
							}
							if (isset($exception["options"]["additionBevor"])) {
								$route_i = $exception["options"]["additionBefore"] . $route_i;
							}
							if (isset($exception["options"]["replace"])) {
								if (isset($exception["options"]["replace"]["ireplace"]) && $exception["options"]["replace"]["ireplace"] == TRUE) {
									$route_i = str_ireplace($exception["options"]["replace"]["search"], $exception["options"]["replace"]["replace"], $route_i);
								} else {
									$route_i = str_replace($exception["options"]["replace"]["search"], $exception["options"]["replace"]["replace"], $route_i);
								}
							}
							if (isset($exception["options"]["pregreplace"])) {
								if (isset($exception["options"]["pregreplace"]["pattern"]) || isset($exception["options"]["pregreplace"]["replace"])) {
									if (!isset($exception["options"]["pregreplace"]["pattern"])) {
										$exception["options"]["pregreplace"]["pattern"] = "/.*/";
									}
									if (!isset($exception["options"]["pregreplace"]["replace"])) {
										$exception["options"]["pregreplace"]["replace"] = "";
									}
									$route_i = preg_replace($exception["options"]["pregreplace"]["pattern"], $exception["options"]["pregreplace"]["replace"], $route_i);
								}
							}
						}
						
						/**
						 * Load params.
						 */
						if (isset($params[$i + $k]) && $params[$i + $k] == $exception["param"]) {
							foreach ($exception["exceptions"] as $excep) {
								if ($excep == $route_i) {
									$l++;
								}
							}
							if ($l > 0) {
								$__GET[$params[$i + $k]] = $route_i;
								$l = 0;
								goto paramEnd;
							} else {
								$k++;
								$paramsCount--;
							}
						}
					}
				}
				
				/**
				 * If there are more values ​​as parameters or empty parameters, natural numbers must be followed.
				 */
				if (!isset($params[$i + $k])) {
					$params[$i + $k] = $i;
				}
				
				/**
				 * The parameter should be ignored, if the value of it is null.
				 */
				if (is_null($route[$i]) || empty($route[$i]) || !isset($route[$i])) {
					#
				} else {
					$__GET[$params[$i + $k]] = $route[$i];
				}

				paramEnd:

				if (isset($trueGetParams) && count($trueGetParams) > 0) {
					foreach ($trueGetParams as $key => $value) {
						$__GET[$key] = $value;
					}
				}
			}
		}

		self::$paramsCount = $paramsCount;
		self::$routed = true;

		if ($load_GET === TRUE) {
			$GLOBALS['_GET'] = $__GET;
			
			return;
		} else {
			/**
			 * Return array.
			 */
			return $__GET;
		}
		
	}

	/**
	 * @param string	$basedir
	 * @param bool		$load_GET
	 *
	 * @return array	Returns an array with the uri-params on success or FALSE on failure
	 */
	public static function execute ($basedir = null, $load_GET = true)
	{

		if (self::$prepareString == FALSE) {
			return false;
		}

		/**
		 * Current path.
		 */
		if (is_null($basedir)) {
			if (!isset($_SERVER['HTTPS'])) {
				$uri = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} else {
				$uri = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			}
		} else {
			if (substr($basedir, 0, 7) == "http://") {
				$uri = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} elseif (substr($basedir, 0, 8) == "https://") {
				$uri = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			} else {
				return false;
			}
		}
		
		/**
		 * Generate basedir.
		 */
		if (is_null($basedir)) {
			if (!isset($_SERVER['HTTPS'])) {
				$scheme = 'http://';
			} else {
				$scheme = 'https://';
			}
			$basedir = $scheme . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
			$basedir = str_replace('/' . basename($scheme . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']), '', $basedir);
		}
		
		/**
		 * Delete last slash from the root directory.
		 */
		if (substr($basedir, -1, 1) == "/") {
			$basedir = substr($basedir, 0, strlen($basedir) - 1);
		}
		
		/**
		 * Is there a slash at the end of the path? (only if there are no parameters!)
		 */
		$slash = "";
		if ($uri == $basedir) {
			$slash = "/";
		} elseif ($uri == $basedir . "/") {
			$slash = "";
		} elseif (substr($uri, -1, 1) == "/") {
			$uri = substr($uri, 0, strlen($uri) - 1);
		}
		
		/**
		 * Filter out the index file and the base directory.
		 */
		$uri = str_replace($basedir . "/", "", $uri . $slash);

		$paramsCount = 0;
			
		/**
		 * Parse prepare string and load the individual parameters in the $_GET array.
		 */
		$prepareString = self::$prepareString;
		$parts = explode('/', $prepareString);
		$partsCount = count($parts);
		$prepareParams = array();
		$uriParams = array();
		$uriParts = explode('/', $uri);

		for ($i = 0; $partsCount > $i; $i++) {
			if (strpos($parts[$i], '-') == TRUE) {
				$prepareParams = explode('-', $parts[$i]);
				$uriParams = explode('-', $uriParts[$i], count($prepareParams));
				
				for ($j = 0; count($prepareParams) > $j; $j++) {
					if (isset($uriParams[$j]) && !is_null($uriParams[$j]) && !empty($uriParams[$j])) {
						$__GET[substr($prepareParams[$j], 1, strlen($prepareParams[$j]) - 2)] = $uriParams[$j];
						$latestKey = substr($prepareParams[$j], 1, strlen($prepareParams[$j]) - 2);
						if ($j > 0) {
							self::$prepareCount++;
						}
					}
				}

				$prepareParams = $parts[$i];
				$uriParams = $uriParts[$i];

				if (isset($uriParams) && !is_null($uriParams) && !empty($uriParams)) {
					$paramsCount++;
				}
			} else {
				$prepareParams = $parts[$i];
				$uriParams = $uriParts[$i];

				if (isset($uriParams) && !is_null($uriParams) && !empty($uriParams)) {
					$__GET[substr($prepareParams, 1, strlen($prepareParams) - 2)] = $uriParams;
					$latestKey = substr($prepareParams, 1, strlen($prepareParams) - 2);
					$paramsCount++;
				}
			}
		}

		if (count($uriParts) - 1 >= $i) {
			$remains = count($uriParts) - 1 - $i;
			for ($j = 0; $remains >= $j; $j++) {
				$__GET[$j + $i + 1] = $uriParts[$j + $i];
			}
		}

		if (strpos($__GET[$latestKey], '?') == true) { # a question mark must be present in the parameter
			if (substr($__GET[$latestKey], -1, 1) == '?') { # is the last character a question mark?
				$__GET[$latestKey] = substr($__GET[$latestKey], 0, strlen($__GET[$latestKey]) - 1);
				$glue = "?";
				$glueGetParam = false;
			} else {
				$glue = "";
				$glueGetParam = false;
			}
			if (strpos($__GET[$latestKey], '?') == true) {
				$glueGetParam = true;
				$elements = explode('?', $__GET[$latestKey], 2);
				$__GET[$latestKey] = $elements[0];
				$elements[1] .= $glue;
				$getParams = explode('&', $elements[1]);
				$trueGetParams = array();
				foreach ($getParams as $getParam) {
					if (strpos($getParam, '=') == true) {
						$paramArray = explode('=', $getParam, 2);
						$trueGetParams[$paramArray[0]] = $paramArray[1];
					}
				}
			}
			$__GET[$latestKey] .= $glueGetParam == false ? $glue : '';
		}

		if (isset($trueGetParams) && count($trueGetParams) > 0) {
			foreach ($trueGetParams as $key => $value) {
				$__GET[$key] = $value;
			}
		}

		self::$paramsCount = $paramsCount;
		self::$routed = true;

		if ($load_GET === TRUE) {
			$GLOBALS['_GET'] = $__GET;
			
			return;
		} else {
			/**
			 * Return array.
			 */
			return $__GET;
		}
		
	}
	
	/**
	 * @param string	$prepareString
	 *
	 * @return bool		Returns FALSE on failure
	 */
	public static function prepare ($prepareString)
	{

		if (!isset($prepareString)) {
			return false;
		}

		if (substr($prepareString, -1, 1) == '/') {
			$prepareString = substr($prepareString, 0, strlen($prepareString)-1);
		}

		if (substr($prepareString, 0, 1) == '/') {
			$prepareString = substr($prepareString, 1, strlen($prepareString)-1);
		}

		$prepareString = str_replace('}-{', '}#{', $prepareString);
		$prepareString = str_replace(array(' ', '-'), array('_', '_'), $prepareString);
		$prepareString = str_replace('}#{', '}-{', $prepareString);
		self::$prepareString = $prepareString;

	}
	
	/**
	 * @return array	Returns an array with normal GET params
	 */
	public static function get_true_params ()
	{

		$trueGetParams = array();

		if (isset($_SERVER['QUERY_STRING'])) {
			if (!empty($_SERVER['QUERY_STRING'])) {
				$params = explode('&', $_SERVER['QUERY_STRING']);
				foreach ($params as $param) {
					$paramArray = explode('=', $param, 2);
					$trueGetParams[$paramArray[0]] = $paramArray[1];
				}
			} else {
				return false;
			}
		} else {
			return false;
		}

		return $trueGetParams;

	}
	
	/**
	 * @param string	$href
	 * @param int		$params
	 *
	 * @return bool		Returns FALSE on failure
	 */
	public static function error ($href, $params = null)
	{

		if (isset(self::$routed) && self::$routed == TRUE) {
			if (!isset($params) || is_null($params)) {
				if (!self::get_true_params()) {
					$trueGetParams = 0;
				} else {
					$trueGetParams = count(self::get_true_params());
				}

				$paramsCount = self::$paramsCount + $trueGetParams;

				if (count($_GET) - self::$prepareCount > $paramsCount) {
					header('Location: ' . $href);
					exit();
				}
			} else {
				if (!self::get_true_params()) {
					$trueGetParams = 0;
				} else {
					$trueGetParams = count(self::get_true_params());
				}

				$paramsCount = $params + $trueGetParams;

				if (count($_GET) - self::$prepareCount > $paramsCount) {
					header('Location: ' . $href);
					exit();
				}
			}
		} else {
			return false;
		}

	}
	
	/**
	 * @return array	Returns an array with information about EasyRouter
	 */
	public static function info ()
	{

		$informations = array(
			"author" => self::$author,
			"license" => self::$license,
			"version" => self::$version,
			"website" => self::$website,
			"github" => self::$github,
			"src" => self::$src
			);

		return $informations;

	}
	
}
?>