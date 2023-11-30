<?php
// Load Composer autoloader.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Load our base test case class.
require_once 'BaseTestCase.php';

// Load WP_Mock
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();
