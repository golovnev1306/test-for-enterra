<?php

class Main extends Controller
{
    function indexAction() {
        View::render([
            "test" => "tr"
        ]);
    }
}