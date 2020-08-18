<?php
require_once "vendor/autoload.php";
spl_autoload_register(function ($className) {
    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__;

    // replace namespace separator with directory separator (prolly not required)
    $className = str_replace('\\', $ds, $className);

    // get full name of file containing the required class
    $file = "{$dir}{$ds}{$className}.php";

    // get file if it is readable
    if (is_readable($file)) {
        require_once $file;
    }

});

date_default_timezone_set('Asia/Jakarta');
session_start();

$Session = $_SESSION;
$Request = json_decode(json_encode($_REQUEST));
$num = strripos($_SERVER['PHP_SELF'], 'index.php');
//dd($_SERVER['REQUEST_URI']);
$hal = substr($_SERVER['REQUEST_URI'], $num);
$hal = explode("?", $hal);
$hal = $hal[0];
if ($hal == '') {
    echo "<script>location.href = 'Home';</script>";
}
$free = ['Login', 'Logout', 'Home', 'Proses', 'Website'];
$admin = ['User', 'Panti'];

if (!in_array($hal, $free)) {

    if (!isset($Session['admin'])) {
        echo "<script>alert('Anda belum login, silahkan login');</script>";
        echo "<script>location.href = 'Login';</script>";
    }
}

$route = [
    'Login' => ['class' => "app\Standalone", '@' => 'Login'],
    'Logout' => ['class' => "app\Standalone", '@' => 'Logout'],
    'Home' => ['class' => "app\Standalone", '@' => 'Home'],
    'Dashboard' => ['class' => "app\Admin", '@' => 'Dashboard'],
    'User' => ['class' => "app\Admin", '@' => 'User'],
    'Kecamatan' => ['class' => "app\Admin", '@' => 'Kecamatan'],
    'Panti' => ['class' => "app\Admin", '@' => 'Panti'],
    'Proses' => ['class' => "app\Standalone", '@' => 'Proses'],
    'Website' => ['class' => "app\Standalone", '@' => 'Website'],
    'Metode' => ['class' => "app\Standalone", '@' => 'Metode'],

];

$ctr = $route[$hal]['class'];
$hal2 = $route[$hal]['@'];
$Controller = new $ctr;
$komponen = 'views/Komponen';
$data = $Controller->$hal2($Request, $Session);

include 'views/html.php';
/* Start to develop here. Best regards https://php-download.com/ */
