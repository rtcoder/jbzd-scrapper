<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    protected $signature = 'serve';
    protected $description = 'Start Lumen server on localhost:9000';

    public function handle(): void
    {
        set_time_limit(0);

        $phpBinary = (new PhpExecutableFinder())->find();
        $command = ["$phpBinary", "-S", "localhost:9000", "-t", "public"];

        $this->info("Starting server on http://localhost:9000");

        $process = new Process($command);
        $process->setTimeout(null); // Bez limitu czasu
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
