<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

define("__DB_NAME__", 'job');
define("__DB_DSN__", 'mysql:dbname=' . __DB_NAME__ . ';host=127.0.0.1');
define("__DB_USERNAME__", 'root');
define("__DB_PASSWORD__", '');

if(session_id() == '') {
  session_start();
}

if(!isset($_SESSION['username']))
{
    $_SESSION['username'] = NULL;
}

//database setup
try {
	$db = new PDO ( __DB_DSN__, __DB_USERNAME__, __DB_PASSWORD__ );
	$db->query ( "use " . __DB_NAME__);
}

catch ( PDOException $e ) {
	echo 'Could not connect : ' . $e->getMessage ();
}

?>