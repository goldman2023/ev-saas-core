<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateAvailableSections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:available_sections {--theme=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate json structure with Available sections for a cetain Namespace';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $theme = $this->option('theme');


    }
}
