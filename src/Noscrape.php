<?php

namespace Schoenbergerb\Noscrape;

include "vendor/autoload.php";

use Exception;

class Noscrape {
    private NoscrapeLoader $loader;
    private string $font;
    private string $obfuscation;

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
        $this->obfuscation = $this->loader->noscrape_obfuscate($s);
        $d = json_decode($this->obfuscation, true);
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


