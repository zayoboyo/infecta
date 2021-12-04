<?php
/**
 * Infecta - web browser based game about solving RNA of virsues and creating mRNA vaccines.
 *
 * @package Infecta
 * @author Peter Zajicek <peter.zajicek@yahoo.com>
 */
return [

    // Maximum limit for unsolved diseases
    'maximum_diseases' => (int)env('MAXIMUM_DISEASES', 20),

    // New disease spawn chance
    'disease_spawn_chance' => (int)env('DISEASE_SPAWN_CHANCE', 20),

    /**
     * Minimum difficulty for solving RNA of virus.
     * This is minimum time in milliseconds that takes to solve one nucleotide.
     **/
    'minimum_difficulty' => (int)env('MINIMUM_DIFFICULTY', 50),

    /**
     * Maximum difficulty for solving RNA of virus.
     * This is maximum time in milliseconds that takes to solve one nucleotide.
     **/
    'maximum_difficulty' => (int)env('MAXIMUM_DIFFICULTY', 500),
];
