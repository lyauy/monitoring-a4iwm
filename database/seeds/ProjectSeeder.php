<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$projects = [
			[
	            'name' => 'Gestion de trucs',
	            'client' => 'Blizzard',
	            'client_addr' => '10 rue random, 85285 random',
	            'progress' => 80,
	            'deadline' => "2020-04-11",
	            'total_price' => 85000,
	            'description' => 'test',
	        ],
		    [
	            'name' => 'Générateur de poneys',
	            'client' => 'Mon petit poney',
	            'client_addr' => '10 rue poney, 85285 poneyland',
	            'progress' => 70,
	            'deadline' => "2020-04-17",
	            'total_price' => 10,
	            'description' => 'test',
	        ],
		    [
	            'name' => 'eazdsqqgdfg',
	            'client' => 'aze',
	            'client_addr' => '15 rue de izelsjf, 89654 ekooe',
	            'progress' => 70,
	            'deadline' => "2020-05-30",
	            'total_price' => 10000,
	            'description' => 'test',
	        ],
		    [
	            'name' => 'projet en carton',
	            'client' => 'Mon petit carton',
	            'client_addr' => '10 rue poney, 85285 poneyland',
	            'progress' => 10,
	            'deadline' => "2020-04-17",
	            'total_price' => 10500,
	            'description' => 'test',
	        ],
		    [
	            'name' => 'Générateur de chiens',
	            'client' => 'Mon fdsfsdqfqdsfdsq',
	            'client_addr' => '10 rue qsdffsqdfqsd, 85285 pondfsfsddsyland',
	            'progress' => 0,
	            'deadline' => "2020-04-26",
	            'total_price' => 1090,
	            'description' => 'test',
	        ]
    	];
    	
        DB::table('projects')->insert($projects);
    }
}
