<?php

namespace Atabix\Core\Exceptions;

/**
 * InternalRedirectException. Used to redirect to another link.
 *
 * @author		Atabix Solutions BV
 * @copyright	Atabix Solutions BV September 2012
 * @package		Core\Exceptions
 * @version		2.0
 */
class InternalRedirectException extends \Exception {
	protected $redirectTo;
	
	public function __construct($redirectTo=null) {
		$this->redirectTo=$redirectTo;
	}
	
	public function getRedirectTo() {
		return $this->redirectTo;
	}
}
