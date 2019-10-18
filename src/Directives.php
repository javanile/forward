<?php
/**
 * Short description for class
 *
 * @package   Javanile\Forward
 * @author    Francesco Bianco <bianco@javanile.org>
 * @copyright 2019 Javanile
 * @license   https://github.com/javanile/forward/blob/master/LICENSE  MIT License
 * @version   Release: 0.0.1
 * @link      https://github.com/javanile/forward
 */

namespace Javanile\Forward;

class Directives
{
    /**
     * @var array
     */
    protected static $directives = [
        'file'   => 'Javanile\\Forward\\Directives\\File',
        'emacs'  => 'Javanile\\Forward\\Directives\\Emacs',
        'report' => 'Javanile\\Forward\\Directives\\Report',
    ];

    /**
     * @return array
     */
    public static function parse($files, $post)
    {
        $directives = [];

        foreach ($post as $name => $data) {
            $type = self::getTypeByName($name);
            $directives[$name] = [
                'name' => $name,
                'type' => $type,
                'data' => $data,
            ];
        }

        foreach ($files as $name => $file) {
            $type = self::getTypeByName($name);
            $directives[$name] = [
                'name' => $name,
                'type' => $type,
                'file' => $file,
            ];
        }

        return $directives;
    }

    /**
     * @param $directive
     */
    public static function check($directive)
    {
        if (empty($directive) || empty($directive['type']) || empty(self::$directives[$directive['type']])) {
            return false;
        }

        return class_exists(self::$directives[$directive['type']]);
    }

    /**
     * @param $directive
     */
    public static function process($directive, $directives)
    {
        $directiveClass = self::$directives[$directive['type']];
        $directiveObject = new $directiveClass();

        echo call_user_func_array([$directiveObject, 'process'], func_get_args());
    }

    /**
     *
     */
    public static function getTypeByName($name)
    {
        return $name;
    }

    /**
     *
     */
    public static function getFileSchema($file)
    {
        return [
            'name' => basename($file),
            'type' => 'text/plain',
            'tmp_name' => $file,
            'error' => 0,
            'size' => filesize($file),
        ]
    }
}