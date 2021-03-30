<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Story::create([
            'title' => 'Make a route',
            'project_id' => 1,
            'description' => "The user can select a start and end point and a route is calculated and shown between the two points.",
            'tests' => "Check validity of each point.\nDisplay the shortest route.\nCheck that invalid points show an error.",
            'priority' => 1,
            'business_value' => 10,
            'sprint_id' => 2,
            'hash' => 1,
            'time_estimate' => 7
        ]);
        Story::create([
            'title' => 'Display map',
            'project_id' => 1,
            'description' => "Display the map with an initial zoom level.",
            'tests' => "Check the initial display level is used.\nAllow scrolling out.\nAllow scrolling in.",
            'priority' => 1,
            'business_value' => 10,
            'sprint_id' => 2,
            'accepted' => true,
            'hash' => 2,
            'time_estimate' => 9
        ]);
        Story::create([
            'title' => 'Address search',
            'project_id' => 1,
            'description' => "The user can search for an address. It is then displayed on the map.",
            'tests' => "Check validity of search query.\nCheck the correct address is shown.\nCheck what happens when an invalid address is given.",
            'priority' => 2,
            'business_value' => 8,
            'sprint_id' => 4,
            'time_estimate' => 5
        ]);
        Story::create([
            'title' => 'Parse robots.txt',
            'project_id' => 2,
            'description' => "When the crawler visits the web page for the first time, it should parse the robots.txt file.",
            'tests' => "Check what happens when page is visited for the first time.\nCheck what happens on any other visit.\nCheck the file is parsed correctly.\nCheck if no such file exists.",
            'priority' => 3,
            'business_value' => 2
        ]);
    }
}
