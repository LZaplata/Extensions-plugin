<?php namespace LZaplata\Extensions;

use October\Rain\Support\Facades\Event;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;
use RainLab\Pages\Classes\Page;
use RainLab\Pages\Controllers\Index;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @return void
     */
    public function boot(): void
    {
        /**
         * Replace Markdown editor with Rich editor in Rainlab.Blog post
         */
        Event::listen("backend.form.extendFields", function ($widget) {
            if (!$widget->getController() instanceof Posts) {
                return;
            }

            if (!$widget->model instanceof Post) {
                return;
            }

            if ($widget->isNested) {
                return;
            }

            $widget->addSecondaryTabFields([
                "content" => [
                    "tab" => "rainlab.blog::lang.post.tab_edit",
                    "type" => "richeditor",
                    "stretch" => true,
                ]
            ]);
        });

        /**
         * Replace Markdown editor with Rich editor in Rainlab.Pages static page content
         */
        Event::listen("backend.form.extendFields", function ($widget) {
            if (!$widget->getController() instanceof Index) {
                return;
            }

            if (!$widget->model instanceof Page) {
                return;
            }

            if ($widget->isNested) {
                return;
            }

            $widget->addSecondaryTabFields([
                "markup" => [
                    "tab" => "rainlab.pages::lang.editor.content",
                    "type" => "richeditor",
                    "stretch" => true,
                    "size" => "huge"
                ]
            ]);
        });
    }
}
