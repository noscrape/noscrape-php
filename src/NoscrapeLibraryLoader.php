<?php
namespace Schoenbergerb\Noscrape;

use Exception;

trait NoscrapeLibraryLoader {
    private static function loadLib() {
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
