<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

class ServeCommand extends Command
{
    protected $signature = 'serve';
    protected $description = 'Start Lumen server on localhost:9000';

    public function handle()
    {
        $phpBinary = (new PhpExecutableFinder())->find();
        $command = ["$phpBinary", "-S", "localhost:9000", "-t", "public"];

        $this->info("Starting server on http://localhost:9000");

        $process = new Process($command);
        $process->setTimeout(null); // Bez limitu czasu
        $process->setIdleTimeout(null);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
