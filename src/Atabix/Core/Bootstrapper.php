<?php

namespace Atabix\Core;

class Bootstrapper {
	
	const KERNEL_DEV = 'dev';
	const KERNEL_TEST = 'test';
	const KERNEL_STAGING = 'staging';
	const KERNEL_LIVE = 'live';
	
	public $kernel;
	public $errorLevel;
	
	public function __construct($kernel) {
		// Set Kernel
		switch($kernel) {
			case static::KERNEL_DEV:
				$this->kernel=static::KERNEL_DEV;
			break;
			case static::KERNEL_TEST:
				$this->kernel=static::KERNEL_TEST;
			break;
			case static::KERNEL_STAGING:
				$this->kernel=static::KERNEL_STAGING;
			break;
			case static::KERNEL_LIVE:
				$this->kernel=static::KERNEL_LIVE;
			break;
			default:
				throw new Exceptions\HTTPErrorException();
			break;
		}
	}
	
	public function init() {
		$this->setErrorHandlers();
	}
	
	public function setErrorHandlers() {
		switch($this->kernel) {
			case static::KERNEL_DEV:
				error_reporting(E_ALL);
			break;
			
			case static::KERNEL_TEST:
				error_reporting(E_ALL);
			break;
			
			case static::KERNEL_STAGING:
				error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
				set_error_handler(array($this, "errorHandler"));
				set_exception_handler(array($this, "exceptionHandler"));
			break;
			
			case static::KERNEL_LIVE:
			default:
				error_reporting(E_NONE);
				set_error_handler(array($this, "errorHandler"));
				set_exception_handler(array($this, "exceptionHandler"));
			break;
		}
	}
	
	public function errorHandler($e) {
		echo 'oops error';
	}
	
	public function exceptionHandler($e) {
		echo 'oops exception';
	}
}