<?php

namespace Atabix\Core\Exceptions;

/**
 * HTTPForbiddenException. Used when person does not have the correct requirements .
 *
 * @author		Atabix Solutions BV
 * @copyright	Atabix Solutions BV September 2012
 * @package		Core\Exceptions
 * @version		2.0
 */
class HTTPForbiddenException extends \Exception {
	
	public function __construct() {
		parent::__construct("Forbidden", 403);
	}
}

