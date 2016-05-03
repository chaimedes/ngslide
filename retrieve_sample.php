<?php

/* 
File info retrieval script for ng-slide, an AngularJS slideshow
To implement, change the sample user, password, database, and hostname to the info for your database,
and rename this file "retrieve.php"
Also consider moving that info into a separate config php file kept above the web root, for security reasons.
Martin Berlove
4/28/2016
*/

require_once 'meekrodb.2.3.class.php'; // Use the MeekroDB library to simplify DB interaction.

// Set up DB info
DB::$user = 'db_user';
DB::$password = 'db_user_pass';
DB::$dbName = 'db_name';
DB::$host = "db_hostname";

// Send back a json encoded result set.
echo json_encode(DB::query("select * from ngslide"));