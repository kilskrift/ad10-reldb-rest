<?php

require('rb.php');
R::setup();
R::nuke();

// new employees
foreach(array('Kristian','Josefina','Sanna') as $p) {
	$employee = R::dispense('employee');
	$employee->name = $p;
	R::store($employee);
}

// new categories
foreach(array('Kurser','Tentor','Labbar') as $c) {
	$category = R::dispense('category');
	$category->label = $c;
	R::store($category);
}

// tasks are now timereports w/description & time (hours)
$timereport = R::dispense('timereport');
$timereport->description = 'Tutorial';
$timereport->hours = 1;
//$timereport->sharedEmployee = R::batch('employee','Kristian');

R::store($timereport);

?>