<?php

namespace App\Console\Commands\Bunq;

use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Class FixReversals
 * @package App\Console\Commands\Bunq
 */
class FixReversals extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'bunq:fix-reversals {start} {end}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Remove reversals from payments';

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
        // Find all the reversals for the specified start/end
        $reversals = Payment::query()
            ->where('payment_at', '>=', $this->argument('start'))
            ->where('payment_at', '<', $this->argument('end'))
            ->where('sub_type', '=', 'REVERSAL')
            ->get();

        // Create and start a progress bar
        $bar = $this->output->createProgressBar($reversals->count());
        $bar->start();

        foreach ($reversals as $reversal) {
            // Delete the reversal payments
            Payment::query()
                ->where('payment_at', '>=', $this->argument('start'))
                ->where('payment_at', '<', $this->argument('end'))
                ->where('value', "-{$reversal->value}")
                ->where('counterparty_alias', $reversal->counterparty_alias)
//                ->where('description', Str::replaceFirst('Refund: ', '', $reversal->description))
                ->delete();

            $bar->advance();
        }
        $bar->finish();

        $this->info('Done!');
    }
}
