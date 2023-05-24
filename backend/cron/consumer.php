<?php

use Ffmpeg\Loader\StringDataLoader;

$config = require __DIR__ . '/../src/Init.php';

$dir = new DirectoryIterator($config['rawDataPath']);

foreach ($dir as $fileInfo) {
    if (!$fileInfo->isDir() || $fileInfo->isDot()) {
        continue;
    }

    echo 'Processing ' . $fileInfo->getPathname(), PHP_EOL;

    $userFile = $fileInfo->getPathname() . '/user-channel.txt';
    $customerFile = $fileInfo->getPathname() . '/customer-channel.txt';

    if (
        !file_exists($userFile) ||
        !file_exists($customerFile)
    ) {
        // TODO log errors / send notifications
        echo 'Missing raw file(s), directory ignored', PHP_EOL;
        continue;
    }

    $errors = [];
    $userDataLoader = new StringDataLoader($config['corrections']);
    $customerDataLoader = new StringDataLoader($config['corrections']);

    try {
        $userDataLoader->loadFromFile($userFile);
    } catch (Throwable $t) {
        $errors[] = $t;
    }

    try {
        $customerDataLoader->loadFromFile($customerFile);
    } catch (Throwable $t) {
        $errors[] = $t;
    }

    /**
     * This would depend on the loader used, and of course the business requirements.
     * If it is mission critical, invalid files could be even sent for manual check.
     * Current one tries to correct the errors according to config settings.
     * Which loader to use could be added to config too.
     */
    if (
        $errors /* ||
        $customerDataLoader->getErrors() ||
        $userDataLoader->getErrors() */
    ) {
        // TODO log errors / send notifications
        foreach ($errors as $error) {
            echo $error->getMessage(), PHP_EOL;
        }
        echo 'Directory ignored', PHP_EOL;
        continue;
    }

    /**
     * Now cache parsed data in the desired format/storage.
     * Could be Redis, MariaDB (or both), etc.
     *
     * The below is quite basic implementation which
     * assumes file operations will be successful :)
     */
    if (!is_dir($config['parsedDataPath'] . '/' . $fileInfo->getFilename())) {
        mkdir($config['parsedDataPath'] . '/' . $fileInfo->getFilename(), 0755, true);
    }

    file_put_contents(
        $config['parsedDataPath'] . '/' . $fileInfo->getFilename() . '/user-channel.txt',
        '<?php return ' . var_export($userDataLoader->getDataPoints(), true) . ';'
    );

    file_put_contents(
        $config['parsedDataPath'] . '/' . $fileInfo->getFilename() . '/customer-channel.txt',
        '<?php return ' . var_export($customerDataLoader->getDataPoints(), true) . ';'
    );

    // TODO Flag parsed directories as done or remove them if not needed.

    echo 'Done', PHP_EOL;
}
