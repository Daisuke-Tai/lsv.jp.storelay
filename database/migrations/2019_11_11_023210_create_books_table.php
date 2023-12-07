<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kind_id')->unsigned();
            $table->integer('tema_id');
            $table->integer('page_no');
            $table->integer('post_id');
            $table->text('story', 1000);            
            $table->integer('user_id');

            $table->string('root', 1000);
            $table->integer('del_f')->length(1)->default(0);
            $table->timestamps();
//            $table->timestamps();

            //  一意制約
            $table->unique(['kind_Id', 'tema_id', 'page_no', 'post_id']);
            // 外部キーを設定する
            $table->foreign('kind_id')->references('id')->on('kinds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
