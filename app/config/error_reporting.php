<?php
/**
 * Config-file for development mode with error reporting.
 *
 */

/**
 * Set the error reporting.
 *
 */




/**
 * Default exception handler.
 *
 */
set_exception_handler(function ($e) {
    echo "Anax: Uncaught exception: <p>"
        . $e->getMessage()
        . "</p><p>Code: "
        . $e->getCode()
        . "</p><pre>"
        . $e->getTraceAsString()
        . "</pre>";
});
