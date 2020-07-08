<?php

namespace GreenCheap\System\Controller;

use GreenCheap\Application as App;
use GreenCheap\Config\Config;

/**
 * @Access("system: access settings", admin=true)
 */
class SettingsController
{
    public function indexAction()
    {
        return [
            '$view' => [
                'title' => __('Settings'),
                'name'  => 'system:modules/settings/views/settings.php'
            ]
        ];
    }

    /**
     * @Request({"config": "array", "options": "array"}, csrf=true)
     */
    public function saveAction($values = [], $options = [])
    {
        $config = new Config;
        $config->merge(include $file = App::get('config.file'));

        foreach ($values as $module => $value) {
            $config->set($module, $value);
        }

        file_put_contents($file, $config->dump());

        foreach ($options as $module => $value) {
            $this->configAction($module, $value);
        }

        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file);
        }

        return ['message' => 'success'];
    }

    /**
     * @Request({"name", "config": "array"}, csrf=true)
     */
    public function configAction($name, $config = [])
    {
        App::config()->set($name, array_replace(App::config($name)->toArray(), $config));

        return ['message' => 'success'];
    }
}
