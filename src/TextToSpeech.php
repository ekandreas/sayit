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

    protected string $stream;
    protected string $url;
    protected string $voice;

    public static function make(
        string $key,
        string $secret,
        string $region,
        string $bucket
    ) {
        $me = new static();
        $me->key = $key;
        $me->secret = $secret;
        $me->region = $region;
        $me->bucket = $bucket;

        $me->voice = "Elin";

        return $me;
    }

    private function aws()
    {
        return [
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ],
        ];
    }

    public function generate(string $speech): TextToSpeech
    {
        $polly = new PollyClient($this->aws());

        $sentences = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $speech);

        $this->stream = "";

        foreach ($sentences as $sentence) {

            $result = $polly->synthesizeSpeech([
                'Text' => "{$sentence}",
                'OutputFormat' => 'mp3',
                'TextType' => 'text',
                'VoiceId' => $this->voice,
            ]);

            $this->stream .= $result['AudioStream'];
        }

        return $this;
    }

    public function store(string $path): TextToSpeech
    {
        $s3 = new S3Client($this->aws());

        $id = uniqid("sayit_");
        $year = date('Y');
        $month = date('m');

        $result = $s3->putObject([
            'Bucket' => $this->bucket,
            'Key' => "{$path}/{$year}/{$month}/{$id}.mp3",
            'Body' => $this->stream,
            'ACL' => 'public-read',
        ]);

        $this->url = $result['ObjectURL'];

        return $this;
    }

    public function voice(string $voice)
    {
        $this->voice = $voice;

        return $this;
    }

    public function url()
    {
        return $this->url;
    }

    public function stream()
    {
        return $this->stream;
    }
}
