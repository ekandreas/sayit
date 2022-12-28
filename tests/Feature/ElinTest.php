<?php

use Ekandreas\Sayit\TextToSpeech;

it("can make use of Elin", function () {
    $factory = TextToSpeech::make(
        $_ENV["SAYIT_AWS_KEY"],
        $_ENV["SAYIT_AWS_SECRET"],
        $_ENV["SAYIT_AWS_REGION"],
        $_ENV["SAYIT_AWS_BUCKET"]
    )
        ->voice("Elin")
        ->engine('neural')
        ->generate("Hej! Jag undrar vad som händer nu. För det kan vara svårt att gå efter vatten över å. Eller hur, ö? Hej då!")
        ->store("test");

    $url = $factory->url();

    $this->assertTrue(strlen($url) > 0);
    $response = file_get_contents($url);
    $this->assertTrue(strlen($response) > 0);
});
