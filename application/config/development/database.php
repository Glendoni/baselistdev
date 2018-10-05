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
|    
|    $DB1 = $this->load->database('group_two', TRUE);  if using multiple databases use this sytax to connect
|                                                      the default database connection name is called default however this can be named to whatever you want.
|                                                      anything you want within first parameter of the multidimentional array.
|           $DB1->query() use this syntax to query the database. Change the $DB1 variable to match whatever you choose as the connection variable.
|           $DB1->result(); use this syntax to return the query array. Change the $DB1 variable to match whatever you choose as the connection variable.
|
|
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
$db['default']['username'] = 'homestead';
$db['default']['password'] = 'secret';
$db['default']['database'] = 'baselist';
$db['default']['dbdriver'] = 'postgre';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
 $db['default']['port'] = 5432;
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

//Second DB connection string

$db['olive']['hostname'] = 'ec2-54-83-52-144.compute-1.amazonaws.com';
$db['olive']['username'] = 'xhzgajpalgleka';
$db['olive']['password'] = '0e7EcoxppxFx3BhlMDQ7bveCVt';
$db['olive']['database'] = 'd1o6886mll7nc5';
$db['olive']['dbdriver'] = 'postgre';
$db['olive']['dbprefix'] = '';
$db['olive']['pconnect'] = TRUE;
$db['olive']['db_debug'] = TRUE;
$db['olive']['cache_on'] = FALSE;
 $db['olive']['port'] = 5432;
$db['olive']['cachedir'] = '';
$db['olive']['char_set'] = 'utf8';
$db['olive']['dbcollat'] = 'utf8_general_ci';
$db['olive']['swap_pre'] = '';
$db['olive']['autoinit'] = TRUE;
$db['olive']['stricton'] = FALSE;



//Second DB connection string

$db['autopilot']['hostname'] = 'ec2-54-83-52-144.compute-1.amazonaws.com';
$db['autopilot']['username'] = 'xhzgajpalgleka';
$db['autopilot']['password'] = '0e7EcoxppxFx3BhlMDQ7bveCVt';
$db['autopilot']['database'] = 'd1o6886mll7nc5';
$db['autopilot']['dbdriver'] = 'postgre';
$db['autopilot']['dbprefix'] = '';
$db['autopilot']['pconnect'] = TRUE;
$db['autopilot']['db_debug'] = TRUE;
$db['autopilot']['cache_on'] = FALSE;
 $db['autopilot']['port'] = 5432;
$db['autopilot']['cachedir'] = '';
$db['autopilot']['char_set'] = 'utf8';
$db['autopilot']['dbcollat'] = 'utf8_general_ci';
$db['autopilot']['swap_pre'] = '';
$db['autopilot']['autoinit'] = TRUE;
$db['autopilot']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
