<?php

namespace App\Console\Commands\Bunq;

use Illuminate\Console\Command;

/**
 * Class SyncPayments
 * @package App\Console\Commands\Bunq
 */
class SyncPayments extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'bunq:sync-payments {monetaryAccount}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Sync payments';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        \App\Jobs\Bunq\SyncPayments::dispatchNow($this->argument('monetaryAccount'));
    }
}
