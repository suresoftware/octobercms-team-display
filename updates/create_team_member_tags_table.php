<?php namespace SureSoftware\TeamDisplay\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTeamMemberTagsTable extends Migration
{
    public function up()
    {
        Schema::create('suresoftware_teamdisplay_team_member_tags', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('team_member_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
        });

        Schema::table('suresoftware_teamdisplay_team_member_tags', function(Blueprint $table) {
            $table->foreign('team_member_id')->references('id')->on('suresoftware_teamdisplay_team_members')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('suresoftware_teamdisplay_tags')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('suresoftware_teamdisplay_team_member_tags');
    }
}
