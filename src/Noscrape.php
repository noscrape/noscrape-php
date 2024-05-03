<?php

namespace Schoenbergerb\Noscrape;

include __DIR__ . "/../vendor/autoload.php";

use Exception;

class Noscrape {
    private NoscrapeLoader $loader;
    private string $font;
    private string $obfuscation = "[]";

    /**
     * @throws Exception
     */
    function __construct(string $font)
    {
        if (!is_readable($font)) {
            throw new Exception("font could not be found at: $font");
        }

        $this->loader = NoscrapeLoader::init();
        $this->font = $font;
    }

    public function obfuscate(string $s): string
    {
        $obf = $this->loader->noscrape_obfuscate($s, $this->obfuscation);
        $d = json_decode($obf, true);
        $this->obfuscation = json_encode($d['map']);
        return $d['text'];
    }

    /**
     * @param OutputType $outputType
     * @return string
     * @throws Exception
     */
    public function render(OutputType $outputType=OutputType::BASE64): string
    {
        $result = $this->loader->noscrape_render($this->font, $this->obfuscation);
        return match ($outputType) {
            OutputType::FONT_FACE => "@font-face { font-family: 'noscrape-obfuscated'; src: url('data:font/truetype;charset=utf-8;base64,$result') }",
            OutputType::BUFFER => base64_decode($result),
            default => $result,
        };
    }
}


