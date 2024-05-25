<?php

namespace Schoenbergerb\Noscrape\Test;

use PHPUnit\Framework\TestCase;
use Schoenbergerb\Noscrape\Noscrape;
use Schoenbergerb\Noscrape\OutputType;


class NosrapeTest extends TestCase
{
    public function test_noscrape()
    {
        for ($i = 0; $i < 10; $i++) {
            $noscr = new Noscrape("/Users/bernhards/GolandProjects/noscrape/noscrape/example/example.ttf");

            $obf = $noscr->obfuscate("Das ist ein Test!");
            // print_r($obf);

            // echo "\n";

            $obf = $noscr->obfuscate("und gleich noch einer");
            # print_r($obf);

            // echo "$i\n";

            $rendered = $noscr->render(OutputType::BUFFER);
        }


        $this->assertTrue(true);
    }
}

