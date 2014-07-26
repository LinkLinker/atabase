<?php

namespace Atabix\Core\Exceptions;

/**
 * HTTPErrorException. Used to get error code.
 *
 * @author		Atabix Solutions BV
 * @copyright	Atabix Solutions BV September 2012
 * @package		Core\Exceptions
 * @version		2.0
 */
class HTTPErrorException extends \Exception {
	
	public function __construct() {
		parent::__construct("Internal Server Error", 500);
	}
	
	public function setReturnHeader() {
		header(HTTPStatusLookup::httpHeaderFor($this->code));
	}
}

