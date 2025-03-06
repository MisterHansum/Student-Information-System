<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade')->after('id');
    });
}

public function down()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->dropForeign(['enrollment_id']);
        $table->dropColumn('enrollment_id');
    });
}

};
