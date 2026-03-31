<?php

declare(strict_types=1);

namespace Rami\Bundle\AcademyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RamiAcademyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        if (is_file(__DIR__ . '/../Resources/config/services.yml')) {
            $loader->load('services.yml');
        }
    }
}
