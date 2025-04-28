<?php

namespace App\Console\Commands;

use App\CallRailService\Facades\CallRail;
use App\Models\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Console\Command;

class CallRailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'callrail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $lead;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching CallRail data started...');

        if(!$sources = $this->get_source()) {
            return false;
        }

        $lead = Lead::select('start_time')->orderBy('start_time', 'desc')->first();

        if(!$lead) {
            $start_date = date('Y-01-01');
        } else {
            $start_date = date('Y-m-d', strtotime($lead->start_time));
        }

        foreach($sources as $source) {
            $this->call_api($source, $start_date);
        }

        $this->info('Data fetched and saved successfully.');
    }

    public function get_source()
    {
        $data = CallRail::source()->paginate(20);
        $this->info('Fetching source...');

        $extracted = [];
        if($data['trackers']) {

            $this->info('Fetched all sources...');

            $extracted = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name']
                ];
            }, $data['trackers']);

        } else {
            $this->info('Source is not found.');
        }

        return $extracted;
    }

    public function call_api($source, $start_date, $offset = 0)
    {
        $this->info('CallRail api started...');

        $end_date = date('Y-m-d');

        $data = CallRail::calls()->where(
            [
                'start_date'=> $start_date,
                'end_date' => date('Y-m-d'),
                'order' => 'desc',
                'tracker_id' => $source['id'],
            ]
        )->paginate(50, $offset);

        if(!$data['calls']) {
            $this->info("CallRail api has not data from $start_date to $end_date.");
            return false;
        }

        $this->info("CallRail api has data fetched from $start_date to $end_date");

        foreach($data['calls'] as $item) {
            $hasLead = Lead::where('lead_id', $item['id'])->exists();
            if(!$hasLead) {
                $this->insert($item, $source);
            }
        }

        sleep(60);

        return $this->call_api($source, $start_date, $offset++);
    }


    public function insert($data, $source)
    {
        $this->info("CallRail api data started insert in Lead.");

        $data = Lead::create([
            'lead_id' => $data['id'],
            'start_time' => date('Y-m-d H:i:s', strtotime($data['start_time'])),
            'name' => $data['customer_name'],
            'phone' => $data['customer_phone_number'],
            'city' => $data['customer_city'],
            'state' => $data['customer_state'],
            'status' => LeadStatus::WaitingOnIntakeStatus->value,
            'source' => $source['name'],
        ]);

        if($data) {
            $this->info("CallRail api data inserted in Lead.");
        } else {
            $this->info("CallRail api data inserted Failed");
        }
        return $data;
    }
}
