<?php
/**
 * Created by PhpStorm.
 * User: rickross
 * Date: 1/9/15
 * Time: 9:09 AM
 */
class Config{
    public static function get($path=null){
        if($path){
            $config=$GLOBALS['config'];
            $path=explode('/',$path);

            foreach($path as $bit){
                if(isset($config[$bit])){
                    $config=$config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}