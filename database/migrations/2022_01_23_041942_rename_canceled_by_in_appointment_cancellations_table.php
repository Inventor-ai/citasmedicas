<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class RenameCanceledByInAppointmentCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_cancellations', function (Blueprint $table) {
          $table->renameColumn('canceled_by', 'canceled_by_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_cancellations', function (Blueprint $table) {
          $table->renameColumn('canceled_by_id', 'canceled_by');
        });
    }
}
