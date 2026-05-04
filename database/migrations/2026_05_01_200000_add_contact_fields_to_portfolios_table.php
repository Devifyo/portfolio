<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_upwork')->nullable()->after('contact_calendly');
            $table->string('contact_fiverr')->nullable()->after('contact_upwork');
            $table->string('contact_freelancer')->nullable()->after('contact_fiverr');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['contact_phone', 'contact_upwork', 'contact_fiverr', 'contact_freelancer']);
        });
    }
};
