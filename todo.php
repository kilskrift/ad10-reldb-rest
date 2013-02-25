<?php

require('rb.php');
require('StampTE.php');
R::setup();
$template = new StampTE(file_get_contents('template.html'));

list($listItem,$pOpt,$cOpt) = 
	$template->collect('listItem|employee|category');

// populate people selector
foreach(R::find('employee') as $p) {
    $o = $pOpt->copy()->injectAll( array(
			'value'=>$p->id,
			'label'=>$p->name
		)
    );
    $template->glue('employee',$o); 
}

// populate categories selector
foreach(R::find('category') as $c) {
    $o = $cOpt->copy()->injectAll( array(
			'value'=>$c->id,
			'label'=>$c->label
		)
    );
    $template->glue('categories',$o); 
}

// check if we added some tasks via 'add' button
if (isset($_POST['add']) && !empty($_POST['timereport'])) {
        $task = R::dispense('timereport');
        $task->description = $_POST['timereport'];

        // check if we assigned anyone to the task
        if (isset($_POST['assign'])) {
		     $task->ownEmployee = R::batch('employee',$_POST['assign']);	// own = one-to-many
		}

        // check if we selected any categories for the task
		if (isset($_POST['cats'])) {
			$task->sharedCategory = R::batch('category',$_POST['cats']); // shared = many-to-many
		}

        R::store($task);        
    }

// check if we marked any tasks as finished before pressing "done" button
if (isset($_POST['trash']) && isset($_POST['done'])) {
	R::trashAll( R::batch('timereport',$_POST['done']) );
}


// listing tasks
foreach( R::find('timereport') as $t ) {
	// get employee assigned to task
	$ppl = $tags = array();
    foreach($t->ownEmployee as $p) $ppl[] = $p->name;

	// get task tags
	$tags = array();
    foreach($t->sharedCategory as $c) $tags[] = $c->label;
  
	$template->glue(
		'listItems', 
		$listItem->copy()->injectAll( array(
				'description' => $t->description,
				'value' => $t->id,
				'employee' => implode(',', $ppl),
				'tags' => implode(',', $tags)
			) 
		)
	);
}

echo $template;



?>