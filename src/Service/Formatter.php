<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Commission;

class Formatter
{
    public static function display(array $commissions): string
    {
        $values = array_map(function (Commission $commission) {
            return $commission->getValue();
        }, $commissions);

        return implode(PHP_EOL, $values) . PHP_EOL;
    }
}