<?php

require('rb.php');
require('StampTE.php');
R::setup();
$template = new StampTE(file_get_contents('template.html'));

list($listItem,$pOpt,$cOpt) = 
	$template->collect('listItem|person|category');

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