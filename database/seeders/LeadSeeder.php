<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $source = ['LSA - Philadelphia','Google Ads'];
        $lead_tag = ['Signed', 'Pending','Referred'];
        $rating = ['Very satisfied', 'Neither satisfied nor dissatisfied','Somewhat satisfied','Somewhat dissatisfied'];
        $note_strike_first = ['Connected', 'Voicemail', 'Test Call', 'Missed Call'];
        $status = ['Lead Rated', 'Waiting On Intake Status','Credited','Lead Not Rated'];

        foreach(range(0,10) as $item) {
            Lead::create([
                'start_time' => date('Y-m-d H:i:s'),
                'name' => fake()->name(),
                'phone' => rand(111111111,999999999),
                'city' => fake()->city(),
                'state' => fake()->city(),
                'source' => $source[array_rand($source)],
                'lead_tag' => $lead_tag[array_rand($lead_tag)],
                'qualification_status' => array_rand(['Up', 'Down']),
                'rating' => $rating[array_rand($rating)],
                'note' => fake()->text(),
                'note_strike_first' => $note_strike_first[array_rand($note_strike_first)],
                'action' => fake()->text(),
                'status' => $status[array_rand($status)],
            ]);
        }
    }
}
