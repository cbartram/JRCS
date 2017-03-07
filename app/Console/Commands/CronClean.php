<?php

namespace App\Console\Commands;

use App\Calendar;
use App\EventLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CronClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periodically cleans & removes excess data from the Heroku database to manage storage space.';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Cleaning Database...');

        /*
         * Get all events from calendar_events and event_log older than the current month - 2 months
         * Note: the number of rows for both CalendarEvents & EventLog tables must be kept in sync otherwise the JS will find null values for Calendar events and
         * fail to load any events onto the calendar
         */
        $calendarEvents = Calendar::where('created_at', '<', Carbon::now()->subMonths(2));
        $eventLog = EventLog::where('created_at', '<', Carbon::now()->subMonths(2));

        $calendarEvents->delete();
        $eventLog->delete();

        $this->info('Database has been cleaned successfully.');
        $this->info('Deleted ' . $calendarEvents->count() . ' Calendar items.');
        $this->info('Deleted ' . $eventLog->count() . ' Logged Events');

    }
}
