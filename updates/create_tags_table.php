<?php namespace SureSoftware\TeamDisplay\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use SureSoftware\TeamDisplay\Models\Tag;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('suresoftware_teamdisplay_tags', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Tag::create([
            "name" => "Default"
        ])->save();
    }

    public function down()
    {
        Schema::dropIfExists('suresoftware_teamdisplay_tags');
    }
}
