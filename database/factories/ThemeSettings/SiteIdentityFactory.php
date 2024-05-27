<?php

namespace Database\Factories\ThemeSettings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThemeSettings\SiteIdentity>
 */
class SiteIdentityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'site_name' => 'Kontonios',
            'site_domain' => 'kontonios.gr',
            'site_email' => 'kontonios@gmail.com',
            'site_owner_name' => 'Panos vlassopoulos',
            'site_owner_email' => 'P.kontonios@gmail.com',
            'logo_image' => 'https://laravuetail.com/storage/images/ecommerce-logo.svg',
            'banner_text' => '',
        ];
    }
}
