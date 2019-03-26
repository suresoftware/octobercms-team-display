<?php namespace SureSoftware\TeamDisplay;

use Backend;
use System\Classes\PluginBase;

/**
 * TeamDisplay Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Team Display',
            'description' => 'Beautifully Display Teams on the frontend of a website. Can filter by tags.',
            'author'      => 'SureSoftware',
            'icon'        => 'icon-users'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'SureSoftware\TeamDisplay\Components\TeamCards' => 'teamCards',
            'SureSoftware\TeamDisplay\Components\IndividualPage' => 'individualPage',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'suresoftware.teamdisplay.edit' => [
                'tab' => 'Team Display',
                'label' => 'Edit Team Members and Tags'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'teamdisplay' => [
                'label'       => 'Team Display',
                'url'         => Backend::url('suresoftware/teamdisplay/teammembers'),
                'icon'        => 'icon-users',
                'permissions' => ['suresoftware.teamdisplay.edit'],
                'order'       => 500,
                'sideMenu' => [
                    'teammebers' => [
                        'label'       => 'Team Members',
                        'icon'        => 'icon-users',
                        'url'         => Backend::url('suresoftware/teamdisplay/teammembers'),
                        'permissions' => ['suresoftware.teamdisplay.edit'],
                    ],
                    'tags' => [
                        'label'       => 'Tags',
                        'icon'        => 'icon-tag',
                        'url'         => Backend::url('suresoftware/teamdisplay/tags'),
                        'permissions' => ['suresoftware.teamdisplay.edit'],
                    ],
                ]
            ],
        ];
    }
}
