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

class route {
	public function startRouting ($basedir = "", $params = null, $exceptions = null) {

		// current path
		$uri = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

		// delete last slash from the root directory
		if (substr($basedir, -1, 1) == "/") {
			$basedir = substr($basedir, 0, strlen($basedir) - 1);
		}

		// is there a slash at the end of the path? (only if there are no parameters!)
		$slash = "";
		if ($uri == $basedir) {
			$slash = "/";
		} elseif ($uri == $basedir . "/") {
			$slash = "";
		} elseif (substr($uri, -1, 1) == "/") {
			$uri = substr($uri, 0, strlen($uri) - 1);
		}

		// filter out the index file and the base directory
		$uri = str_replace($basedir . "/", "", $uri . $slash);

		if (is_null($params) === TRUE) {

			// load the individual parameters in the $_GET array
			$__GET = explode("/", urldecode($uri));

		} else {

			// load the individual parameters in the $route array
			$route = explode("/", urldecode($uri));

			// count $route
			$j = count($route);
			$k = 0;
			$l = 0;

			// while $i is smaller than $j, load parameters in the $_GET array
			for ($i = 0; $i < $j; $i++) {
				// checking whether the last parameter includes standard $_GET variables
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

				// if the current parameter is the exception parameter, then the parameter must be treated specially
				if (!is_null($exceptions)) {
					foreach ($exceptions as $exception) {
						$route_i = $route[$i];

						// check options
						if (!is_null($exception["options"])) {
							if ($exception["options"]["strtolower"] == TRUE) {
								$route_i = strtolower($route_i);
							}
							if ($exception["options"]["strtoupper"] == TRUE) {
								$route_i = strtoupper($route_i);
							}
							if ($exception["options"]["strtotime"] == TRUE) {
								$route_i = strtotime($route_i);
							}
							if ($exception["options"]["strtoint"] == TRUE) {
								$route_i = intval($route_i);
							}
							if ($exception["options"]["inttobinary"] == TRUE) {
								$route_i = decbin($route_i);
							}
							if ($exception["options"]["addition"]) {
								$route_i = $route_i . $exception["options"]["addition"];
							}
							if ($exception["options"]["additionBevor"]) {
								$route_i = $exception["options"]["additionBefore"] . $route_i;
							}
							if ($exception["options"]["replace"]) {
								if ($exception["options"]["replace"]["ireplace"] == TRUE) {
									$route_i = str_ireplace($exception["options"]["replace"]["search"], $exception["options"]["replace"]["replace"], $route_i);
								} else {
									$route_i = str_replace($exception["options"]["replace"]["search"], $exception["options"]["replace"]["replace"], $route_i);
								}
							}
							if ($exception["options"]["pregreplace"]) {
								$route_i = preg_replace($exception["options"]["pregreplace"]["pattern"], $exception["options"]["pregreplace"]["replace"], $route_i);
							}
						}

						// load params
						if ($params[$i + $k] == $exception["param"]) {
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
							}
						}
					}
				}

				// if there are more values ​​as parameters or empty parameters, natural numbers must be followed
				if (is_null($params[$i + $k]) === TRUE) {
					$params[$i + $k] = $i;
				}

				// the parameter should be ignored, if the value of it is null
				if (is_null($route[$i]) || empty($route[$i]) || !isset($route[$i])) {
					#
				} else {
					$__GET[$params[$i + $k]] = $route[$i];
				}

				paramEnd:

				if (count($trueGetParams) > 0) {
					foreach ($trueGetParams as $key => $value) {
						$__GET[$key] = $value;
					}
				}
			}
		}

		// return the array
		return $__GET;
	}
}

$route = new route;
?>
