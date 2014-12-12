<?php

//-- Databases
define ('DB_NAME', 'mgf');
define ('DB_USER', 'dbuser');
define ('DB_PASS', 'dbpassword');
define ('DB_HOST', 'localhost');

//-- Application Mode
/*

			ALWAYS SET "FALSE" IN PRODUCTION/DEPLOYMENT;

*/
define ('DEVELOPMENT_MODE', true);

//------------------------------------------------------------------- set by user

//-- Default engine location (on URL)
define ('ENG_PATH', 'mgf');

//-- Default base directory URL of engine (on URL)
define ('ENG_BASE_DIR', '');

//-- Default Application Directory (on disc/drive); route to 'default'
define ('APP_NAME', 'mgf');

//-- Default Application Routing (on Controller); Capitalized word and plural (with (s))
define ('ROUTE_DEFAULT', 'Hellos');

//-- Default Action, if not defined go to index function (on Controller)
define ('ACTION_DEFAULT', 'index');
