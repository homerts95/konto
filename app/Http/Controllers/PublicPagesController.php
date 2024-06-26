<?php

namespace App\Http\Controllers;

use App\Models\Pages\AboutPageContent;
use App\Models\Category;
use App\Models\Pages\ContactPageContent;
use App\Models\Pages\CustomPage;
use App\Models\Pages\HomePageContent;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class PublicPagesController extends Controller
{
    //
    public function homePage(): Response
    {

        $homePageContent = HomePageContent::first();
        return Inertia::render('Public/Home', [
            'homePageContent' => $homePageContent,
            'categories' => Category::all(),
            'productBestSellers'=>Product::whereIn('tag',['best_seller','new_arrival'])->paginate(10)->withQueryString()
        ]);
    }

    public function aboutPage(): Response
    {

        $aboutPageContent = AboutPageContent::first();
        return Inertia::render('Public/About',[
            'aboutPageContent' => $aboutPageContent,
        ]);
    }

    public function contactPage(): Response
    {
        $contactPageContent = ContactPageContent::first();
        return Inertia::render('Public/Contact',[
            'contactPageContent' => $contactPageContent,
        ]);
    }

    public function customPage(CustomPage $customPage): Response
    {
        return Inertia::render('Public/CustomPage',[
            'customPageContent' => $customPage,
        ]);
    }
}
