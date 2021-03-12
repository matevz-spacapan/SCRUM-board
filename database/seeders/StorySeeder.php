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
            'title' => 'Dodajanje uporabniških zgodb',
            'project_id' => 1,
            'description' => "Produktni vodja in skrbnik metodologije lahko vnašata nove uporabniške zgodbe v že obstoječ projekt.\nZa vsako zgodbo lahko določita njeno ime, besedilo, sprejemne teste, prioriteto (must have, could have, should have, won't have this time) in poslovno vrednost.",
            'tests' => "Preveri regularen potek.\nPreveri podvajanje imena uporabniške zgodbe.\nPreveri ustrezno določitev prioritete uporabniške zgodbe.\nPreveri za neregularen vnos poslovne vrednosti.",
            'priority' => random_int(1, 4),
            'business_value' => random_int(1, 10)
        ]);
        Story::create([
            'title' => 'Pregledovanje in spreminjanje časovnega poteka dela',
            'project_id' => 1,
            'description' => "Član skupine lahko pregleduje in dopolnjuje preglednico svojega dela na nalogah v tekočem dnevu in v preteklih dnevih.\nLahko popravlja število vloženih ur na posamezni nalogi za posamezni dan. Prav tako lahko po svoji presoji določa potrebno število ur za dokončanje naloge.",
            'tests' => "Preveri regularen potek.\nPreveri veljavnost vnesenega časa.\nPreveri za zgodbo, ki je razvijalec ni sprejel.\nPreveri za že zaključene zgodbe.",
            'priority' => random_int(1, 4),
            'business_value' => random_int(1, 10)
        ]);
        Story::create([
            'title' => 'Ustvarjanje novega Sprinta',
            'project_id' => 2,
            'description' => "Skrbnik metodologije lahko ustvari nov Sprint. Določi mu začetni in končni datum ter pričakovano hitrost.",
            'tests' => "Preveri običajen potek: dodaj nov Sprint, določi mu začetni in končni datum (v prihodnosti) in nastavi začetno hitrost.\nPreveri za primer, ko je končni datum pred začetnim.\nPreveri za primer, ko je začetni datum v preteklosti.\nPreveri za neregularno vrednost hitrosti Sprinta.\nPreveri za primer, ko se dodani Sprint prekriva s katerim od obstoječih.",
            'priority' => random_int(1, 4),
            'business_value' => random_int(1, 10)
        ]);
    }
}
