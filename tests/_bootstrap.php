<?php

// This is global bootstrap for autoloading

use tad\FunctionMocker\FunctionMocker;

require_once __DIR__ . '/../build/autoload.php';

include_once('_support/extra.php');

FunctionMocker::init();
