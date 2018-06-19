<?php namespace SureSoftware\TeamDisplay\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Log;
use SureSoftware\TeamDisplay\Models\Tag;
use SureSoftware\TeamDisplay\Models\TeamMember;

class TeamCards extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Team Cards',
            'description' => 'Display multiple team members, and show their description on hover'
        ];
    }

    public function defineProperties()
    {
        $tagCollection = Tag::all();
        $tags = [];
        foreach($tagCollection as $tag){
            $tags[$tag->id] = $tag->name;
        }

        return [
            'tag' => [
                'title'             => 'Tag',
                'description'       => 'Only show team members with the tag',
                'type'              => 'dropdown',
                'options'           => $tags
            ]
        ];
    }

    /**
     * Get the filtered members
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function members(){
        $filters = $this->getProperties();

        if(!isset($filters['tag']) || empty($filters['tag'])){
            return TeamMember::get();
        } else {
            Log::info("filtered");
            Log::info(json_encode(Tag::find($filters['tag'])->teamMembers()->get()));
            return Tag::find($filters['tag'])->teamMembers()->get();
        }
    }
}
