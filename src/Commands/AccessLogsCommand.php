<?php

namespace Maize\AccessLogs\Commands;

use Illuminate\Console\Command;

class AccessLogsCommand extends Command
{
    public $signature = 'laravel-access-logs';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
