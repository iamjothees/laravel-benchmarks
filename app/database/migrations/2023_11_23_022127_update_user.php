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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('designation_id')->default(1)->after('name')->constrained();
        });

        \App\Models\User::where('id',1)->first('id')->update(['designation_id' => 2]);

        // \App\Models\User::all('id')->each(
        //     function ($user){
        //         if ($user->id % 2){
        //             $user->designation_id = 2;
        //             $user->save();
        //         }
        //     }
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['designation_id']);
            $table->dropColumn('designation_id');
        });
    }
};
