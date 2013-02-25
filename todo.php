<?php

require('rb.php');
require('StampTE.php');
R::setup();
$template = new StampTE(file_get_contents('template.html'));

list($listItem,$pOpt,$cOpt) = 
	$template->collect('listItem|person|category');


// check if we added some tasks via 'add' button
if (isset($_POST['add']) && !empty($_POST['task'])) {
        $task = R::dispense('task');
        $task->description = $_POST['task'];
        R::store($task);
    }

// check if we marked any tasks as finished before pressing "done" button
if (isset($_POST['trash']) && isset($_POST['done'])) {
	R::trashAll( R::batch('task',$_POST['done']) );
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