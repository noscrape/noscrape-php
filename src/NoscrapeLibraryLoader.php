<?php
namespace Noscrape\Noscrape;

use Exception;

trait NoscrapeLibraryLoader {

    /**
     * @return string
     * @throws Exception
     */
    private static function loadLib(): string
    {
        $os = strtolower(PHP_OS);
        $arch = strtolower(php_uname('m'));
        $filename = __DIR__ . "/../bin/noscrape_{$os}_{$arch}";

        if ($os === "windows") {
            $filename .= ".exe";
        }

        if (!is_readable($filename)) {
            throw new Exception("os/arch not supported $filename");
        }

        return $filename;
    }
}
