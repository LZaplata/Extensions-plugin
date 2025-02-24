<?php

namespace LZaplata\Extensions\Updates;

use Illuminate\Support\Facades\DB;
use October\Rain\Database\Updates\Seeder;
use System\Helpers\Cache;

class SmallContactForm extends Seeder
{
    public function run()
    {
        $value = file_get_contents(__DIR__ . "/../seeds/data/small-contact-form.json");

        DB::table("system_settings")->updateOrInsert([
            "item" => "janvince_smallcontactform_settings"
        ], [
            "value" => json_encode(json_decode($value)),
        ]);

        Cache::clear();
    }
}