<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailConfigService
{
    private $s3Service;

    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    /**
     * Configure mail settings dynamically from S3
     */
    public function configureMailFromS3(): void
    {
        $credentials = $this->s3Service->getSmtpCredentials();

        if ($credentials) {
            // Update mail configuration with credentials from S3
            Config::set('mail.mailers.smtp.username', $credentials['access_key']);
            Config::set('mail.mailers.smtp.password', $credentials['secret_key']);
            
            // You can also set other SMTP settings if needed
            // Config::set('mail.mailers.smtp.host', env('MAIL_HOST', 'smtp.gmail.com'));
            // Config::set('mail.mailers.smtp.port', env('MAIL_PORT', 587));
            // Config::set('mail.mailers.smtp.encryption', env('MAIL_ENCRYPTION', 'tls'));
        } else {
            // Fallback to .env if S3 fetch fails
            Log::warning('Failed to fetch SMTP credentials from S3, falling back to .env');
        }
    }
}

