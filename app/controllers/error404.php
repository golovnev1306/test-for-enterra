<?php
defined('INCLUDE_INDEX') or die('Restricted access');
use core\Controller;
use core\View;

class Error404 extends Controller
{
    function indexAction() {
        View::render();
    }
}