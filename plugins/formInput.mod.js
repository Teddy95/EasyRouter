/**
 * author:	Andre Sieverding https://github.com/Teddy95
 * license:	MIT http://opensource.org/licenses/MIT
 * 
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 Andre Sieverding
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

// ##########	This is a JavaScript plugin for EasyRouter!		##########
// ##########	This plugin requires jQuery!					##########

/**
 * Plugin description:
 *
 * This plugin modifies the HTML <form /> element. It's useful for search inputs.
 * http://example.com/search/INPUT/INPUT2 instead of http://example.com/search?inputName=INPUT&inputName2=INPUT
 */

/**
 * Usage:
 *
 * <form id="mySearchForm">
 * 	<input type="search" data-order="1" /><!-- Type can be search, text, password, email, etc. --><!-- The data-order attribute is for the sorting in the uri. The attribute is optional. -->
 * 	<input type="submit" value="Submit" />
 * </form>
 *
 * <script type="text/javascript" language="javascript">
 * 	$("#mySearchForm").EasyRouterMod_formInput({
 * 		transferSubmitValue: false, // It's optional
 * 	});
 * </script>
 */

// jQuery function -> $("#formId").EasyRouterMod_formInput();
$.fn.EasyRouterMod_formInput = function () {
	// Remove the event handler
	$(this).children(":submit").off();

	// Click event for the submit button(s) in the selected form (this)
	$(this).children(":submit").click(function () {
		// This is so far only a test file!

		// Return false, because the form is sent by this plugin!
		return false;
	});
}