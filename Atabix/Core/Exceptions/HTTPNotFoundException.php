<?php

namespace Atabix\Core\Exceptions;

/**
 * HTTPNotFoundException. Used when link is not found.
 *
 * @author		Atabix Solutions BV
 * @copyright	Atabix Solutions BV September 2012
 * @package		Core\Exceptions
 * @version		2.0
 */
class HTTPNotFoundException extends \Exception {
	
	public function __construct() {
		parent::__construct("Not Found", 404);
	}
}

