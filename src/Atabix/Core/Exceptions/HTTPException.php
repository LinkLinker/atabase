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
class HTTPException extends \Exception {
	
	public function setReturnHeader() {
		header(HTTPStatusLookup::httpHeaderFor($this->code));
	}
	
	public function terminate($extraMessage = '') {
		$this->setReturnHeader();
		header(HTTPStatusLookup::httpHeaderFor($this->code));
		echo HTTPStatusLookup::getMessageForCode($this->code).' '.$extraMessage;
		exit();
	}
}

