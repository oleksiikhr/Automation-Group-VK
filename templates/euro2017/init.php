<?php require_once __DIR__ . '/../../public/run.php';

use \tmp\euro2017\Euro;

QB::query('CREATE TABLE IF NOT EXISTS ' . Euro::TABLE . ' (
	id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    song VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    round INT NOT NULL,
    poll_id INT DEFAULT 0 NOT NULL,
    rating INT DEFAULT 0 NOT NULL,
    isFinal BOOLEAN NOT NULL,
    final_pos TINYINT NOT NULL,
    final_poll INT NOT NULL,
    music_id INT NOT NULL
    time TIMESTAMP on update CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP()
)');

QB::table(Euro::TABLE)->insert([
    [
        'name'    => 'Robin Bengtsson',
        'song'    => 'I Can\'t Go On',
        'country' => 'Sweden',
        'round'   => '1'
    ],
    [
        'name'    => 'Tamara Gachechiladze',
        'song'    => 'Keep the Faith',
        'country' => 'Georgia',
        'round'   => '1'
    ],
    [
        'name'    => 'Isaiah',
        'song'    => 'Don\'t Come Easy',
        'country' => 'Australia',
        'round'   => '1'
    ],
    [
        'name'    => 'Lindita',
        'song'    => 'World',
        'country' => 'Albania',
        'round'   => '1'
    ],
    [
        'name'    => 'Blanche',
        'song'    => 'City Lights',
        'country' => 'Belgium',
        'round'   => '1'
    ],
    [
        'name'    => 'Slavko Kalezić',
        'song'    => 'Space',
        'country' => 'Montenegro',
        'round'   => '1'
    ],
    [
        'name'    => 'Norma John',
        'song'    => 'Blackbird',
        'country' => 'Finland',
        'round'   => '1'
    ],
    [
        'name'    => 'Dihaj',
        'song'    => 'Skeletons',
        'country' => 'Azerbaijan',
        'round'   => '1'
    ],
    [
        'name'    => 'Salvador Sobral',
        'song'    => 'Amar Pelos Dois',
        'country' => 'Portugal',
        'round'   => '1'
    ],

    [
        'name'    => 'Demy',
        'song'    => 'This Is Love',
        'country' => 'Greece',
        'round'   => '1'
    ],
    [
        'name'    => 'Kasia Moś',
        'song'    => 'Flashlight',
        'country' => 'Poland',
        'round'   => '1'
    ],
    [
        'name'    => 'Sunstroke Project',
        'song'    => 'Hey, Mamma!',
        'country' => 'Moldova',
        'round'   => '1'
    ],
    [
        'name'    => 'Svala',
        'song'    => 'Paper',
        'country' => 'Iceland',
        'round'   => '1'
    ],
    [
        'name'    => 'Martina Bárta',
        'song'    => 'My Turn',
        'country' => 'Czech Republic',
        'round'   => '1'
    ],
    [
        'name'    => 'Hovig',
        'song'    => 'Gravity',
        'country' => 'Cyprus',
        'round'   => '1'
    ],
    [
        'name'    => 'Artsvik',
        'song'    => 'Fly with Me',
        'country' => 'Armenia',
        'round'   => '1'
    ],
    [
        'name'    => 'Omar Naber',
        'song'    => 'On My Way',
        'country' => 'Slovenia',
        'round'   => '1'
    ],
    [
        'name'    => 'Triana Park',
        'song'    => 'Line',
        'country' => 'Latvia',
        'round'   => '1'
    ],
]);

QB::table(Euro::TABLE)->insert([
    [
        'name'    => 'Tijana Bogićević',
        'song'    => 'In Too Deep',
        'country' => 'Serbia',
        'round'   => '2'
    ],
    [
        'name'    => 'Nathan Trent',
        'song'    => 'Running on Air',
        'country' => 'Austria',
        'round'   => '2'
    ],
    [
        'name'    => 'Jana Burčeska',
        'song'    => 'Dance Alone',
        'country' => 'Macedonia',
        'round'   => '2'
    ],
    [
        'name'    => 'Claudia Faniello',
        'song'    => 'Breathlessly',
        'country' => 'Malta',
        'round'   => '2'
    ],
    [
        'name'    => 'Ilinca and Alex Florea',
        'song'    => 'Yodel It!',
        'country' => 'Romania',
        'round'   => '2'
    ],
    [
        'name'    => 'O\'G3NE',
        'song'    => 'Lights and Shadows',
        'country' => 'Netherlands',
        'round'   => '2'
    ],
    [
        'name'    => 'Joci Pápai',
        'song'    => 'Origo',
        'country' => 'Hungary',
        'round'   => '2'
    ],
    [
        'name'    => 'Anja',
        'song'    => 'Where I Am',
        'country' => 'Denmark',
        'round'   => '2'
    ],
    [
        'name'    => 'Brendan Murray',
        'song'    => 'Dying to Try',
        'country' => 'Ireland',
        'round'   => '2'
    ],

    [
        'name'    => 'V. Monetta and J. Wilson',
        'song'    => 'Spirit of the Night',
        'country' => 'San Marino',
        'round'   => '2'
    ],
    [
        'name'    => 'Jacques Houdek',
        'song'    => 'My Friend',
        'country' => 'Croatia',
        'round'   => '2'
    ],
    [
        'name'    => 'JOWST',
        'song'    => 'Grab the Moment',
        'country' => 'Norway',
        'round'   => '2'
    ],
    [
        'name'    => 'Timebelle',
        'song'    => 'Apollo',
        'country' => 'Switzerland',
        'round'   => '2'
    ],
    [
        'name'    => 'Naviband',
        'song'    => 'Story of My Life',
        'country' => 'Belarus',
        'round'   => '2'
    ],
    [
        'name'    => 'Kristian Kostov',
        'song'    => 'Beautiful Mess',
        'country' => 'Bulgaria',
        'round'   => '2'
    ],
    [
        'name'    => 'Fusedmarc',
        'song'    => 'Rain of Revolution',
        'country' => 'Lithuania',
        'round'   => '2'
    ],
    [
        'name'    => 'Koit Toome and Laura',
        'song'    => 'Verona',
        'country' => 'Estonia',
        'round'   => '2'
    ],
    [
        'name'    => 'IMRI',
        'song'    => 'I Feel Alive',
        'country' => 'Israel',
        'round'   => '2'
    ],
]);

QB::table(Euro::TABLE)->insert([
    [
        'name'    => 'Francesco Gabbani',
        'song'    => 'Occidentali\'s Karma',
        'country' => 'Italy',
        'isFinal' => true
    ],
    [
        'name'    => 'Alma',
        'song'    => 'Requiem',
        'country' => 'France',
        'isFinal' => true
    ],
    [
        'name'    => 'Levina',
        'song'    => 'Perfect Life',
        'country' => 'Germany',
        'isFinal' => true
    ],
    [
        'name'    => 'Manel Navarro',
        'song'    => 'Do It for Your Lover',
        'country' => 'Spain',
        'isFinal' => true
    ],
    [
        'name'    => 'Lucie Jones',
        'song'    => 'Never Give Up on You',
        'country' => 'United Kingdom',
        'isFinal' => true
    ],
    [
        'name'    => 'O.Torvald',
        'song'    => 'Time',
        'country' => 'Ukraine',
        'isFinal' => true
    ],
]);
