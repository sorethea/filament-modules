<?php

namespace Sorethea\Filament\Support\Config;

class GenerateConfigReader
{
    public static function read(string $value): GeneratorPath
    {
        return new GeneratorPath(config("filament-modules.paths.generator.$value"));
    }
}
