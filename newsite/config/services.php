<?php

use Newsite\Core\ServiceContainer;
use Newsite\Models\Services\NewsService;

ServiceContainer::add('news', new NewsService());

