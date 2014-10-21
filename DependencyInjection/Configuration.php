<?php
/**
 * Created by PhpStorm.
 * User: ageorgin
 * Date: 21/10/14
 * Time: 14:35
 */

namespace Ageorgin\RestHeadersBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ageorgin_rest_headers');

        return $treeBuilder;
    }

} 