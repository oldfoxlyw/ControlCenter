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

$active_group = 'webdb';
$active_record = TRUE;

$db['webdb']['hostname'] = 'localhost';
$db['webdb']['username'] = 'datadigi';
$db['webdb']['password'] = 'DaTa743HIOildew';
$db['webdb']['database'] = 'datadigi_scc_webdb';
$db['webdb']['dbdriver'] = 'mysql';
$db['webdb']['dbprefix'] = '';
$db['webdb']['pconnect'] = FALSE;
$db['webdb']['db_debug'] = TRUE;
$db['webdb']['cache_on'] = FALSE;
$db['webdb']['cachedir'] = '';
$db['webdb']['char_set'] = 'utf8';
$db['webdb']['dbcollat'] = 'utf8_general_ci';
$db['webdb']['swap_pre'] = '';
$db['webdb']['autoinit'] = TRUE;
$db['webdb']['stricton'] = FALSE;

$db['accountdb']['hostname'] = 'localhost';
$db['accountdb']['username'] = 'datadigi';
$db['accountdb']['password'] = 'DaTa743HIOildew';
$db['accountdb']['database'] = 'datadigi_scc_accountdb';
$db['accountdb']['dbdriver'] = 'mysql';
$db['accountdb']['dbprefix'] = '';
$db['accountdb']['pconnect'] = FALSE;
$db['accountdb']['db_debug'] = TRUE;
$db['accountdb']['cache_on'] = FALSE;
$db['accountdb']['cachedir'] = '';
$db['accountdb']['char_set'] = 'utf8';
$db['accountdb']['dbcollat'] = 'utf8_general_ci';
$db['accountdb']['swap_pre'] = '';
$db['accountdb']['autoinit'] = TRUE;
$db['accountdb']['stricton'] = FALSE;

$db['logdb']['hostname'] = 'localhost';
$db['logdb']['username'] = 'datadigi';
$db['logdb']['password'] = 'DaTa743HIOildew';
$db['logdb']['database'] = "datadigi_scc_logdb_20133";
$db['logdb']['dbdriver'] = 'mysql';
$db['logdb']['dbprefix'] = '';
$db['logdb']['db_debug'] = TRUE;
$db['logdb']['pconnect'] = FALSE;
$db['logdb']['cache_on'] = FALSE;
$db['logdb']['cachedir'] = '';
$db['logdb']['char_set'] = 'utf8';
$db['logdb']['dbcollat'] = 'utf8_general_ci';
$db['logdb']['swap_pre'] = '';
$db['logdb']['autoinit'] = TRUE;
$db['logdb']['stricton'] = FALSE;

$db['weblogdb']['hostname'] = 'localhost';
$db['weblogdb']['username'] = 'datadigi';
$db['weblogdb']['password'] = 'DaTa743HIOildew';
$db['weblogdb']['database'] = "datadigi_scc_weblogdb";
$db['weblogdb']['dbdriver'] = 'mysql';
$db['weblogdb']['dbprefix'] = '';
$db['weblogdb']['pconnect'] = FALSE;
$db['weblogdb']['db_debug'] = TRUE;
$db['weblogdb']['cache_on'] = FALSE;
$db['weblogdb']['cachedir'] = '';
$db['weblogdb']['char_set'] = 'utf8';
$db['weblogdb']['dbcollat'] = 'utf8_general_ci';
$db['weblogdb']['swap_pre'] = '';
$db['weblogdb']['autoinit'] = TRUE;
$db['weblogdb']['stricton'] = FALSE;

$db['productdb']['hostname'] = 'localhost';
$db['productdb']['username'] = 'datadigi';
$db['productdb']['password'] = 'DaTa743HIOildew';
$db['productdb']['database'] = 'datadigi_scc_productdb';
$db['productdb']['dbdriver'] = 'mysql';
$db['productdb']['dbprefix'] = '';
$db['productdb']['pconnect'] = FALSE;
$db['productdb']['db_debug'] = TRUE;
$db['productdb']['cache_on'] = FALSE;
$db['productdb']['cachedir'] = '';
$db['productdb']['char_set'] = 'utf8';
$db['productdb']['dbcollat'] = 'utf8_general_ci';
$db['productdb']['swap_pre'] = '';
$db['productdb']['autoinit'] = TRUE;
$db['productdb']['stricton'] = FALSE;

$db['authdb']['hostname'] = 'localhost';
$db['authdb']['username'] = 'datadigi';
$db['authdb']['password'] = 'DaTa743HIOildew';
$db['authdb']['database'] = 'datadigi_scc_authorization';
$db['authdb']['dbdriver'] = 'mysql';
$db['authdb']['dbprefix'] = '';
$db['authdb']['pconnect'] = FALSE;
$db['authdb']['db_debug'] = TRUE;
$db['authdb']['cache_on'] = FALSE;
$db['authdb']['cachedir'] = '';
$db['authdb']['char_set'] = 'utf8';
$db['authdb']['dbcollat'] = 'utf8_general_ci';
$db['authdb']['swap_pre'] = '';
$db['authdb']['autoinit'] = TRUE;
$db['authdb']['stricton'] = FALSE;

$db['comdb']['hostname'] = 'localhost';
$db['comdb']['username'] = 'datadigi';
$db['comdb']['password'] = 'DaTa743HIOildew';
$db['comdb']['database'] = 'datadigi_scc_commercial';
$db['comdb']['dbdriver'] = 'mysql';
$db['comdb']['dbprefix'] = '';
$db['comdb']['pconnect'] = FALSE;
$db['comdb']['db_debug'] = TRUE;
$db['comdb']['cache_on'] = FALSE;
$db['comdb']['cachedir'] = '';
$db['comdb']['char_set'] = 'utf8';
$db['comdb']['dbcollat'] = 'utf8_general_ci';
$db['comdb']['swap_pre'] = '';
$db['comdb']['autoinit'] = TRUE;
$db['comdb']['stricton'] = FALSE;

$db['promotiondb']['hostname'] = 'localhost';
$db['promotiondb']['username'] = 'datadigi';
$db['promotiondb']['password'] = 'DaTa743HIOildew';
$db['promotiondb']['database'] = 'datadigi_scc_promotion';
$db['promotiondb']['dbdriver'] = 'mysql';
$db['promotiondb']['dbprefix'] = '';
$db['promotiondb']['pconnect'] = FALSE;
$db['promotiondb']['db_debug'] = TRUE;
$db['promotiondb']['cache_on'] = FALSE;
$db['promotiondb']['cachedir'] = '';
$db['promotiondb']['char_set'] = 'utf8';
$db['promotiondb']['dbcollat'] = 'utf8_general_ci';
$db['promotiondb']['swap_pre'] = '';
$db['promotiondb']['autoinit'] = TRUE;
$db['promotiondb']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */