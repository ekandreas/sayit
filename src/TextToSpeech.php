<?php

namespace Ekandreas\Sayit;

use Aws\Polly\PollyClient;
use Aws\S3\S3Client;

class TextToSpeech
{
    protected string $key;
    protected string $secret;
    protected string $region;
    protected string $bucket;

    public static function make(
        string $key,
        string $secret,
        string $region,
        string $bucket
    ) {

        $me = new static;
        $me->key = $key;
        $me->secret = $secret;
        $me->region = $region;
        $me->bucket = $bucket;

        return $me;
    }

    /**
     * Transforms text to speech and returns a public S3 url to the mp3 file placed in the given path for the bucket.
     */
    public function convert(string $speech, string $path): string
    {
        $aws = [
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ]
        ];

        $polly = new PollyClient($aws);

        $response = $polly->synthesizeSpeech([
            'Text' => $speech,
            'OutputFormat' => 'mp3',
            'TextType' => 'text',
            'VoiceId' => 'Astrid'
        ]);

        $s3 = new S3Client($aws);

        $result = $s3->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $path . "/" . uniqid() . '.mp3',
            'Body'   => $response['AudioStream'],
            'ACL'    => 'public-read'
        ]);

        return $result['ObjectURL'];
    }
}
