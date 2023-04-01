<?php
/**
 * Autoloader class for the Challenge Plugin.
 *
 * @package ChallengePlugin
 */

namespace ChallengePlugin;

defined( 'ABSPATH' ) || exit;

/**
 * Autoloader class.
 */
class Autoloader {

    /**
     * Register the autoloader.
     *
     * @param string $namespace The plugin namespace.
     * @param string $dir The directory to autoload from.
     */
    public static function register( $namespace, $dir ) {
        spl_autoload_register( array( __CLASS__, 'autoload' ) );
        self::add_namespace( $namespace, $dir );
    }

    /**
     * Autoload the class.
     *
     * @param string $class_name The class name to autoload.
     */
    public static function autoload( $class_name ) {
        $namespaces = self::get_namespaces();

        foreach ( $namespaces as $namespace => $dir ) {
            if ( strpos( $class_name, $namespace . '\\' ) !== 0 ) {
                continue;
            }
            // Remove the 'ChallengePlugin\' namespace prefix and convert class name to file name.
            $file_name = str_replace( 'ChallengePlugin\\', '', $class_name );
            $file_name = str_replace( '\\', DIRECTORY_SEPARATOR, $file_name );
            $file_name = str_replace( '_', '-', $file_name );
            $file_name = '/class-' . strtolower( $file_name ) . '.php';

            // Build the full path to the file.
            $file_path = $dir . $file_name;

            // Include the file if it exists.
            if ( file_exists( $file_path ) ) {
                include_once $file_path;
            }
        }
    }

    /**
     * Add a namespace to the autoloader.
     *
     * @param string $namespace The plugin namespace.
     * @param string $dir The directory to autoload from.
     */
    public static function add_namespace( $namespace, $dir ) {
        $namespaces = self::get_namespaces();
        $namespaces[ $namespace ] = $dir;
        self::set_namespaces( $namespaces );
    }

    /**
     * Get the list of registered namespaces.
     *
     * @return array The list of namespaces.
     */
    public static function get_namespaces() {
        $namespaces = get_option( 'challenge_plugin_namespaces', array() );
        return $namespaces;
    }

    /**
     * Set the list of registered namespaces.
     *
     * @param array $namespaces The list of namespaces.
     */
    public static function set_namespaces( $namespaces ) {
        update_option( 'challenge_plugin_namespaces', $namespaces );
    }
}

// Register the Challenge Plugin namespace.
Autoloader::register( 'ChallengePlugin', CHALLENGE_PLUGIN_DIR . 'includes' );
