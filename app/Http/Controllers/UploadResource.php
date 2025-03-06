<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\S3\S3Client;

class UploadResource extends Controller
{
    public function uploadToS3($fileName, $fileData, $folder)
    {

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $bucket = env('AWS_BUCKET');
        $filePath = "$folder/$fileName";

        $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $filePath,
            'Body' => $fileData,
        ]);

        try {
            $result = $s3->headObject([
                'Bucket' => $bucket,
                'Key' => $filePath,
            ]);

            $s3Link = $s3->getObjectUrl($bucket, $filePath);
            return $s3Link;
        } catch (\Aws\S3\Exception\S3Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }
}
