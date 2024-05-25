<?php

namespace Schoenbergerb\Noscrape;

include __DIR__ . "/../vendor/autoload.php";

use Exception;

class Noscrape {

    use NoscrapeLibraryLoader;

    private string $font;
    private array $mapping = [];

    private array $puaRange;

    /**
     * @throws Exception
     */
    function __construct(string $font)
    {
        if (!is_readable($font)) {
            throw new Exception("font could not be found at: $font");
        }

        $this->font = $font;
        $this->puaRange = range(0xE000, 0xF8FF);
    }

    public function obfuscate(string $s): string
    {
        $availableChars = array_diff($this->puaRange, array_values($this->mapping));

        $obfuscated = '';
        foreach (str_split($s) as $c) {
            if (!isset($this->mapping[$c])) {
                $randomIndex = array_rand($availableChars);
                $this->mapping[$c] = $availableChars[$randomIndex];
                unset($availableChars[$randomIndex]);
            }

            $obfuscated .= mb_chr($this->mapping[$c], 'utf-8');
        }

        return $obfuscated;
    }

    /**
     * @param OutputType $outputType
     * @return string
     * @throws Exception
     */
    public function render(OutputType $outputType=OutputType::BASE64): string
    {
        $binary = self::loadLib();

        $param = json_encode([
            "font" => $this->font,
            "translation" => $this->mapping,
        ]);

        $command = "{$binary} '{$param}'";
        return shell_exec($command);
    }
}


