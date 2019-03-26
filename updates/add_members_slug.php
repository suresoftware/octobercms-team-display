<?php namespace SureSoftware\TeamDisplay\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use SureSoftware\TeamDisplay\Models\TeamMember;

class CreateTeamMembersTable extends Migration
{
    public function up()
    {
        Schema::table('suresoftware_teamdisplay_team_members', function(Blueprint $table) {
            $table->string('slug')->nullable();
        });

        $teamMembers = TeamMember::get();
        foreach($teamMembers as $member){
            $member->slug = TeamMember::generateSlug($member->name);
            $member->save();
        }
    }

    public function down()
    {
        Schema::table('suresoftware_teamdisplay_team_members', function(Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
