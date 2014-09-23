<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['port'] = 3306;
$db['default']['username'] = 'root';
$db['default']['password'] = 'apmsetup';
$db['default']['database'] = 'checkee';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['naver']['hostname'] = 'crux.snu.ac.kr';
$db['naver']['port'] = 3306;
$db['naver']['username'] = 'naver';
$db['naver']['password'] = 'ids3141';
$db['naver']['database'] = 'navernews';
$db['naver']['dbdriver'] = 'mysql';
$db['naver']['dbprefix'] = '';
$db['naver']['pconnect'] = TRUE;
$db['naver']['db_debug'] = TRUE;
$db['naver']['cache_on'] = FALSE;
$db['naver']['cachedir'] = '';
$db['naver']['char_set'] = 'utf8';
$db['naver']['dbcollat'] = 'utf8_general_ci';
$db['naver']['swap_pre'] = '';
$db['naver']['autoinit'] = TRUE;
$db['naver']['stricton'] = FALSE;

$db['local_naver']['hostname'] = 'localhost';
$db['local_naver']['port'] = 3306;
$db['local_naver']['username'] = 'root';
$db['local_naver']['password'] = 'apmsetup';
$db['local_naver']['database'] = 'navernews';
$db['local_naver']['dbdriver'] = 'mysql';
$db['local_naver']['dbprefix'] = '';
$db['local_naver']['pconnect'] = TRUE;
$db['local_naver']['db_debug'] = TRUE;
$db['local_naver']['cache_on'] = FALSE;
$db['local_naver']['cachedir'] = '';
$db['local_naver']['char_set'] = 'utf8';
$db['local_naver']['dbcollat'] = 'utf8_general_ci';
$db['local_naver']['swap_pre'] = '';
$db['local_naver']['autoinit'] = TRUE;
$db['local_naver']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */