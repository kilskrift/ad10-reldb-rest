<?php

require('rb.php');
require('StampTE.php');
R::setup();
$template = new StampTE(file_get_contents('template.html'));

list($listItem,$pOpt,$cOpt) = 
	$template->collect('listItem|person|category');


// check if we added some tasks via post action
if (isset($_POST['add']) && !empty($_POST['task'])) {
        $task = R::dispense('task');
        $task->description = $_POST['task'];
        R::store($task);
    }


// listing tasks
foreach( R::find('task') as $t ) {
	$template->glue(
		'listItems', 
		$listItem->copy()->injectAll( array(
				'description' => $t->description,
				'value' => $t->id 
			) 
		)
	);
}

echo $template;



?>