# phpDocumentor v3 markdown template

[phpDocumentor v3 template](https://docs.phpdoc.org/3.0/guide/features/theming/index.html) that generates Markdown documentation.

This is a heavily modified version of a [phpDocumentor v2 markdown template](https://github.com/fr3nch13/phpdoc-markdown).

The main use-case for this template is to generate simple and nice looking usage documentation, that can then be published on GitHub/GitLab.

For example, a small library can document it's public API in DocBlock comments, use this template to generate the Markdown documentation and then commit it to GitHub with the library to easily create a nice looking documentation for other developers to see.

## Installation

Install with composer:

```bash
composer require ramynasr/phpdoc-markdown
```

## Usage

Run phpDocumentor and set template as `vendor/ramynasr/phpdoc-markdown/data/templates/markdown`.
**Example using configuration file:**

Add a file called `phpdoc.xml` (or `phpdoc.dist.xml`) with the following content to the root of your project and invoke the `phpdoc` command without arguments.
Modify the configuration to suit your project. You can read more about [phpDocumentor v3 configuration here](https://docs.phpdoc.org/3.0/guide/references/configuration.html).

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<phpdocumentor configVersion="3.0">
    <paths>
        <output>docs</output>
        <cache>.phpdoc/cache</cache>
    </paths>
    <template name="markdown" location="vendor/ramynasr/phpdoc-markdown/data/templates" />
</phpdocumentor>
```

After you've created the configuration file, you can now run phpdoc without arguments, then run the php script to fix the generated files.

```bash
./vendor/bin/phpdoc && php ./vendor/ramynasr/phpdoc-markdown/bin/html-to-md.php --dir="docs"
```

Or, you can add it to your composer.json scripts section, this is how I do it.

```json

"scripts": {
    "phpdoc": [
        "export COMPOSER_PROCESS_TIMEOUT=9000",
        "@phpdoc-run",
        "@phpdoc-fix"
    ],
    "phpdoc-run": "vendor/bin/phpdoc -v",
    "phpdoc-fix": "php vendor/ramynasr/phpdoc-markdown/bin/html-to-md.php"
}
```

Then run:
```bash
composer phpdoc
```
