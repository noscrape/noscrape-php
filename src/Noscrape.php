<?php

namespace Noscrape\Noscrape;

use Exception;

/**
 * Class Noscrape
 *
 * Provides functionality to obfuscate text using a specified font and render it using an external library.
 */
class Noscrape {

    use NoscrapeLibraryLoader;

    /**
     * @var string Path to the font file.
     */
    private string $font;

    /**
     * @var array Mapping of original characters to PUA characters.
     */
    private array $mapping = [];

    /**
     * @var array Range of Private Use Area (PUA) Unicode characters.
     */
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
        $this->puaRange = range(0xE000, 0xF8FF);  // Define the range of PUA characters
    }

    /**
     * Obfuscates a given string by mapping each character to a unique PUA (Private Use Area) character.
     *
     * This method ensures that each character in the input string is replaced by a unique PUA character,
     * selected randomly from the available PUA characters that haven't been used yet.
     *
     * @param string|int|array $s The string to be obfuscated.
     * @return string|array The obfuscated string|array.
     */
    public function obfuscate(string|int|array $s): string|array
    {
        if (is_string($s)) {
            return $this->obfuscateString($s);
        }

        if (is_integer($s)) {
            return $this->obfuscateString("$s");
        }

        foreach ($s as $k => $v) {
            $s[$k] = $this->obfuscate($v);
        }
        return $s;
    }

    private function obfuscateString(string $s): string {
        // Available characters are those in the PUA range that haven't been mapped yet
        $availableChars = array_diff($this->puaRange, array_values($this->mapping));

        $obfuscated = '';
        foreach (str_split($s) as $c) {
            // If the character hasn't been mapped yet, map it to a random available PUA character
            if (!isset($this->mapping[$c])) {
                $randomIndex = array_rand($availableChars);
                $this->mapping[$c] = $availableChars[$randomIndex];
                unset($availableChars[$randomIndex]);
            }

            // Convert the PUA character code to a UTF-8 encoded character and append it to the result
            $obfuscated .= mb_convert_encoding('&#' . $this->mapping[$c] . ';', "utf8", "html-entities");
        }

        return $obfuscated;
    }

    /**
     * Renders the obfuscated text using noscrape binary.
     *
     * This method serializes the font path and the character mapping into JSON,
     * then uses a shell command to call the noscrape binary for rendering.
     *
     * @return string The result of the rendering process.
     * @throws Exception if the rendering library fails to load.
     */
    public function render(): string
    {
        // Load the external rendering library
        $binary = self::loadLib();

        // Prepare the parameters for the rendering library
        $param = json_encode([
            "font" => $this->font,
            "translation" => $this->mapping,
        ]);

        // Execute the rendering command and return the output
        return shell_exec( "{$binary} '{$param}'");
    }
}
