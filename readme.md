# Noscrape - PHP

### Installation
- add repository to your `composer.json`
```json
"repositories": [
    {
        "url": "https://github.com/noscrape/noscrape-php.git",
        "type": "git"
    }
],
```
- add noscrape to require section
```json
"require": {
    ...
    "noscrape/noscrape": "dev-main"
},
```

### Example Usage

```php
$noscrape = new Noscrape('path/to/font.ttf');

$text1 = $noscrape->obfuscate("placeholder text");
$text2 = $noscrape->obfuscate("another placeholder text");
$font = $noscrape->render();

# in your template header ...


```
in your template
```bladehtml
<style>
    @font-face {
        font-family: 'noscrape-obfuscated';
        src: url("data:font/truetype;charset=utf-8;base64,{{ $font }}");
    }
    .obfuscated {
        font-family: "noscrape-obfuscated";
    }
</style>

...

<div class="obfuscated">{{ $text1 }}</div>
<div class="obfuscated">{{ $text2 }}</div>
```



### Supported CPU Architectures
- Darwin Arm64
- Darwin x86_64
- Linux Arm64
- Linux x86_64
- Windows x86_64

if you miss your needed os/arch, feel free to contact us <a href="mailto:noscrape@gmx.de">noscrape@gmx.de</a>


