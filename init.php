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
$timereport->description = 'del ett';
$timereport->hours = 1.0;

R::store($timereport);

?>