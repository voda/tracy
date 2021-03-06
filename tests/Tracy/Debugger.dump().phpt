<?php

/**
 * Test: Tracy\Debugger::dump() production vs development
 *
 * @author     David Grudl
 * @package    Tracy
 */

use Tracy\Debugger;



require __DIR__ . '/../bootstrap.php';


header('Content-Type: text/plain');
putenv('TERM=');


// production mode
Debugger::$productionMode = TRUE;

ob_start();
Debugger::dump('sensitive data');
Assert::same( '', ob_get_clean() );

Assert::match( '"forced" (6)', Debugger::dump('forced', TRUE) );


// development mode
Debugger::$productionMode = FALSE;

ob_start();
Debugger::dump('sensitive data');
Assert::match( '"sensitive data" (14)
', ob_get_clean() );

Assert::match( '"forced" (6)', Debugger::dump('forced', TRUE) );


// returned value
$obj = new stdClass;
Assert::same( Debugger::dump($obj), $obj );
