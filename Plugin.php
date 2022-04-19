<?php namespace LZaplata\Extensions;

use October\Rain\Support\Facades\Event;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;
use RainLab\Pages\Classes\Content;
use RainLab\Pages\Classes\Page;
use RainLab\Pages\Controllers\Index;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [
        "Rainlab.Translate",
    ];

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
                    "type" => "mlricheditor",
                    "stretch" => true,
                    "toolbarButtons" => "paragraphFormat|bold|italic|align|formatOL|formatUL|insertTable|insertLink|insertImage|html"
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
                    "type" => "mlricheditor",
                    "stretch" => true,
                    "size" => "huge",
                    "toolbarButtons" => "paragraphFormat|bold|italic|align|formatOL|formatUL|insertTable|insertLink|insertImage|html"
                ]
            ]);
        });

        /**
         * Replace Markdown editor with Rich editor in Rainlab.Pages content blocks
         */
        Event::listen("backend.form.extendFields", function ($widget) {
            if (!$widget->getController() instanceof Index) {
                return;
            }

            if (!$widget->model instanceof Content) {
                return;
            }

            if ($widget->isNested) {
                return;
            }

            $widget->addSecondaryTabFields([
                "markup_html" => [
                    "tab" => "cms::lang.editor.content",
                    "type" => "mlricheditor",
                    "stretch" => true,
                    "size" => "huge",
                    "valueFrom" => "markup",
                    "toolbarButtons" => "paragraphFormat|bold|italic|align|formatOL|formatUL|insertTable|insertLink|insertImage|html"
                ]
            ]);
        });
    }
}
