<?php

namespace Atabix\Core\Exceptions;

/**
 * HTTPRedirectException. Used to redirect to another link.
 *
 * @author		Atabix Solutions BV
 * @copyright	Atabix Solutions BV September 2012
 * @package		Core\Exceptions
 * @version		2.0
 */
class HTTPRedirectException extends HTTPException {
	protected $redirectTo;
	
	public function __construct($redirectTo=null) {
		$this->redirectTo=$redirectTo;
		parent::__construct("Found", 302);
	}
	
	public function getRedirectTo() {
		return $this->redirectTo;
	}
}
