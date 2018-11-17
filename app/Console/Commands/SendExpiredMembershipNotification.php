<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\VitalGym\Entities\Customer;
use App\Notifications\ExpiredMembership;
use function Symfony\Component\Console\Tests\Command\createClosure;

class SendExpiredMembershipNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:expired-membership';

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
        $this->info('Sending notifications');
        $customers = Customer::membershipExpiredToday();

        if ($customers->count() <= 0) {
            return $this->info('There are no customers to notify');
        }

        $customers->each(function ($customer) {
            $customer->notify(new ExpiredMembership);
        });

        $this->info('The notification has been sent');
    }
}
