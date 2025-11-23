<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    'chart.js/auto' => [
        'version' => '3.9.1',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'stimulus-use' => [
        'version' => '0.52.2',
    ],
    'sweetalert2' => [
        'version' => '11.10.6',
    ],
    'stimulus-reactive' => [
        'version' => '1.0.0',
    ],
    'chart.js' => [
        'version' => '3.9.1',
    ],
    'idb' => [
        'version' => '8.0.3',
    ],
];
