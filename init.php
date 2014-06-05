<?php
// register autoloader with module path
Kohana_Elastica::register_autoloader(
	realpath(dirname(__FILE__))
);
