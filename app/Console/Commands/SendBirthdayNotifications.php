<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Notifications\BirthdayNotification;
use Illuminate\Support\Facades\Notification;

class SendBirthdayNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:birthday';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday notifications to all members at 12:00 AM daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get today's date in "m-d" format
        $today = now()->format('m-d');

        // Find members whose DOB matches today
        $birthdayMembers = Member::whereRaw([
            'DOB' => ['$regex' => ".*-$today"] // Match date with MM-DD
        ])->get();

        // If there are birthdays today
        if ($birthdayMembers->count() > 0) {
            // Get all members
            $allMembers = Member::all();

            // Loop through each birthday member
            foreach ($birthdayMembers as $birthdayMember) {
                $message = "Today is " . $birthdayMember->Name . "'s birthday! 🎉";

                // Send notification to all members
                Notification::send($allMembers, new BirthdayNotification($message));
            }

            $this->info('Birthday notifications sent successfully.');
        } else {
            $this->info('No birthdays today.');
        }
    }
}
