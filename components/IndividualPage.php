<?php namespace SureSoftware\TeamDisplay\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Log;
use SureSoftware\TeamDisplay\Models\Tag;
use SureSoftware\TeamDisplay\Models\TeamMember;

class IndividualPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Individual Page',
            'description' => 'Shows a specific team member based'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'             => 'Team Member Slug',
                'description'       => 'Slug of the team member',
                'default'           => '{{ :slug }}',
                'type'              => 'string'
            ]
        ];
    }

    /**
     * Add the CSS on the fly only once
     */
    public function onRun()
    {
        $this->addCss('/plugins/suresoftware/teamdisplay/assets/style.css');
    }

    /**
     * Get the specific member to show
     *
     * @return TeamMember
     */
    public function member(){
        $filters = $this->getProperties();

        if(!isset($filters['slug']) || empty($filters['slug'])){
            return null;
        } else {
            return TeamMember::with('tags')->where('slug', $filters['slug'])->first();
        }
    }

    /**
     * Get the names of the tags of the member
     *
     * @return TeamMember
     */
    public function tags(){
        $member = $this->member();

        if(!isset($member->tags) || empty($member->tags)){
            return null;
        } else {
            $tags = $member->tags;
            if($tags == null) return null;
            return $tags->pluck('name');
        }
    }
}
