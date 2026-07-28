<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('students', function (Blueprint $table) {

        $table->string('birth_certificate')->nullable();
        $table->string('aadher')->nullable();
        $table->string('parent_idproof')->nullable();
        $table->string('address_proof')->nullable();
        $table->string('tc')->nullable();
        $table->string('mark_sheet')->nullable();

    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {

        $table->dropColumn([
            'birth_certificate',
            'aadher',
            'parent_idproof',
            'address_proof',
            'tc',
            'mark_sheet'
        ]);

    });
}
};
