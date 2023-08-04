<?php
/**
 * Class Languages
 *
 * This class handles language related functionality in the Pretix_Widget plugin.
 *
 * @package Pretix_Widget
 * @version 1.0.00
 */

namespace Pretix_Widget;

class Languages extends Base {
    public $debug = false;
    private $parent;
    private $list = [];

    /**
     * Languages constructor.
     *
     * @param object $parent The parent object of the Languages class.
     *
     * @since 1.0.00
     */
    public function __construct($parent) {
        $this->parent = $parent;
        $this->debug  = $this->parent->debug;
    }

    /**
     * Get the language data for the given language code.
     *
     * @param string $code The language code to get the data for.
     *
     * @return mixed The language data as an associative array or null if not found.
     * @since 1.0.00
     */
    public function get(string $code): mixed {
        $filtered = array_filter($this->get_list(), function ($lang) use ($code) {
            return $lang['code'] === $code;
        });

        $result = reset($filtered); // Get the first element of the filtered array

        return $result ?: null;
    }

    /**
     * Get the list of available languages.
     *
     * @return array The list of available languages.
     * @since 1.0.00
     */
    public function get_list(): array {
        return empty($this->list) ? $this->get_file() : $this->list;
    }

    /**
     * Read the language data from the JSON file.
     *
     * @return array The list of available languages.
     * @since 1.0.00
     */
    private function get_file(): array {
        $file = $this->get_path('includes/languages/lang.json');
        if (file_exists($file)) {
            $this->list = json_decode(file_get_contents($file), true);
            $this->list = array_filter($this->list, function ($lang) {
                return $lang['supported'] !== false;
            });
        }

        return $this->list;
    }

    /**
     * Get the language data for the given locale.
     *
     * @param string $locale The locale to get the language data for.
     *
     * @return mixed The language data as an associative array or null if not found.
     * @since 1.0.00
     */
    public function get_by_locale(string $locale): mixed {
        $filtered = array_filter($this->get_list(), function ($lang) use ($locale) {
            return $lang['locale'] === $locale;
        });

        $result = reset($filtered); // Get the first element of the filtered array

        return $result ?: null;
    }

    /**
     * Get the current language.
     *
     * @return string The current language as a locale code.
     * @since 1.0.00
     */
    public function get_current(): string {
        return get_locale();
    }
}
