<?php

/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/24/2018
 * Time: 10:14 PM
 */

namespace App\Singleton;

use App\Models\Setting;

class SettingSingleton
{
    private static $instance = null;
    protected $setting = null;

    public function __construct($isSessionInstance = true)
    {
        $settings = Setting::all()->keyBy('key');
        $this->settings = $settings;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new SettingSingleton();
        }
        return self::$instance;
    }

    /**
     * @param null $name
     * @return null
     */
    public function getSetting($name = null)
    {
        if ($name === null) {
            return $this->settings;
        }
        if (property_exists($this->settings, $name)) {
            return $this->settings->$name;
        }
        return null;
    }
}