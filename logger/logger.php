<?php
  class Logger {
    private static function addEntry($str) {
      $handle = fopen('logs.log', 'a');
      fwrite($handle, sprintf("%s %s\n", date('c'), $str));
      fclose($handle);
    }

    public static function warn($str) {
      self::addEntry(" | WARNING | $str");
    }

    public static function info($str) {
      self::addEntry(" | INFO | $str");
    }

    public static function debug($str) {
      self::addEntry(" | DEBUG | $str");
    }

    public static function loginSuccessfully($login) {
      $ip = self::getIp();
      $str = "[LOGIN] $login successfylly logged in from $ip.";
      self::info($str);
    }

    public static function loginErrorWarn($login) {
      $ip = self::getIp();
      $str = "[FAILED LOGIN] $login tried to log in from $ip.";
      self::warn($str);
    }

    private static function getIp() {
      $ipaddress = '';
      if (isset($_SERVER['HTTP_CLIENT_IP']))
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_X_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      else if(isset($_SERVER['REMOTE_ADDR']))
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
    }
  }
