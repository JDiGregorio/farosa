<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JdRelacionSalesRepWithUsers extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('digitar_precio')->nullable()->default(FALSE);
            $table->integer('SalesRep_id')->unsigned()->nullable();
			$table->foreign('SalesRep_id')->references('ID')->on('SalesRep');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['SalesRep_id']);
            $table->dropColumn('SalesRep_id');
            $table->dropColumn('digitar_precio');
        });
    }
}
