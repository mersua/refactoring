<?php

use App\Model\Commission;
use App\Service\Executor;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

if (!isset($argv[1])) {
    echo sprintf('Input file argument was not provided%s', PHP_EOL);
    exit(1);
}

$inputFile = (strpos($argv[1], '/') === 0) ? $argv[1] : __DIR__ . '/data/' . $argv[1];

if (!is_file($inputFile)) {
    echo sprintf('Input filename is not a regular file: %s%s', $inputFile, PHP_EOL);
    exit(1);
}

try {
    (new Dotenv())->load(__DIR__ . '/.env');

    $commissions = array_map(function (Commission $commission) {
        return $commission->getValue();
    }, Executor::execute($inputFile));

    echo implode(PHP_EOL, $commissions) . PHP_EOL;
    exit(0);
} catch (\Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}