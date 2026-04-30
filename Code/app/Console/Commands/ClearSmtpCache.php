<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\S3Service;

class ClearSmtpCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smtp:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached SMTP credentials from S3';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $s3Service = app(S3Service::class);
            $s3Service->clearSmtpCredentialsCache();
            $this->info('SMTP credentials cache cleared successfully.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to clear cache: ' . $e->getMessage());
            return 1;
        }
    }
}

