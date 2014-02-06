<?php

class Kohana_Elastica
{
	protected static $vendor_class_root; 
	
	/**
	 * Registers autoloader method for Elastica classes
	 * @param  string $module_path
	 * @return void
	 */
	public static function register_autoloader($module_path)
	{
		//Get path to Elastica's files
		self::$vendor_class_root = $module_path.'/vendor/Elastica/lib';
		
		//Check that path exists
		if (!file_exists(self::$vendor_class_root))
			throw new Exception(sprintf("Elastica path %s not found", self::$vendor_class_root));
		
		//Register autoloader
		spl_autoload_register('Kohana_Elastica::autoload');		
	}

	/**
	 * Autoloader for Elastica classes
	 * @param  string The classname
	 * @return void
	 */
	public static function autoload($class)
	{
		//Make sure this is an elastica class
 		if (substr($class, 0, 9) == 'Elastica\\')
			require_once self::$vendor_class_root . '/' . str_replace("\\", '/', $class) . '.php';
	}
	
	
	/**
	 * Get Elastica client
	 * @param  string Config name
	 * @return object
	 */
	public static function get_client($config_name = 'default')
	{
		$configs = Kohana::$config->load('elastica');
		$config = $configs->get( $config_name );
		
		if (null === $config)
			throw new Exception(sprintf('Elastica config [%s] not found', $config_name));
		
		return new Elastica\Client($config);
	}

}
