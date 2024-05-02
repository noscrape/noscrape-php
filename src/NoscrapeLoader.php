<?php
namespace Schoenbergerb\Noscrape;

use Exception;
use FFI;

class NoscrapeLoader {

    use NoscrapeLibraryLoader;

    /**
     * @var FFI
     */
    private FFI $ffi;

    private function __construct(FFI $ffi)
    {
        $this->ffi = $ffi;
    }

    /**
     * @return NoscrapeLoader
     * @throws Exception
     */
    public static function init(): NoscrapeLoader
    {
        $ffi = FFI::cdef("
            const char *noscrape_obfuscate(char* text, char* mapping);
            const char *noscrape_render(char* font, char* obf);
        ", self::loadLib());

        return new self($ffi);
    }

    public function noscrape_obfuscate(string $s, ?string $m): string
    {
        return $this->ffi->noscrape_obfuscate($s, $m);
    }

    public function noscrape_render(string $font, string $obf): string
    {
        return $this->ffi->noscrape_render($font, $obf);
    }
}
