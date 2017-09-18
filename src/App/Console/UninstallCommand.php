<?php

namespace CoreCMF\Corecmf\App\Console;

use Illuminate\Console\Command;

use CoreCMF\Core\Support\Commands\Uninstall;
class UninstallCommand extends Command
{
    protected $uninstall;
    /**
     * The name and signature of the console command.
     *
     * @var string
     * @translator laravelacademy.org
     */
    protected $signature = 'corecmf:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'corecmf uninstall';

    public function __construct(Uninstall $uninstall)
    {
        parent::__construct();
        $this->uninstall = $uninstall;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
