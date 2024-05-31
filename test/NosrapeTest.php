<?php

namespace Noscrape\Noscrape\Test;

use PHPUnit\Framework\TestCase;
use Noscrape\Noscrape\Noscrape;


class NosrapeTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_noscrape()
    {
        $noscr = new Noscrape("/Users/bernhards/GolandProjects/noscrape/noscrape/example/example.ttf");

        $obf = $noscr->obfuscate("This is a Test");
        self::assertNotEquals("This is a Test", $obf);

        $obf = $noscr->obfuscate(123);
        self::assertNotEquals("123", $obf);

        $obf = $noscr->obfuscate([
            "test" => "This is a Test",
            "another" => [
                "test" => "This is another Test",
            ]
        ]);
        self::assertArrayHasKey("test", $obf);

        $rendered = $noscr->render();
        self::assertGreaterThan(0x1337, strlen($rendered));

    }
}

