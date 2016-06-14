<?php
namespace Latrell\Smarty;

use Illuminate\View;
use Illuminate\View\Engines;
use Illuminate\View\Compilers\CompilerInterface;

class SmartyEngine implements Engines\EngineInterface
{

	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	/**
	 * Get the evaluated contents of the view.
	 *
	 * @param string $path
	 * @param array $data
	 * @return string
	 */
	public function get($path, array $data = array())
	{
		return $this->evaluatePath($path, $data);
	}

	/**
	 * Get the evaluated contents of the view at the given path.
	 *
	 * @param string $path
	 * @param array $data
	 * @return string
	 */
	protected function evaluatePath($__path, $__data)
	{
		$caching = $this->config('caching');
		$cache_lifetime = $this->config('cache_lifetime');
		$debugging = $this->config('debugging');

		$template_path = $this->config('template_path');
		$compile_path = $this->config('compile_path');
		$cache_path = $this->config('cache_path');

		$plugins_paths = (array) $this->config('plugins_paths');
		$config_paths = (array) $this->config('config_paths');

		$escape_html = $this->config('escape_html', false);
		
		$leftDelimiter = $this->config('left_delimiter', '{');
		$rightDelimiter = $this->config('right_delimiter', '}');

		// Create smarty object.
		$smarty = new \Smarty();

		$smarty->setTemplateDir($template_path);
		$smarty->setCompileDir($compile_path);
		$smarty->setCacheDir($cache_path);

		foreach ($plugins_paths as $path) {
			$smarty->addPluginsDir($path);
		}
		foreach ($config_paths as $path) {
			$smarty->setConfigDir($path);
		}

		$smarty->debugging = $debugging;
		$smarty->caching = $caching;
		$smarty->cache_lifetime = $cache_lifetime;
		$smarty->compile_check = true;

		// set the escape_html flag from the configuration value
		//
		$smarty->escape_html = $escape_html;

		$smarty->error_reporting = E_ALL & ~ E_NOTICE;
		
		$smarty->setLeftDelimiter($leftDelimiter);
		$smarty->setRightDelimiter($rightDelimiter);

		foreach ($__data as $var => $val) {
			$smarty->assign($var, $val);
		}

		return $smarty->fetch($__path);
	}

	/**
	 * Get the compiler implementation.
	 *
	 * @return Illuminate\View\Compilers\CompilerInterface
	 */
	public function getCompiler()
	{
		return $this->compiler;
	}

	/**
	 * Get package config.
	 */
	protected function config($key, $default = null)
	{
		$configKey = 'latrell-smarty.';
		return $this->config->get($configKey . $key, $default);
	}
}