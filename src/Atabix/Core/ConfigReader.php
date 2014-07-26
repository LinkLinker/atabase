<?

namespace Atabix\Core;

/**
 * Loads a specified config file (*.ini), and returns the settings in it in an associative array for global use. 
 *
 * @author		Atabix Solutions BV
 * @copyright	Atabix Solutions BV September 2012
 * @package		Core\Singletons
 * @version		2.0
 */
 
class ConfigReader {
	
	/**
     * Holds file data
     * 
     * @access protected
     * @var mixed The file ordened in an associative array
     */
	protected $configData;
	
	/**
     * Holds name of the file
     * 
     * @access protected
     * @var string 
     */
	protected $filename;

	/**
	 * Constructs the class and parses the .ini file using PHP's parse_ini_file()
     * 
	 * @access public
	 * @param string $filename
	 */
	public function __construct($filename) {
		$this->filename=$filename;
		$this->configData=parse_ini_file($filename, TRUE);
	}
	
	/**
	 * Gets the value of the file with given section and key
     * 
     * <code>
     * echo $CONFIG->getValue('general','application_name')
     * <code>
     * 
	 * @access public
	 * @param string $section The section in the ini file. i.e. [general]
	 * @param string $key The key of the value to return. The key must be under $section 
	 * @return string|null value if value with given parameters exists else null
	 */
	public function getValue($section, $key) {
		if(isset($this->configData[$section][$key]))
			return $this->configData[$section][$key];
		return null;
	}
	
	/**
	 * Returns the filename of the loaded config file
     * 
	 * @access public
	 * @return string the filename
	 */
	public function getFilename() {
		return $this->filename;
	}
	
	/**
	 * Returns all the keys
     * 
	 * @access public
	 * @return Array
	 */
	public function getAllKeys() {
		return $this->configData;
	}
} 

?>