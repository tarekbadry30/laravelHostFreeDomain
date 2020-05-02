<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->text("not_title");
            $table->integer("not_from_id")->unsigned();
            $table->integer("not_to_id")->unsigned();
            $table->integer("comment_id")->unsigned();
            $table->integer("post_id")->unsigned();

            $table->foreign("not_from_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("not_to_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("comment_id")->references("id")->on("comments")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade")->onUpdate("cascade");
            $table->enum("status",['notRead','Read']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
