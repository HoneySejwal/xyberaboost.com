<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class S3Service
{
    private $s3Client;
    private $bucket;
    private $region;

    public function __construct()
    {
        $this->bucket = 'po-websites';
        $this->region = env('AWS_DEFAULT_REGION', 'us-east-1');
        
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    /**
     * Fetch SMTP credentials from S3
     * Format: ACCESSKEY;SECRETKEY
     * 
     * @return array|null Returns ['access_key' => ..., 'secret_key' => ...] or null on failure
     */
    public function getSmtpCredentials(): ?array
    {
        try {
            // Cache credentials for 1 hour to reduce S3 API calls
            return Cache::remember('smtp_credentials', 3600, function () {
                $result = $this->s3Client->getObject([
                    'Bucket' => $this->bucket,
                    'Key' => 'SMTP_Credentials.txt',
                ]);

                $content = $result['Body']->getContents();
                
                // Parse the credentials (format: ACCESSKEY;SECRETKEY)
                $parts = explode(';', trim($content));
                
                if (count($parts) !== 2) {
                    Log::error('Invalid SMTP credentials format in S3. Expected format: ACCESSKEY;SECRETKEY');
                    return null;
                }

                return [
                    'access_key' => trim($parts[0]),
                    'secret_key' => trim($parts[1]),
                ];
            });
        } catch (AwsException $e) {
            Log::error('Failed to fetch SMTP credentials from S3: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching SMTP credentials: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Clear cached SMTP credentials
     */
    public function clearSmtpCredentialsCache(): void
    {
        Cache::forget('smtp_credentials');
    }
}

