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
        $configKey = 'smarty::';

        $caching = $this->config[$configKey . 'caching'];
        $cache_lifetime = $this->config[$configKey . 'cache_lifetime'];
        $debugging = $this->config[$configKey . 'debugging'];

        $template_path = $this->config[$configKey . 'template_path'];
        $compile_path = $this->config[$configKey . 'compile_path'];
        $cache_path = $this->config[$configKey . 'cache_path'];

        // Get the plugins path from the configuration
        $plugins_paths = $this->config[$configKey . 'plugins_paths'];

        // Create smarty object.
        $smarty = new \Smarty();

        $smarty->setTemplateDir($template_path);
        $smarty->setCompileDir($compile_path);
        $smarty->setCacheDir($cache_path);

        // Add the plugin folder from the config to the Smarty object.
        // Note that I am using addPluginsDir here rather than setPluginsDir
        // because I want to add a secondary folder, not replace the
        // existing folder.
        foreach ($plugins_paths as $path) {
            $smarty->addPluginsDir($path);
        }

        $smarty->debugging = $debugging;
        $smarty->caching = $caching;
        $smarty->cache_lifetime = $cache_lifetime;
        $smarty->compile_check = true;

        // $smarty->escape_html = true;
        $smarty->error_reporting = E_ALL & ~ E_NOTICE;

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
}