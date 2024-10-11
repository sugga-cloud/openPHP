<?php
function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        return false; // Return false if the file does not exist
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parse the line and split into key and value
        list($key, $value) = explode('=', $line, 2);
        
        // Trim whitespace and assign to $_ENV
        $_ENV[trim($key)] = trim($value);
    }

    return true; // Return true if loading was successful
}

// Load the .env file

loadEnv( '.env');
