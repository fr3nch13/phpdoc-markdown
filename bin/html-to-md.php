<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols
/**
 * Used to rename html files to md files.
 * Also fixes the urls in the md files.
 */

/**
 * Lists the generated documentation files.
 *
 * @param string $dir     The starting point to search.
 * @param array       $results The results placed in this array.
 *
 * @return array the list of files.
 */
function getDirContents(string $dir, array $results = []): array
{
    $files = scandir($dir);

    foreach ($files as $file) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $file);
        if (!is_dir($path)) {
            if (!preg_match('/\.html$/', $path)) {
                continue;
            }
            $results[] = $path;
        } elseif ($file !== '.' && $file !== '..') {
            $results += getDirContents($path, $results);
        }
    }

    return $results;
}

function get_target_dir(): string {
	$target = getcwd();
	$options = getopt('d::', ['dir::']);
	$option = $options['d'] ?? $options['dir'] ?? null;

	if (empty($option)) {
		return $target;
	}

	if ($option[0] !== '/') {
		// relative path
		$target .= '/' . $option;
	}

	if (!is_readable($target) || !is_dir($target)) {
		echo sprintf('The directory provided (%s) is not a valid target directory.', $target) . PHP_EOL;
		echo 'This script requires a target working directory that can be provided using --dir="/path/to/docs"' . PHP_EOL;
		exit(1);
	}

	return $target;
}

$target = get_target_dir();
$files = getDirContents($target);

foreach ($files as $file) {
    echo sprintf('Processing %s...', $file);
    $content = file_get_contents($file);
    // .html)
    $content = str_replace('.html)', '.md)', $content);
    // .html#property_id)
    $content = preg_replace('/\.html(\#[\w\_]+)\)/', '.md$1)', $content);
    file_put_contents($file, $content);
    $mdFilePath = preg_replace('/\.html$/', '.md', $file);
    rename($file, $mdFilePath);
	echo 'DONE' . PHP_EOL;
}
