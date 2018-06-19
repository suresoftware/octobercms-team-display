<?php namespace SureSoftware\TeamDisplay\Models;

use Model;

/**
 * TeamMember Model
 */
class TeamMember extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'suresoftware_teamdisplay_team_members';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Fillable fields
     */
    protected $with = [
        'tags'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'tags' => ['SureSoftware\TeamDisplay\Models\Tag', 'table' => 'suresoftware_teamdisplay_team_member_tags']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'profileImage' => 'System\Models\File'
    ];
    public $attachMany = [];
}
