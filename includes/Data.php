<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * Class Data
 * This class handles reading data files with localization support.
 * It attempts to load a file based on the current language code,
 * falling back to English if the localized file is not available.
 * 
 * @package FAU\ORGA\Breadcrumb
 */
final class Data
{
    /** Path to the data directory within the plugin */
    const DATA_PATH = 'data/';

    /**
     * Reads and includes a data file based on the current language.
     * Falls back to English if the localized file is not found.
     * 
     * @param string $filename The base name of the data file (without language suffix and .php extension).
     *                         Example: 'fau-orga' or 'fau-elemental-orga'.
     * @return array The data array from the included file, or an empty array if the file is not found or invalid.
     */
    public static function read($filename = '')
    {
        $file = self::getFilePath($filename);
        if (is_readable($file)) {
            $data = require $file;
            return is_array($data) ? $data : [];
        }
        return [];
    }

    /**
     * Constructs the file path for the data file based on the current locale.
     * 
     * @param string $filename The base name of the data file.
     * @return string The full path to the data file.
     */
    private static function getFilePath($filename)
    {
        $langCode = Locale::getLangCode();
        $file = plugin()->getPath(self::DATA_PATH) . $filename . '-' . $langCode . '.php';
        if (!is_readable($file)) {
            $file = plugin()->getPath(self::DATA_PATH) . $filename . '-en.php';
        }
        return $file;
    }
}
