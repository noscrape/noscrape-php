<?php

namespace Noscrape\Noscrape;

use Exception;

class Noscrape {

    use NoscrapeLibraryLoader;

    private string $font;
    private array $mapping = [];
    private array $puaRange;

    /**
     * Constructs a new Noscrape instance.
     *
     * @param string $font The path to the font file to be used.
     * @throws Exception if the font file is not readable.
     */
    public function __construct(string $font)
    {
        if (!is_readable($font)) {
            throw new Exception("Font could not be found at: $font");
        }

        $this->font = $font;
        $this->puaRange = range(0xE000, 0xF8FF);
    }

    /**
     * Obfuscates a given string by mapping each character to a unique PUA (Private Use Area) character.
     *
     * @param string $s The string to be obfuscated.
     * @return string The obfuscated string.
     */
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

            $obfuscated .= mb_convert_encoding('&#' . $this->mapping[$c] . ';', "utf8", "html-entities");
        }

        return $obfuscated;
    }

    /**
     * Renders the obfuscated text using noscrape binary.
     *
     * @return string The result of the rendering process.
     * @throws Exception if the rendering library fails to load.
     */
    public function render(): string
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

?>
