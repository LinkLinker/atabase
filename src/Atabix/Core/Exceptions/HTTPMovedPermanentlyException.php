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
class HTTPMovedPermanentlyException extends HTTPException {
	
	public function __construct() {
		parent::__construct("Moved Permanently", 301);
	}
}
