<?php

namespace LZaplata\Extensions\Updates;

use Illuminate\Support\Facades\Log;
use JanVince\SmallGDPR\Models\CookiesSettings;
use October\Rain\Database\Updates\Seeder;
use October\Rain\Parse\Yaml;

class SmallGdpr extends Seeder
{
    public function run()
    {
        $content = file_get_contents(__DIR__ . "/../seeds/data/small-gdpr.yaml");
        $content = (new Yaml())->parse($content);

        try {
            CookiesSettings::set($content);
        } catch (\Exception $exception) {
            Log::error("Error while importing Small GDPR data. Message: " . $exception->getMessage());
        }

//        DB::table("system_settings")->updateOrInsert([
//            "item" => "janvince_smallgdpr_cookies_settings",
//        ], [
//            "value" => json_encode(json_decode($value)),
//        ]);


    }
}