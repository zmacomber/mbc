<?php

define('MM_BRUTE_FILE', '/home/drmitch/tmp/brute.txt');
define('MM_BRUTE_WINDOW', 15*60);
define('MM_BRUTE_ATTEMPTS', 5);

class Services {


//call with no parameters to get a true/false response. If true, do not process login.
//call with parameter set to true to register a new failed attempt for current user and return a true/false response.
public static function bruteCheck($failed_attempt = false) {
$deny_login = false;

if(!file_exists(MM_BRUTE_FILE)) touch(MM_BRUTE_FILE);
$cache = unserialize(Services::fileToString(MM_BRUTE_FILE));
if(!$cache) $cache = array();

if($failed_attempt) {  //register the new failed attempt and timestamp
  if(!isset($cache[$_SERVER['REMOTE_ADDR']])) {
$cache[$_SERVER['REMOTE_ADDR']] = array();
  }
  $cache[$_SERVER['REMOTE_ADDR']][] = time();
  if(count($cache[$_SERVER['REMOTE_ADDR']]) > MM_BRUTE_ATTEMPTS) array_shift($cache[$_SERVER['REMOTE_ADDR']]);
}

//get the number of failed attempts in the last 15 minutes
if(!isset($cache[$_SERVER['REMOTE_ADDR']])) {
  $deny_login = false;
} else {
  $attempts = $cache[$_SERVER['REMOTE_ADDR']];
  if(count($attempts) < MM_BRUTE_ATTEMPTS) {
      $deny_login = false;
  } else {
if($attempts[0] + MM_BRUTE_WINDOW > time()) $deny_login = true;
else $deny_login = false;
  }
}

//cleanup the cache so it doesn't get too large over time
foreach($cache as $ip=>$attempts) {
  if($attempts) {
      if($attempts[count($attempts)-1] + MM_BRUTE_WINDOW < time()) {
    unset($cache[$ip]);
}
  }
}

Services::stringToFile(MM_BRUTE_FILE, serialize($cache));

return $deny_login;
}

public static function fileToString($filename) {
    return file_get_contents($filename);
}

public static function stringToFile($filename, $data) {
    $file = fopen ($filename, "w");
    fwrite($file, $data);
    fclose ($file);
    return true;
}
}
?>
