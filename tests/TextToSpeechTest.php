<?php

namespace Ekandreas\Sayit\Tests;

use Ekandreas\Sayit\TextToSpeech;
use PHPUnit\Framework\TestCase;

class TextToSpeechTest extends TestCase
{
    /** @test */
    public function transform_text_to_s3()
    {
        $factory = TextToSpeech::make(
            getenv("SAYIT_AWS_KEY"),
            getenv("SAYIT_AWS_SECRET"),
            getenv("SAYIT_AWS_REGION"),
            getenv("SAYIT_AWS_BUCKET")
        )
            ->voice("Astrid")
            ->generate("Hej! Jag undrar vad som händer nu. För det kan vara svårt att gå efter vatten över å. Eller hur, ö? Hej då!")
            ->store("test");

        $url = $factory->url();

        $this->assertTrue(strlen($url) > 0);
        $response = file_get_contents($url);
        $this->assertTrue(strlen($response) > 0);
    }
}
