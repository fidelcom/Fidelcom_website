<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Block;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->migrateContactSettings();
        $this->seedHomePage();
        $this->seedMenus();
    }

    private function migrateContactSettings(): void
    {
        $contact = Contact::first();
        $about   = About::first();

        if ($contact) {
            $map = [
                'phone'     => $contact->phone,
                'email'     => $contact->email,
                'address'   => $contact->address,
                'facebook'  => $contact->facebook,
                'twitter'   => $contact->twitter,
                'instagram' => $contact->instagram,
                'linkedin'  => $contact->linkedin,
                'youtube'   => $contact->youtube ?? null,
            ];
            foreach ($map as $key => $value) {
                Setting::set($key, $value, 'contact');
            }
            $this->command->info('Contact settings migrated.');
        }

        if ($about) {
            Setting::set('site_name', 'Fidelcom Systems Limited', 'general');
            Setting::set('default_title', 'Fidelcom Systems Limited — IT Solutions Nigeria', 'seo');
            Setting::set('default_desc', 'IT solutions, software development, and digital consulting in Nigeria and beyond.', 'seo');
            $this->command->info('SEO settings seeded.');
        }
    }

    private function seedHomePage(): void
    {
        if (Page::where('slug', 'home')->exists()) {
            $this->command->info('Home page already exists — skipping.');
            return;
        }

        $page = Page::create([
            'title'            => 'Home',
            'slug'             => 'home',
            'status'           => 'published',
            'published_at'     => now(),
            'meta_title'       => 'Fidelcom Systems Limited — IT Solutions Nigeria',
            'meta_description' => 'IT solutions, software development, and digital consulting services in Nigeria and beyond.',
        ]);

        $blocks = [
            ['block_type' => 'slider',         'position' => 0,  'data' => ['slider_ids' => [], 'autoplay' => true, 'autoplay_speed' => 5000]],
            ['block_type' => 'stats',          'position' => 1,  'data' => ['heading' => 'Our Impact', 'source' => 'db']],
            ['block_type' => 'services_grid',  'position' => 2,  'data' => ['heading' => 'Our Services', 'style' => 'card-grid', 'service_ids' => [], 'limit' => 6]],
            ['block_type' => 'projects_grid',  'position' => 3,  'data' => ['heading' => 'Our Portfolio', 'style' => 'grid', 'category_id' => null, 'limit' => 6]],
            ['block_type' => 'testimonials',   'position' => 4,  'data' => ['heading' => 'What Our Clients Say', 'style' => 'slider', 'limit' => 6, 'approved_only' => true]],
            ['block_type' => 'blog_posts',     'position' => 5,  'data' => ['heading' => 'Latest Insights', 'style' => 'card', 'limit' => 3, 'category_id' => null]],
            ['block_type' => 'partners',       'position' => 6,  'data' => ['heading' => 'Trusted By', 'style' => 'logo-strip']],
            ['block_type' => 'faqs',           'position' => 7,  'data' => ['heading' => 'Frequently Asked Questions', 'limit' => 5, 'style' => 'accordion']],
            ['block_type' => 'cta_banner',     'position' => 8,  'data' => ['heading' => 'Ready to start your project?', 'body' => 'Get a tailored proposal within 24 hours.', 'button_label' => 'Request a Quote', 'button_url' => '/contact-us', 'bg_color' => 'primary']],
        ];

        foreach ($blocks as $block) {
            $page->blocks()->create($block);
        }

        $this->command->info('Home page seeded with ' . count($blocks) . ' blocks.');
    }

    private function seedMenus(): void
    {
        $menus = [
            [
                'name'     => 'Header Navigation',
                'location' => 'header',
                'items'    => [
                    ['label' => 'Home',     'url' => '/'],
                    ['label' => 'About',    'url' => '/about'],
                    ['label' => 'Services', 'url' => '/all-services'],
                    ['label' => 'Projects', 'url' => '/portfolio'],
                    ['label' => 'Blog',     'url' => '/blog'],
                    ['label' => 'Contact',  'url' => '/contact-us'],
                ],
            ],
            [
                'name'     => 'Footer Company',
                'location' => 'footer-company',
                'items'    => [
                    ['label' => 'About Us',   'url' => '/about'],
                    ['label' => 'Services',   'url' => '/all-services'],
                    ['label' => 'Portfolio',  'url' => '/portfolio'],
                    ['label' => 'Contact Us', 'url' => '/contact-us'],
                ],
            ],
            [
                'name'     => 'Footer Resources',
                'location' => 'footer-resources',
                'items'    => [
                    ['label' => 'Our Team', 'url' => '/our-teams'],
                    ['label' => 'Blog',     'url' => '/blog'],
                    ['label' => 'FAQs',     'url' => '/faqs'],
                ],
            ],
        ];

        foreach ($menus as $menuData) {
            $menu = \App\Models\Menu::firstOrCreate(
                ['location' => $menuData['location']],
                ['name' => $menuData['name']]
            );

            foreach ($menuData['items'] as $i => $item) {
                \App\Models\MenuItem::firstOrCreate(
                    ['menu_id' => $menu->id, 'url' => $item['url']],
                    ['label' => $item['label'], 'position' => $i, 'target' => '_self']
                );
            }
        }

        $this->command->info('Menus seeded.');
    }
}
