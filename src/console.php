#!/usr/bin/php
<?php

if (php_sapi_name() !== 'cli') {
    throw new Exception('This has to be run from the command line');
}
