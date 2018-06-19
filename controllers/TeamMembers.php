<?php namespace SureSoftware\TeamDisplay\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Team Members Back-end Controller
 */
class TeamMembers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('SureSoftware.TeamDisplay', 'teamdisplay', 'teammembers');
    }
}
