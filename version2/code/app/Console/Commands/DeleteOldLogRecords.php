<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteOldLogRecords extends Command
{
    protected $signature = 'delete:old-records';
    protected $description = 'ลบข้อมูล Log ที่เก่ากว่า 90 วันออกจากฐานข้อมูล';

    public function handle()
    {
        $dateLimit = Carbon::now()->subDays(90); // วันที่ย้อนหลัง 90 วัน

        DB::table('logs')
            ->where('created_at', '<', $dateLimit)
            ->delete();

        $this->info('Old records deleted successfully.');
    }
}

