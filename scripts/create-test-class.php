<?php

$arguments = array_slice($argv, 1);

function execute (array $attributes) {
    $template = file_get_contents(__DIR__ . '/templates/test-class');
    $path = __DIR__ . "/../test/src/{$attributes['CLASS_NAME']}Test.php";

    foreach ($attributes as $key => $value) {
        $template = str_replace("<{$key}>", $value, $template);
    }

    if (!is_file($path)) {
        file_put_contents($path, $template);
    }
}

$replaceWith = [
    'CLASS_NAME' => $arguments[0],
];

execute($replaceWith);
