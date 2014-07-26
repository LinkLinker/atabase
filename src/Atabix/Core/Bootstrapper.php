<?php

namespace Atabix\Core;

class Bootstrapper {
	
	const KERNEL_DEV = 'dev';
	const KERNEL_TEST = 'test';
	const KERNEL_STAGING = 'staging';
	const KERNEL_LIVE = 'live';
	
	public $rootDir;
	public $kernel;
	public $database;
	
	public function __construct($kernel, $rootDir) {
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
		
		$this->rootDir = $rootDir;
		$this->database = true;
	}
	
	public function init() {
		$this->setErrorHandlers();
		$this->checkFilesAndFolders();
		$this->setDatabaseConnector();
		$this->loadConfigFile();
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
	
	public function checkFilesAndFolders() {
		// Check if exists, if not create: /conf
		$configDir = $this->rootDir.'/conf';
		if(!is_dir($configDir)) {
			mkdir($configDir);
		}
		
		// Check if exists, if not create: .htaccess
		$htaccess = $this->rootDir.'/.htaccess';
		if(!file_exists($htaccess)) {
			$htaFile ='';
			$htaFile.="\n".'#AuthType Basic';
			$htaFile.="\n".'#AuthName "Secured Environment"';
			$htaFile.="\n".'#AuthUserFile '.$this->rootDir.'/.htpasswd';
			$htaFile.="\n".'#Require valid-user';
			$htaFile.="\n".'';
			$htaFile.="\n".'RewriteEngine On';
			$htaFile.="\n".'RewriteRule ^cnf /';
			$htaFile.="\n".'RewriteRule ^src /';
			$htaFile.="\n".'RewriteRule ^vendor /';
			$htaFile.="\n".'';
			$htaFile.="\n".'RewriteCond %{REQUEST_FILENAME} -s [OR]';
			$htaFile.="\n".'RewriteCond %{REQUEST_FILENAME} -l [OR]';
			$htaFile.="\n".'RewriteCond %{REQUEST_FILENAME} -d';
			$htaFile.="\n".'RewriteRule ^.*$ - [NC,L]';
			$htaFile.="\n".'RewriteRule ^.*$ /index.php [NC,L]';
			$htaFile.="\n".'';
			$htaFile.="\n".'';
			file_put_contents($htaccess, $htaFile);
		}

		// Check if exists, if not create: /tmp
		$tmpDir = $this->rootDir.'/tmp';
		if(!is_dir($tmpDir)) {
			mkdir($tmpDir);
		}
	}
	
	public function setDatabaseConnector() {
		if($this->database === false) return;
		
		// Check if exists, if not create: database.ini
		$configFile = $this->rootDir.'/conf/database.ini';
		if(!file_exists($configFile)) {
			$dbini ='[database]';
			$dbini.="\n".'engine = "mysql"';
			$dbini.="\n".'hostname = "localhost:3306"';
			$dbini.="\n".'database = ""';
			$dbini.="\n".'username = ""';
			$dbini.="\n".'password = ""';
			$dbini.="\n".'charset = "utf8"';
			$dbini.="\n";
			file_put_contents($configFile, $dbini);
		} 
		
		// Set Database Connector
		$dbconfig=new ConfigReader($configFile);
		
		$engine   = $dbconfig->getValue('database','engine');
		$hostname = $dbconfig->getValue('database','hostname');
		$database = $dbconfig->getValue('database','database');
		$username = $dbconfig->getValue('database','username');
		$password = $dbconfig->getValue('database','password');
		$charset  = $dbconfig->getValue('database','charset');
		
		$dsn = $engine.':host='.$hostname.';dbname='.$database.';charset='.$charset;
		$GLOBALS['DB'] = new \PDO($dsn, $username, $password);		
	}
	
	public function loadConfigFile() {
		// Check if exists, if not create: config.ini
		$configFile = $this->rootDir.'/conf/config.ini';
		if(!file_exists($configFile)) {
			
			$dbini ='[atabase]';
			$dbini.="\n".'created = "'.date("d-m-Y H:i:s").'"';
			
/*			HIER DATABASE CHECKEN VOOR CONFIG FILE
			Config::checkDatabase();
			$configs=Config::loadAll();
			if(count($configs)>0) {
			}
*/
			file_put_contents($configFile, $dbini);				
		}
		
		// Load $CONFIG Singleton from conf/config.ini
		$GLOBALS['CONFIG']=new ConfigReader($configFile);
	}
}