<?php

namespace Schoenbergerb\Noscrape\Test;

use PHPUnit\Framework\TestCase;
use Schoenbergerb\Noscrape\Noscrape;
use Schoenbergerb\Noscrape\OutputType;


class NosrapeTest extends TestCase
{
    public function test_noscrape()
    {
        $noscr = new Noscrape("/Users/bernhards/GolandProjects/noscrape/example/ubuntu.ttf");

        $obf = $noscr->obfuscate("Das ist ein Test!");
        print_r($obf);

        echo "\n";

        $obf = $noscr->obfuscate("und gleich noch einer");
        print_r($obf);

        echo "\n";

        $rendered = $noscr->render(OutputType::BUFFER);

        print_r($rendered);

        $this->assertTrue(true);
    }
}

