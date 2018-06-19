<?php namespace SureSoftware\TeamDisplay\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTeamMembersTable extends Migration
{
    public function up()
    {
        Schema::create('suresoftware_teamdisplay_team_members', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('role');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suresoftware_teamdisplay_team_members');
    }
}
