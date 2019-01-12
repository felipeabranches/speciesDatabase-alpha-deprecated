<?php
// Some workaround so we have absolute paths both in local and remote enviroments
$base_dir  = __DIR__; // Absolute path to your installation, ex: /var/www/mywebsite
$doc_root  = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); # ex: /var/www
$base_url  = preg_replace("!^${doc_root}!", '', $base_dir); # ex: '' or '/mywebsite'
$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$port      = $_SERVER['SERVER_PORT'];
$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
$domain    = $_SERVER['SERVER_NAME'];
if($domain == 'localhost')
{
    $explode  = explode("\\", $base_dir);
    $base_url = "${protocol}://${domain}${disp_port}/${explode[3]}"; # Ex: 'http://localhost', 'https://localhost/folder', etc.
}
else
{
    $base_url = "${protocol}://${domain}${disp_port}${base_url}"; # Ex: 'http://example.com', 'https://example.com/mywebsite', etc.
}

// Global vars
$charset = 'UTF-8';
$author = 'speciesDatabase';
$site_name = 'Peixes da Serra do Cipó - MG';
$debug_mode = 0;
$bootstrap_cdn = 0;
$bootstrap_vsn = '4.1.3';
$bootstrap_path = $base_url.'/libraries/bootstrap-'.$bootstrap_vsn.'-dist';
$tinymce_vsn = '4.7.10';
$tinymce_path = $base_url.'/libraries/tinymce_'.$tinymce_vsn;

// To the Admin menu, needs a better place to be in the future
define('ADMIN', $base_url.'/admin/');
define('SYSTEMATICS', ADMIN.'systematics/');
define('FIELD', ADMIN.'field/');
define('MUSEUM', ADMIN.'museum/');

// Database vars
$database_name = 'cicefetmg';
$username = 'root';
$password = '';
$host = 'localhost';

require_once $base_dir.'/libraries/database/Database.php';
$db = new Database($database_name, $username, $password, $host);
?>