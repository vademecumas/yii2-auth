<?php

namespace vademecumas\auth\helpers;

class Dir
{
    public static function copy(string $source, string $destination, $mode = 0777): bool
    {
        $isSuccess = false;

        // if $mode is neither an integer nor false, short-circuit
        if (!is_integer($mode) && $mode !== false) {
            throw new \InvalidArgumentException(
                "mode should be an octal integer or false"
            );
        }

        // if $source does not exist or is not readable, short-circuit
        if (!is_dir($source) || !is_readable($source)) {
            throw new \InvalidArgumentException(
                "source should be an existing, readable directory"
            );
        }

        // if $destination does not exist and we're allowed to create it
        if (!file_exists($destination) && is_integer($mode)) {
            mkdir($destination, $mode, true);
        }

        // if $destination directory does not exist or is not writable, short-circuit
        if (!is_dir($destination) || !is_writable($destination)) {
            throw new \InvalidArgumentException(
                "destination should be an existing, writable directory " .
                "(or mode should be an integer)"
            );
        }

        // let's get started
        $isSuccess = false;

        // open the source directory
        $sourceDir = opendir($source);

        // loop through the entities in the source directory
        $entity = readdir($sourceDir);
        while ($entity !== false) {
            // if not the special entities "." and ".."
            if ($entity != '.' && $entity != '..') {
                // if the file is a dir
                if (is_dir($source . DIRECTORY_SEPARATOR . $entity)) {
                    // recursively copy the dir
                    $isSuccess = self::copy(
                        $source . DIRECTORY_SEPARATOR . $entity,
                        $destination . DIRECTORY_SEPARATOR . $entity,
                        $mode
                    );
                } else {
                    // otherwise, just copy the file
                    $isSuccess = copy(
                        $source . DIRECTORY_SEPARATOR . $entity,
                        $destination . DIRECTORY_SEPARATOR . $entity
                    );
                }
                // if an error occurs, stop
                if (!$isSuccess) {
                    break;
                }
            } else {
                // there was nothing to remove
                // set $isSuccess to true in case the directory is empty
                // if it's not empty, $isSuccess will be overwritten on the next iteration
                $isSuccess = true;
            }
            // advance to the next file
            $entity = readdir($sourceDir);
        }

        // close the source directory
        closedir($sourceDir);

        return $isSuccess;
    }
}