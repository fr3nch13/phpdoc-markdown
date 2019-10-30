# phpDocumentor markdown template

[phpDocumentor template](http://www.phpdoc.org/docs/latest/getting-started/changing-the-look-and-feel.html) that generates Markdown documentation.

This is basically a markdown version of phpDocumentor's Clean template.

The main use-case for this template is to generate simple and nice looking usage documentation, that can then be published on GitHub/GitLab.

For example, a small library can document it's public API in DocBlock comments, use this template to generate the Markdown documentation and then commit it to GitHub with the library to easily create a nice looking documentation for other developers to see.

## Installation

Install with composer:

```bash
composer require fr3nch13/phpdoc-markdown
```

## Usage

Run phpDocumentor and set template as `vendor/fr3nch13/phpdoc-markdown/data/templates/markdown`.

This requires the usage of the `phpdoc.xml` file as phpDocumentor only generates html files, and they need to be changed to md files, and the links in the generated templates need to be modified.
This is done using a php script in the bin/directory that uses the `phpdoc.xml` file to know where the generated templates are located.

**Example using configuration file:**

Add a file called `phpdoc.xml` with the following content to the root of your project and invoke the `phpdoc` command without arguments. Modify the configuration to suit your project.

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<phpdoc>
    <title>My Project Documentation</title>
    <parser>
        <target>build</target>
    </parser>
    <transformer>
        <target>docs</target>
    </transformer>
    <transformations>
        <template name="vendor/fr3nch13/phpdoc-markdown/data/templates/markdown" />
    </transformations>
    <files>
        <directory>src</directory>
        <ignore>test/*</ignore>
    </files>
</phpdoc>
```

After you've created the phpdoc.xml, you can now run phpdoc without arguments, then run the php script to fix the generated files.

```bash
$ vendor/bin/phpdoc && php vendor/fr3nch13/phpdoc-markdown/bin/fixHtmltoMd.php
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
    "phpdoc-fix": "php vendor/fr3nch13/phpdoc-markdown/bin/fixHtmlToMd.php"
}
```

Then run:
```bash
$ composer phpdoc
```

More information about [configuring phpDocumentor](http://www.phpdoc.org/docs/latest/references/configuration.html).
