<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Admin extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('mainMenu');

        $menu->addChild('Utilisateurs', [
            'route' => 'admin_user_index',
            'labelAttributes' => [
                'class' => 'fa fa-users',
            ],
        ]);
        $menu->addChild('Content Block', [
            'route' => 'admin_contentblock_index',
            'labelAttributes' => [
                'class' => 'fa fa-file-text',
            ],
        ]);

        return $menu;
    }
}