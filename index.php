<?php // for testing

require_once 'database.php';

$db = new Database; // or new Database(' ../app/database/config/ --- path where the config (config.php) file is')

//insert
$q = 'INSERT INTO employee (id, name, website) VALUES (:id, :name, :website)';
$bind = [
    'id' => 2,
    'name' => 'John Doe',
    'website' => 'website.com',
];
$db->query($q, $bind);

// select
$emp = $db->query('SELECT *  FROM employee', []);
echo "<pre>";
print_r($emp);
echo "</pre>";

// update
$q = 'UPDATE employee set website = :newwebsite WHERE id = :id';
$bind = [
    'id' => 2,
    'newwebsite' => 'new-website.com'
];
$db->query($q, $bind);

// delete
$q = 'DELETE FROM employee WHERE id = :id';
$bind = [
    'id' => 2
];
$db->query($q, $bind);
