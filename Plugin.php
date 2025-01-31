<?php namespace LZaplata\Extensions;

use Backend\FormWidgets\RichEditor;
use Cms\Classes\Asset;
use Cms\Classes\Theme;
use LZaplata\Pages\Controllers\Pages;
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
     * @return void
     */
    public function boot(): void
    {
        /**
         * Adds custom stylesheet to modify default richeditor classes
         * Adds custom buttons to richeditor
         */
        RichEditor::extend(function ($widget) {
            $widget->getController()->addCss("/plugins/lzaplata/extensions/formwidgets/richeditor/assets/css/richeditor.css");

            if ($widget->getController() instanceof Pages) {
                $widget->getController()->addJs("/plugins/lzaplata/extensions/formwidgets/richeditor/assets/js/richeditor.js");
            }
        });

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
                    "tab"               => "rainlab.blog::lang.post.tab_edit",
                    "type"              => "richeditor",
                    "stretch"           => true,
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
                    "size" => "huge",
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
                    "type" => "richeditor",
                    "stretch" => true,
                    "size" => "huge",
                    "valueFrom" => "markup",
                ]
            ]);
        });
    }
}
