<?php namespace SureSoftware\TeamDisplay\Models;

use Model;

/**
 * Tag Model
 */
class Tag extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'suresoftware_teamdisplay_tags';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'teamMembers' => ['SureSoftware\TeamDisplay\Models\TeamMember', 'table' => 'suresoftware_teamdisplay_team_member_tags']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
