<?php namespace SureSoftware\TeamDisplay\Models;

use Cms\Classes\Page;
use Cms\Classes\Theme;
use Illuminate\Support\Facades\Log;
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

    protected static function boot() {
        parent::boot();

        static::creating(function ($member) {
            $member->slug = self::generateSlug($member->name);
        });
    }

    public static function generateSlug($name){
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $slug = preg_replace('~-+~', '-', $slug);
        return $slug;
    }

    /**
     * Add the menu type to the site map generation
     *
     * @param $type
     * @return array
     */
    public static function getMenuTypeInfo($type){
        $result = [];

        if ($type == 'team-member-profile') {
            $result = [
                'dynamicItems' => true
            ];
        }

        if ($result) {
            $theme = Theme::getActiveTheme();

            $pages = Page::listInTheme($theme, true);
            $cmsPages = [];

            foreach ($pages as $page) {
                if (!$page->hasComponent('individualPage')) {
                    continue;
                }

                /*
                 * Component must use a categoryPage filter with a routing parameter and post slug
                 * eg: categoryPage = "{{ :somevalue }}", slug = "{{ :somevalue }}"
                 */
                $properties = $page->getComponentProperties('individualPage');
                if (!isset($properties['slug']) || !preg_match('/{{\s*:/', $properties['slug'])) {
                    continue;
                }


                $cmsPages[] = $page;
            }

            $result['cmsPages'] = $cmsPages;
        }

        return $result;
    }

    /**
     * Resolve the menu item with the different pages
     *
     * @param $item
     * @param $url
     * @param $theme
     * @return array
     */
    public static function resolveMenuItem($item, $url, $theme)
    {
        $result = [
            'items' => []
        ];

        $members = TeamMember::with('tags')->get();

        foreach ($members as $member) {
            $postItem = [
                'title' => $member->name,
                'url' => self::getMemberPageUrl($item->cmsPage, $member, $theme),
                'mtime' => $member->updated_at
            ];

            $postItem['isActive'] = $postItem['url'] == $url;

            $result['items'][] = $postItem;
        }

        return $result;
    }

    /**
     * Returns URL of a profile page.
     *
     * @param $pageCode
     * @param $member
     * @param $theme
     * @return string|void
     */
    protected static function getMemberPageUrl($pageCode, $member, $theme)
    {
        $page = Page::loadCached($theme, $pageCode);
        if (!$page) {
            return;
        }

        $properties = $page->getComponentProperties('individualPage');
        if (!isset($properties['slug'])) {
            return;
        }

        /**
         * Filter the profiles based on the filter of the component
         */
        if (isset($properties['filter']) && count($properties['filter']) > 0){
            $tags = $member->tags;

            //will check that every tag on a profile is in the filters
            foreach($tags as $tag){
                if(in_array($tag->name, $properties['filter'])){
                    continue;
                }
                return;
            }
        }

        /*
         * Extract the routing parameter name from the category filter
         * eg: {{ :someRouteParam }}
         */
        if (!preg_match('/^\{\{([^\}]+)\}\}$/', $properties['slug'], $matches)) {
            return;
        }

        $params = [
            'slug'  => $member->slug,
        ];
        $url = Page::url($page->getBaseFileName(), $params);

        return $url;
    }
}
