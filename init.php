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

// tasks are now timereports
$timereport = R::dispense('timereport');
$timereport->description = 'del ett';
R::store($timereport);