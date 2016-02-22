<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Admin extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('mainMenu');

        $menu->addChild('Statistiques', [
            'route' => 'admin_default_index',
            'labelAttributes' => [
                'class' => 'fa fa-bar-chart',
            ],
        ]);
        $menu->addChild('Quizz', [
            'route' => 'admin_quizz_index',
            'labelAttributes' => [
                'class' => 'fa fa-trophy',
            ],
        ]);
        $menu->addChild('Règles', [
            'route' => 'admin_rule_index',
            'labelAttributes' => [
                'class' => 'fa fa-file-text',
            ],
        ]);
        $menu->addChild('Participants', [
            'route' => 'admin_datauserfacebook_index',
            'labelAttributes' => [
                'class' => 'fa fa-users',
            ],
        ]);
        $menu->addChild('Utilisateurs', [
            'route' => 'admin_user_index',
            'labelAttributes' => [
                'class' => 'fa fa-users',
            ],
        ]);
        $menu->addChild('Configuration', [
            'route' => 'admin_configuration_index',
            'labelAttributes' => [
                'class' => 'fa fa-cog',
            ],
        ]);

        return $menu;
    }
}