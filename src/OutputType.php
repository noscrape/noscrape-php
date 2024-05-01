<?php
namespace Schoenbergerb\Noscrape;

enum OutputType: string
{
    case FONT_FACE = "style";
    case BASE64 = "base64";
    case BUFFER = "buffer";
}
