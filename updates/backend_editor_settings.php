<?php

namespace LZaplata\Extensions\Updates;

use Illuminate\Support\Facades\DB;
use October\Rain\Database\Updates\Seeder;

class BackendEditorSettings extends Seeder
{
    public function run()
    {
        $value = file_get_contents(__DIR__ . "/../seeds/data/backend-editor-settings.json");

        DB::table("system_settings")->updateOrInsert([
            "item" => "backend_editor_settings"
        ], [
            "value" => json_encode(json_decode($value)),
        ]);
    }
}