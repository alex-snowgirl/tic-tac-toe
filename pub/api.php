<?php
/**
 * Created by PhpStorm.
 * User: snowgirl
 * Date: 12/5/17
 * Time: 7:22 PM
 */
use TIC_TAC_TOE\API;

require '../vendor/autoload.php';

//simple api call (parse request,execute it and send the response) + all dependencies inside (simple realization)
new API($_REQUEST);