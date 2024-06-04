<?php

// Paths to translation files
$elTranslationsPath = '/Users/scrypto/projects/konto/lang/el.json';
$enTranslationsPath = '/Users/scrypto/projects/konto/lang/en.json';
$vueFilesPath = '/Users/scrypto/projects/konto/resources/js';

// Function to extract translation keys from file content
function extractTranslatableFields($fileContent) {
    preg_match_all("/useTrans\('([^\)]+)'\)/", $fileContent, $matches);


    $translations = array_count_values($matches[1]);

    // Fill in missing translation keys with count 0
    foreach ($matches[1] as $key) {
        if (!isset($translations[$key])) {
            $translations[$key] = 0;
        }
    }

    return $translations;
}

// Function to scan directory recursively for .vue files
function scanDirectory($dir, &$results = []) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (pathinfo($path, PATHINFO_EXTENSION) === 'vue') {
                $results[] = $path;
            }
        } elseif ($value !== "." && $value !== "..") {
            scanDirectory($path, $results);
        }
    }

    return $results;
}

// Function to read existing translations from JSON file
function readExistingTranslations($filePath) {
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        return json_decode($content, true);
    }
    return [];
}

// Function to write translations to JSON file
function writeTranslationsToFile($translations, $filePath) {
    ksort($translations);
    file_put_contents($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Translations written to {$filePath}\n";
}

// Main function to execute the script
function main() {
    global $vueFilesPath, $elTranslationsPath, $enTranslationsPath;

    $files = scanDirectory($vueFilesPath);
    $translations = [];

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $fileTranslations = extractTranslatableFields($content);
        print_r($fileTranslations);
        foreach ($fileTranslations as $key => $count) {
            echo($count);
            $translations[$key] = isset($translations[$key]) ? $translations[$key] + $count : $count;
        }
    }

    // Read existing translations
    $elTranslations = readExistingTranslations($elTranslationsPath);
    $enTranslations = readExistingTranslations($enTranslationsPath);

    // Merge with existing translations
    $elTranslations = array_merge($elTranslations, $translations);
    $enTranslations = array_merge($enTranslations, $translations);

    // Write updated translations back to the files
    writeTranslationsToFile($elTranslations, $elTranslationsPath);
    writeTranslationsToFile($enTranslations, $enTranslationsPath);
}

// Run the main function
main();
