<?php

namespace App\Models\ThemeSettings;

use App\Models\ThemeSettings\SiteIdentity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class MainMenu extends Model
{
    use HasFactory;

    public function publicMenu()
    {
        $publicMenu = [
            'logo' => [
                "name" => SiteIdentity::first()->site_name,
                "imageSrc" => SiteIdentity::first()->logo_image_url,
                "href" => asset('')
            ],
            'categories' => [
                [
                    "id" => "category",
                    "name" => __('menu.category'),
                    "featured" => [
                        [
                            "name" => __('menu.featured_products1'),
                            "href" => asset('') . 'shop?tag=%5B"best_seller"%5D',
                            "imageSrc" =>
                                "https://img.freepik.com/free-vector/beer-foam-background-horizontally-seamless-pattern_1284-42180.jpg?t=st=1717178519~exp=1717182119~hmac=229926e16e05f7592f4953a85fd28eaaace21678e0c65bdaa5839f139e67df62&w=1060"
                        ],
                        [
                            "name" => __('menu.featured_products2'),
                            "href" => asset('') . 'shop?tag=%5B"new_arrival"%5D',
                            "imageSrc" =>
                                "https://images.unsplash.com/photo-1608885898599-4dadfdceec60?q=80&w=3087&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        ],

                    ],
                    "sections" => [
                        [
                            "id" => "categories",
                            "name" => __('menu.categories'),
                            "items" => Category::all()
                        ],
                    ],
                ],
            ],
            "pages" => [
                ["name" => __('menu.shop'), "href" => asset('') . 'shop'],
                ["name" => __('menu.about_us'), "href" => asset('') . 'about'],
                ["name" => __('menu.contact'), "href" => asset('') . 'contact'],
            ],
        ];
        return json_encode($publicMenu);
    }
}
