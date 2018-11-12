<?php

namespace App\Console\Commands;

use App\Notifications\ExpiredMembership;
use App\VitalGym\Entities\Customer;
use Illuminate\Console\Command;

class SendExpiredMembershipNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:customer-membership-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to customers whose memberships expired today';

    /**
     * @var Customer
     */
    public $customer;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $customers = Customer::membershipExpiredToday();

        if ($customers) {
            $customers->each(function ($customer) {
                $customer->notify(new ExpiredMembership);
            });
        }
    }
}
