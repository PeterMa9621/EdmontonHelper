<?php

namespace Blog;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}