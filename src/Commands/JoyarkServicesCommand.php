<?php

namespace Joyarkdev\JoyarkServices\Commands;

use Illuminate\Console\Command;

class JoyarkServicesCommand extends Command
{
    public $signature = 'joyark-services';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
