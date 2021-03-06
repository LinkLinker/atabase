<?

use Atabix\Core as Atabase;


$baseDir = __DIR__.'/..';
require_once $baseDir.'/vendor/autoload.php';

// Bootstrap Atabase
try {
	$bootstrapper=new Atabase\Bootstrapper('dev', $baseDir);
	$bootstrapper->init();
} catch(PDOException $e) {
	$logger = new Monolog\Logger('dblogger');
	$logger->pushHandler(new Monolog\Handler\StreamHandler($baseDir.'/tmp/dbonnect.log', Monolog\Logger::DEBUG));
	$logger->addCritical($e->getMessage());
	
	header(Atabase\Exceptions\HTTPStatusLookup::httpHeaderFor(500));
	echo Atabase\Exceptions\HTTPStatusLookup::getMessageForCode(500).' - Database Connection Error';
	exit();
} catch(HTTPErrorException $e) {
	$e->terminate(" - Kernel Loading Failed");
}


// Route Request
$router=new Atabase\RequestRouter();
$router->routeRequest();

global $CONFIG;
var_dump($CONFIG->getAllKeys());

/*
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
*/
/*

// Create the logger
$logger = new Monolog\Logger('my_logger');
// Now add some handlers
$logger->pushHandler(new Monolog\Handler\StreamHandler(__DIR__.'/tmp/my_app.log', Monolog\Logger::DEBUG));
$logger->pushHandler(new Monolog\Handler\FirePHPHandler());

// You can now use your logger
$logger->addInfo('My logger is now ready');
$logger->addWarning('Warning. It is on!');

*/


echo nl2br("\n\nok");
