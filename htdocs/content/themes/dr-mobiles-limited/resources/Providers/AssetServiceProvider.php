<?php

namespace Theme\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Themosis\Core\ThemeManager;
use Themosis\Support\Facades\Asset;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Theme Assets
     *
     * Here we define the loaded assets from our previously defined
     * "dist" directory. Assets sources are located under the root "assets"
     * directory and are then compiled, thanks to Laravel Mix, to the "dist"
     * folder.
     *
     * @see https://laravel-mix.com/
     */
    public function register()
    {
        /** @var ThemeManager $theme */
        $theme = $this->app->make('wp.theme');

        Asset::add('theme_styles', 'css/theme.css', [], $theme->getHeader('version'))->to('front');
        Asset::add('theme_woo', 'css/woocommerce.css', ['theme_styles'], $theme->getHeader('version'))->to('front');
        Asset::add('theme_js', 'js/theme.min.js', [], $theme->getHeader('version'))->to('front');

        Asset::add('app-style', 'css/app.css', [], $theme->getHeader('version'))->to('front');
        Asset::add('app-script', 'js/app.js', [], $theme->getHeader('version'))->to('front');

        View::composer(['layouts.header'], function ($view) {
            global $wp;
            $current_url = home_url(add_query_arg([], $wp->request)) . '/';

            $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['menu-1']);
            $menu_array = $this->menu_build_array($menu_items);

            $view->with(compact('current_url', 'menu_array'));
        });
    }

    private function menu_build_array($menu_items): array
    {
        $menu_array = [];

        foreach ($menu_items as $menu_item) {
            if ($menu_item->menu_item_parent) {
                $menu_depth = 1;
                $menu_array = $this->menu_find_parent($menu_array, $menu_item->menu_item_parent, $menu_item,
                    $menu_depth);
            } else {
                $menu_array[$menu_item->ID]['title'] = $menu_item->title;
                $menu_array[$menu_item->ID]['url'] = $menu_item->url;
                $menu_array[$menu_item->ID]['target'] = $menu_item->target;
                $menu_array[$menu_item->ID]['depth'] = 1;
            }
        }

        return $menu_array;
    }

    private function menu_find_parent($menu_array, $menu_parent_id, $menu_current_item, $menu_depth): array
    {
        foreach ($menu_array as $menu_index => $menu_item) {
            if (isset($menu_item['children'])) {
                $menu_array[$menu_index]['children'] = $this->menu_find_parent($menu_item['children'], $menu_parent_id,
                    $menu_current_item, $menu_depth + 1);
            }

            if ($menu_index == $menu_parent_id) {
                $menu_array[$menu_index]['children'][$menu_current_item->ID]['title'] = $menu_current_item->title;
                $menu_array[$menu_index]['children'][$menu_current_item->ID]['url'] = $menu_current_item->url;
                $menu_array[$menu_index]['children'][$menu_current_item->ID]['target'] = $menu_current_item->target;
                $menu_array[$menu_index]['children'][$menu_current_item->ID]['depth'] = $menu_depth + 1;

                return $menu_array;
            }
        }

        return $menu_array;
    }
}
