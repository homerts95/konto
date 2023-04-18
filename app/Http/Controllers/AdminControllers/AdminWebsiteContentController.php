<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AboutPageContent;
use App\Models\ContactPageContent;
use App\Models\HomePageContent;
use App\Models\SiteIdentity;
use Inertia\Inertia;


class AdminWebsiteContentController extends Controller
{

    public function edit()
    {

        $siteIdentity = SiteIdentity::first();
        $homePageContent = HomePageContent::first();
        $aboutPageContent = AboutPageContent::first();
        $contactPageContent = ContactPageContent::first();
        
        return Inertia::render('AdminDashboard/WebsiteContents/Edit', [
            'siteIdentity'=>$siteIdentity,
            'homePageContent'=>$homePageContent,
            'contactPageContent' => $contactPageContent,
            'aboutPageContent' => $aboutPageContent
        ]);
    }
}
