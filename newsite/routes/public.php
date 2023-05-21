<?php

use Newsite\Controllers\NewsController;
use Newsite\Core\Router;

Router::get("/", [NewsController::class, "news"]);
Router::get("/new/", [NewsController::class, "newsById"]);
