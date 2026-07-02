<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\BlogCategory;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Process;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Success;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FidelcomContentSeeder extends Seeder
{
    /**
     * Download an image from a real URL, store it on the public disk, and return
     * the public path for DB storage. Extension is derived from the source URL.
     * Skips the download if the file already exists (idempotent).
     */
    private function imgFromUrl(string $url, string $localName, string $dir): string
    {
        $ext      = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
        $filename = "{$dir}/{$localName}.{$ext}";

        if (!Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->makeDirectory($dir);
            try {
                $response = Http::timeout(30)
                    ->withHeaders(['User-Agent' => 'FidelcomSeeder/1.0'])
                    ->get($url);
                if ($response->successful()) {
                    Storage::disk('public')->put($filename, $response->body());
                    $this->command->line("  <fg=green>✓</> Downloaded: {$filename}");
                } else {
                    $this->command->warn("  HTTP {$response->status()} for {$url}");
                    return $url;
                }
            } catch (\Exception $e) {
                $this->command->warn("  Download failed [{$url}]: {$e->getMessage()}");
                return $url;
            }
        }

        return "storage/{$filename}";
    }

    public function run(): void
    {
        // Ensure storage symlink exists
        if (!file_exists(public_path('storage'))) {
            \Artisan::call('storage:link');
            $this->command->info('Storage symlink created.');
        }

        $this->seedSettings();
        $this->seedAbout();
        $this->seedBlogCategories();
        $this->seedProjectCategories();
        $this->seedServices();
        $this->seedProjects();
        $this->seedBlogPosts();
        $this->seedTeam();
        $this->seedTestimonials();
        $this->seedFaqs();
        $this->seedSliders();
        $this->seedSuccesses();
        $this->seedPartners();
        $this->seedGallery();
        $this->seedProcesses();
        $this->seedHomePage();
        $this->seedStaticPages();
        $this->seedMenus();
    }

    // ──────────────────────────────────────────────
    // Settings
    // ──────────────────────────────────────────────
    private function seedSettings(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',    'value' => 'Fidelcom Systems Limited', 'group' => 'general'],
            ['key' => 'tagline',      'value' => 'Digital Consulting Agency', 'group' => 'general'],
            ['key' => 'description',  'value' => 'Fidelcom Systems Limited is a leading Nigerian digital consulting agency delivering expert web development, mobile app development, branding, UI/UX design, IT consulting, and networking solutions.', 'group' => 'general'],
            ['key' => 'logo',         'value' => '', 'group' => 'general'],
            ['key' => 'favicon',      'value' => '', 'group' => 'general'],

            // Contact
            ['key' => 'phone',     'value' => '+234 8054 661 234', 'group' => 'contact'],
            ['key' => 'email',     'value' => 'info@fidelcom.org',  'group' => 'contact'],
            ['key' => 'address',   'value' => 'Lekki, Lagos, Nigeria', 'group' => 'contact'],
            ['key' => 'facebook',  'value' => 'https://facebook.com/fidelcom', 'group' => 'contact'],
            ['key' => 'twitter',   'value' => 'https://x.com/Fidelcomsystems', 'group' => 'contact'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/fidelcom_systems', 'group' => 'contact'],
            ['key' => 'linkedin',  'value' => 'https://linkedin.com/company/fidelcomsystems', 'group' => 'contact'],
            ['key' => 'youtube',   'value' => '', 'group' => 'contact'],

            // SEO
            ['key' => 'default_title', 'value' => 'Fidelcom Systems Limited | IT Solutions & Digital Agency Nigeria', 'group' => 'seo'],
            ['key' => 'default_desc',  'value' => 'Fidelcom Systems Limited delivers professional web development, mobile app development, branding, UI/UX design, IT consulting and networking solutions in Lagos, Nigeria.', 'group' => 'seo'],
            ['key' => 'og_image',      'value' => '', 'group' => 'seo'],
            ['key' => 'google_analytics', 'value' => '', 'group' => 'seo'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], ['value' => $s['value'], 'group' => $s['group']]);
        }

        $this->command->info('Settings seeded.');
    }

    // ──────────────────────────────────────────────
    // About
    // ──────────────────────────────────────────────
    private function seedAbout(): void
    {
        $this->command->info('Downloading About image...');
        $image = $this->imgFromUrl('https://fidelcom.org/upload/about/1856410051844497.jpg', 'about-team', 'about');

        About::updateOrCreate(['id' => 1], [
            'title'       => 'About Fidelcom Systems Limited',
            'mission'     => 'To empower businesses across Nigeria and Africa with innovative digital solutions — from branding and web development to mobile apps and IT infrastructure — enabling our clients to grow, compete, and lead in the digital economy.',
            'vision'      => 'To be the most trusted technology and digital consulting partner for businesses in Africa, known for delivering excellence, integrity, and measurable results.',
            'description' => 'Founded in 2020, Fidelcom Systems Limited is a full-service digital consulting agency headquartered in Lekki, Lagos. We serve startups, SMEs, and enterprises across Nigeria and beyond, offering end-to-end technology services tailored to each client\'s unique goals. Our multidisciplinary team combines creativity, technical expertise, and business strategy to deliver solutions that drive real growth. With over 200 projects delivered and a 92% client retention rate, we are the trusted partner for businesses that demand results.',
            'image'       => $image,
        ]);

        $this->command->info('About seeded.');
    }

    // ──────────────────────────────────────────────
    // Blog Categories
    // ──────────────────────────────────────────────
    private function seedBlogCategories(): void
    {
        $categories = [
            'Technology & Innovation',
            'Web & App Development',
            'Business & Digital Strategy',
            'Design & Branding',
            'Case Studies',
        ];

        foreach ($categories as $name) {
            BlogCategory::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
        }

        $this->command->info('Blog categories seeded.');
    }

    // ──────────────────────────────────────────────
    // Project Categories
    // ──────────────────────────────────────────────
    private function seedProjectCategories(): void
    {
        $categories = [
            'Mobile App Development',
            'Website Development',
            'Branding & Identity',
            'UI/UX Design',
        ];

        foreach ($categories as $name) {
            ProjectCategory::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
        }

        $this->command->info('Project categories seeded.');
    }

    // ──────────────────────────────────────────────
    // Services
    // ──────────────────────────────────────────────
    private function seedServices(): void
    {
        $this->command->info('Downloading service images...');

        $services = [
            [
                'title'            => 'Branding & Identity Design',
                'slug'             => 'branding-identity-design',
                'meta_title'       => 'Branding & Identity Design | Fidelcom Systems',
                'meta_description' => 'Build a powerful brand identity that sets you apart. Fidelcom delivers logo design, brand guidelines, and visual identity systems for businesses in Nigeria.',
                'short_desc'       => 'We craft distinctive brand identities that communicate your values, build trust, and make you instantly recognisable in a crowded market.',
                'long_desc'        => '<p>Your brand is more than a logo — it\'s the entire experience customers have with your business. At Fidelcom Systems, our branding experts design cohesive visual identities that align with your business goals and resonate with your target audience.</p><h2>What We Deliver</h2><ul><li>Logo design &amp; brand mark</li><li>Brand colour palette &amp; typography</li><li>Brand guidelines document</li><li>Business cards, letterheads &amp; stationery</li><li>Social media brand kits</li><li>Brand strategy &amp; positioning</li></ul><p>Whether you\'re launching a startup or refreshing an established brand, our design team brings your vision to life with precision and creativity.</p>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-01.jpg', 'branding', 'services'),
            ],
            [
                'title'            => 'Web Design & Development',
                'slug'             => 'web-design-development',
                'meta_title'       => 'Web Design & Development Nigeria | Fidelcom Systems',
                'meta_description' => 'Professional website design and development in Lagos, Nigeria. We build fast, mobile-optimised, SEO-ready websites for businesses of all sizes.',
                'short_desc'       => 'We design and develop high-performance websites that convert visitors into customers — built for speed, accessibility, and search engine visibility.',
                'long_desc'        => '<p>A great website is your most powerful digital asset. Fidelcom\'s web development team builds websites that are beautiful, technically robust, and optimised to rank on Google and convert visitors into paying customers.</p><h2>Our Web Services Include</h2><ul><li>Corporate websites &amp; landing pages</li><li>E-commerce &amp; online stores</li><li>Custom web applications</li><li>WordPress &amp; CMS development</li><li>Website redesign &amp; migration</li><li>Ongoing maintenance &amp; support</li></ul><p>Every website we build is mobile-first, WCAG-accessible, and engineered for Core Web Vitals performance.</p>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-02.jpg', 'webdev', 'services'),
            ],
            [
                'title'            => 'Mobile App Development',
                'slug'             => 'mobile-app-development',
                'meta_title'       => 'Mobile App Development Nigeria | Fidelcom Systems',
                'meta_description' => 'Custom Android & iOS mobile app development in Nigeria. Fidelcom builds scalable, user-friendly mobile applications for startups and enterprises.',
                'short_desc'       => 'We build native and cross-platform mobile applications for Android and iOS that delight users and scale with your business.',
                'long_desc'        => '<p>Mobile is where your customers are. Fidelcom\'s mobile development team builds custom applications that combine intuitive design with powerful engineering — from MVP to enterprise-scale deployment.</p><h2>Mobile Development Services</h2><ul><li>Android app development</li><li>iOS app development</li><li>Cross-platform apps (React Native / Flutter)</li><li>App UI/UX design</li><li>API integration &amp; backend services</li><li>App Store / Play Store submission</li><li>Post-launch support &amp; updates</li></ul>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-03.jpg', 'mobile', 'services'),
            ],
            [
                'title'            => 'UI/UX Design',
                'slug'             => 'ui-ux-design',
                'meta_title'       => 'UI/UX Design Services Nigeria | Fidelcom Systems',
                'meta_description' => 'Expert UI/UX design services in Lagos, Nigeria. Fidelcom creates intuitive, user-centred digital experiences for web and mobile products.',
                'short_desc'       => 'We design user experiences that are intuitive, accessible, and engineered to reduce friction — turning complex problems into elegant digital products.',
                'long_desc'        => '<p>Great design is invisible — users simply feel it. Our UX designers research, prototype, and test every interaction to ensure your product is not just beautiful but genuinely easy to use.</p><h2>Our Design Process</h2><ul><li>User research &amp; persona development</li><li>Information architecture</li><li>Wireframing &amp; prototyping</li><li>Visual UI design</li><li>Usability testing</li><li>Design system creation</li><li>Handoff to development</li></ul>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-04.jpg', 'uxdesign', 'services'),
            ],
            [
                'title'            => 'Graphic Design Services',
                'slug'             => 'graphic-design-services',
                'meta_title'       => 'Graphic Design Services Nigeria | Fidelcom Systems',
                'meta_description' => 'Creative graphic design services in Lagos, Nigeria. Fidelcom designs marketing materials, social media graphics, brochures, and more.',
                'short_desc'       => 'From marketing collateral to social media graphics, our creative team produces visual content that communicates clearly and drives engagement.',
                'long_desc'        => '<p>Compelling visuals are essential for every business. Our graphic design team creates print-ready and digital-optimised designs that strengthen your brand at every touchpoint.</p><h2>Graphic Design Services</h2><ul><li>Marketing brochures &amp; flyers</li><li>Social media graphics &amp; templates</li><li>Presentations &amp; pitch decks</li><li>Banners &amp; event materials</li><li>Packaging design</li><li>Infographics &amp; data visualisation</li></ul>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-02.jpg', 'graphic', 'services'),
            ],
            [
                'title'            => 'IT Consulting',
                'slug'             => 'it-consulting',
                'meta_title'       => 'IT Consulting Services Nigeria | Fidelcom Systems',
                'meta_description' => 'Strategic IT consulting services in Lagos, Nigeria. Fidelcom helps businesses align technology with business goals, reduce costs, and improve efficiency.',
                'short_desc'       => 'We help businesses make smarter technology decisions — from software selection and IT audits to digital transformation roadmaps and implementation.',
                'long_desc'        => '<p>Technology changes fast. Fidelcom\'s IT consultants help you navigate the landscape, select the right tools, and build a technology strategy that supports your long-term business objectives.</p><h2>Consulting Services</h2><ul><li>IT strategy &amp; roadmap development</li><li>Software selection &amp; vendor evaluation</li><li>Digital transformation planning</li><li>IT infrastructure audit</li><li>Cloud migration consulting</li><li>Cybersecurity assessment</li><li>Process automation advisory</li></ul>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-03.jpg', 'itconsult', 'services'),
            ],
            [
                'title'            => 'Networking Solutions',
                'slug'             => 'networking-solutions',
                'meta_title'       => 'Networking Solutions & IT Infrastructure Nigeria | Fidelcom',
                'meta_description' => 'Professional network installation and IT infrastructure services in Lagos, Nigeria. Fidelcom delivers reliable, secure, and scalable networking solutions.',
                'short_desc'       => 'We design, install, and manage enterprise-grade networking infrastructure — from structured cabling and Wi-Fi to firewalls and server management.',
                'long_desc'        => '<p>Reliable connectivity is the backbone of every modern business. Fidelcom\'s networking specialists design and deploy secure, high-performance network infrastructure that keeps your operations running without interruption.</p><h2>Networking Services</h2><ul><li>Structured cabling &amp; LAN setup</li><li>Wi-Fi design &amp; deployment</li><li>Server installation &amp; configuration</li><li>Firewall &amp; network security</li><li>VPN setup &amp; remote access</li><li>CCTV &amp; access control systems</li><li>Network monitoring &amp; support</li></ul>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-04.jpg', 'networking', 'services'),
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $this->command->info('Services seeded (' . count($services) . ').');
    }

    // ──────────────────────────────────────────────
    // Projects
    // ──────────────────────────────────────────────
    private function seedProjects(): void
    {
        $this->command->info('Downloading project images...');

        $mobileId  = ProjectCategory::where('name', 'Mobile App Development')->value('id');
        $websiteId = ProjectCategory::where('name', 'Website Development')->value('id');

        $projects = [
            [
                'project_category_id' => $mobileId,
                'title'               => 'Supercash Mobile App',
                'slug'                => 'supercash-mobile-app',
                'meta_title'          => 'Supercash Mobile App | Fidelcom Portfolio',
                'meta_description'    => 'Fidelcom designed and developed the Supercash mobile application — a seamless fintech payment solution built for Android and iOS in Nigeria.',
                'short_desc'          => 'A feature-rich fintech mobile application enabling seamless digital payments, transfers, and financial management for Nigerian users.',
                'long_desc'           => '<p>Supercash is a next-generation fintech application that simplifies digital payments for everyday Nigerians. Fidelcom was engaged to design and develop the full mobile experience — from UX research and prototyping through to native Android and iOS deployment.</p><h2>Our Approach</h2><p>We began with a deep discovery phase to understand user pain points in the Nigerian digital payments landscape. The resulting product features a clean, accessible interface with biometric authentication, real-time transaction tracking, and seamless bank transfers.</p><h2>Technologies Used</h2><ul><li>React Native (cross-platform)</li><li>Node.js backend API</li><li>Biometric authentication</li><li>Real-time push notifications</li></ul>',
                'client'              => 'Supercash Nigeria',
                'year'                => '2023',
                'location'            => 'Lagos, Nigeria',
                'image'               => $this->imgFromUrl('https://fidelcom.org/upload/project/1855402550439674.png', 'supercash', 'projects'),
            ],
            [
                'project_category_id' => $websiteId,
                'title'               => 'Anexon Store E-Commerce',
                'slug'                => 'anexon-store-ecommerce',
                'meta_title'          => 'Anexon Store E-Commerce Website | Fidelcom Portfolio',
                'meta_description'    => 'Fidelcom built the Anexon Store e-commerce platform — a fast, scalable online shopping experience designed to drive sales and improve conversion.',
                'short_desc'          => 'A high-performance e-commerce website with product management, secure checkout, and a mobile-first design that drives conversions.',
                'long_desc'           => '<p>Anexon Store is a growing Nigerian e-commerce brand that needed a website capable of handling increasing traffic while delivering a premium shopping experience. Fidelcom designed and developed a custom WooCommerce solution optimised for performance and SEO.</p><h2>Key Features</h2><ul><li>Mobile-first responsive design</li><li>Secure payment gateway integration (Paystack &amp; Flutterwave)</li><li>Product filtering &amp; search</li><li>Inventory management dashboard</li><li>Core Web Vitals optimisation</li></ul>',
                'client'              => 'Anexon Nigeria',
                'year'                => '2023',
                'location'            => 'Lagos, Nigeria',
                'image'               => $this->imgFromUrl('https://fidelcom.org/upload/project/1855403145874717.png', 'anexon', 'projects'),
            ],
            [
                'project_category_id' => $websiteId,
                'title'               => 'Dove Livami Properties',
                'slug'                => 'dove-livami-properties',
                'meta_title'          => 'Dove Livami Properties Website | Fidelcom Portfolio',
                'meta_description'    => 'Fidelcom designed the Dove Livami Properties real estate website in Lagos, Nigeria — luxury property listings with an elegant, conversion-focused design.',
                'short_desc'          => 'A professional real estate website with property listing management, search filters, and lead capture tools for a premium Lagos property brand.',
                'long_desc'           => '<p>Dove Livami Properties is a premium real estate brand operating in Lagos. They needed a digital presence that reflected the quality of their developments and made it easy for prospective buyers to explore listings and make enquiries.</p><h2>What We Built</h2><ul><li>Luxury-feel website design with high-quality imagery</li><li>Property listing system with filter by type, location &amp; price</li><li>Enquiry and callback request forms</li><li>Agent profile pages</li><li>Google Maps integration for property locations</li></ul>',
                'client'              => 'Dove Livami Properties',
                'year'                => '2024',
                'location'            => 'Lagos, Nigeria',
                'image'               => $this->imgFromUrl('https://fidelcom.org/upload/project/1855403923878010.png', 'dovelivami', 'projects'),
            ],
            [
                'project_category_id' => $websiteId,
                'title'               => 'DonacSchools Learning Platform',
                'slug'                => 'donacschools-learning-platform',
                'meta_title'          => 'DonacSchools Website | Fidelcom Portfolio',
                'meta_description'    => 'Fidelcom built the DonacSchools website and learning platform — a comprehensive digital solution for a leading Nigerian school network.',
                'short_desc'          => 'A comprehensive school website and learning management system that streamlines enrolment, communications, and academic content delivery.',
                'long_desc'           => '<p>DonacSchools is a growing network of schools in Nigeria that required a modern digital platform to manage student information, communicate with parents, and publish educational content. Fidelcom delivered a full custom solution.</p><h2>Platform Features</h2><ul><li>School information &amp; admissions website</li><li>Student and parent portal</li><li>Online fee payment integration</li><li>News &amp; events module</li><li>Contact &amp; enquiry management</li><li>Mobile-responsive design</li></ul>',
                'client'              => 'DonacSchools',
                'year'                => '2024',
                'location'            => 'Nigeria',
                'image'               => $this->imgFromUrl('https://fidelcom.org/upload/project/1855404597768908.png', 'donacschools', 'projects'),
            ],
            [
                'project_category_id' => $websiteId,
                'title'               => 'SecureView Security Platform',
                'slug'                => 'secureview-security-platform',
                'meta_title'          => 'SecureView Platform | Fidelcom Portfolio',
                'meta_description'    => 'Fidelcom developed the SecureView security management platform in Lagos, Nigeria — a robust web application for enterprise security monitoring and reporting.',
                'short_desc'          => 'A web-based security management platform enabling real-time monitoring, incident reporting, and compliance tracking for enterprise clients.',
                'long_desc'           => '<p>SecureView needed a custom web platform to manage security operations across multiple client sites. Fidelcom designed and developed a secure, role-based web application that centralises incident reporting, monitoring schedules, and compliance documentation.</p><h2>Technical Highlights</h2><ul><li>Role-based access control (RBAC)</li><li>Real-time incident reporting</li><li>Automated compliance reporting</li><li>Multi-site management dashboard</li><li>Export to PDF/Excel</li></ul>',
                'client'              => 'SecureView',
                'year'                => '2024',
                'location'            => 'Lagos, Nigeria',
                'image'               => $this->imgFromUrl('https://fidelcom.org/upload/project/1855403145874717.png', 'secureview', 'projects'),
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $this->command->info('Projects seeded (' . count($projects) . ').');
    }

    // ──────────────────────────────────────────────
    // Blog Posts
    // ──────────────────────────────────────────────
    private function seedBlogPosts(): void
    {
        $this->command->info('Downloading blog images...');

        $devCatId      = BlogCategory::where('name', 'Web & App Development')->value('id');
        $strategyId    = BlogCategory::where('name', 'Business & Digital Strategy')->value('id');
        $brandingCatId = BlogCategory::where('name', 'Design & Branding')->value('id');
        $techId        = BlogCategory::where('name', 'Technology & Innovation')->value('id');

        $posts = [
            [
                'blog_category_id' => $devCatId,
                'title'            => '10 Website Mistakes That Kill Business Growth (Fix Them Now)',
                'slug'             => '10-website-mistakes-that-kill-business-growth',
                'meta_title'       => '10 Website Mistakes That Kill Business Growth | Fidelcom Blog',
                'meta_description' => 'Is your website silently costing you customers? Discover the 10 most common website mistakes Nigerian businesses make and exactly how to fix them.',
                'author'           => 'Fidelcom Editorial Team',
                'short_desc'       => 'Your website could be the biggest obstacle to your business growth and you might not even know it. Here are 10 critical mistakes to fix today.',
                'long_desc'        => '<p>Your website is often the first impression a potential customer has of your business. If it\'s slow, confusing, or untrustworthy, you\'re losing customers before they even speak to you. Here are the 10 most damaging website mistakes — and exactly what to do about each one.</p><h2>1. No Clear Call-to-Action</h2><p>Every page needs to tell visitors what to do next. If someone lands on your homepage and doesn\'t immediately know how to contact you, request a quote, or make a purchase, you\'ve lost them. Place a prominent CTA above the fold on every key page.</p><h2>2. Slow Loading Speed</h2><p>Google and users agree: slow is unacceptable. A one-second delay in page load time reduces conversions by 7%. Compress your images, enable caching, and use a reliable hosting provider. Aim for a load time under 3 seconds on mobile.</p><h2>3. Not Mobile-Optimised</h2><p>Over 60% of web traffic in Nigeria comes from mobile devices. If your website isn\'t fully responsive and easy to navigate on a smartphone, you\'re alienating the majority of your audience.</p><h2>4. No SSL Certificate</h2><p>An unsecured website shows a "Not Secure" warning in browsers, instantly destroying visitor trust. Every modern website must have an SSL certificate.</p><h2>5. Outdated Content</h2><p>A blog last updated in 2021, a team page with departed staff — these all signal that your business isn\'t active or credible. Audit your content quarterly.</p><h2>6. No Contact Information</h2><p>Make it effortless to contact you. Display your phone number, email, and location prominently — in the header, footer, and on a dedicated contact page.</p><h2>7. Poor Navigation Structure</h2><p>If visitors can\'t find what they\'re looking for in three clicks, they leave. Simplify your menu and use descriptive labels.</p><h2>8. No SEO Foundation</h2><p>A beautiful website is worthless if nobody can find it. Ensure every page has a unique meta title, meta description, and uses proper heading structure.</p><h2>9. Stock Photography</h2><p>Generic stock photos undermine authenticity. Use real photos of your team, office, and work wherever possible.</p><h2>10. No Analytics Setup</h2><p>If you\'re not tracking visitor behaviour, you\'re flying blind. Install Google Analytics and Google Search Console on every website.</p><p><strong>Need a website audit?</strong> <a href="/contact-us">Contact Fidelcom today</a>.</p>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/upload/post/1852949963628586.jpg', 'website-mistakes', 'blog'),
            ],
            [
                'blog_category_id' => $techId,
                'title'            => 'How Mobile Apps Are Transforming Business Operations in Nigeria',
                'slug'             => 'how-mobile-apps-are-transforming-business-in-nigeria',
                'meta_title'       => 'How Mobile Apps Are Transforming Business in Nigeria | Fidelcom',
                'meta_description' => 'Discover how Nigerian businesses are using custom mobile apps to streamline operations, improve customer experience, and drive revenue growth in 2024.',
                'author'           => 'Fidelcom Editorial Team',
                'short_desc'       => 'From fintech to logistics, Nigerian businesses across every sector are leveraging custom mobile apps to gain a competitive edge. Here\'s what\'s changing.',
                'long_desc'        => '<p>Nigeria\'s mobile penetration rate has crossed 85%, making it one of Africa\'s most mobile-connected populations. Forward-thinking businesses are capitalising on this shift by building custom mobile applications that meet customers where they are — on their phones.</p><h2>The Mobile-First Consumer</h2><p>The average Nigerian spends over 4 hours per day on their smartphone. For businesses, this means that mobile is no longer a secondary channel — it\'s often the primary touchpoint.</p><h2>Sector-by-Sector Impact</h2><h3>Fintech & Payments</h3><p>The success of platforms like Paystack, Flutterwave, and PalmPay has demonstrated the appetite for mobile financial services in Nigeria. Businesses that integrate digital payments into a seamless mobile experience see faster checkout and improved cash flow.</p><h3>Education</h3><p>Schools and training providers are using mobile apps to deliver content, manage student records, communicate with parents, and collect fees — reducing administrative overhead.</p><h3>Logistics & Delivery</h3><p>Last-mile delivery companies use mobile apps for real-time order tracking, driver dispatch, and customer communication. Companies report 30-40% reduction in customer support queries after launching tracking apps.</p><h2>What to Consider Before Building Your App</h2><ul><li><strong>Start with a clear problem to solve</strong> — apps built around a genuine user need always outperform vanity projects.</li><li><strong>Choose the right platform</strong> — for most Nigerian businesses, Android-first or cross-platform makes more commercial sense.</li><li><strong>Plan for offline use</strong> — design your app to function gracefully with intermittent connectivity.</li><li><strong>Budget for ongoing maintenance</strong> — an app is not a one-time expense.</li></ul><p>Thinking about building a mobile app? <a href="/contact-us">Talk to the Fidelcom team</a>.</p>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/upload/post/1852948302665922.jpg', 'mobile-apps', 'blog'),
            ],
            [
                'blog_category_id' => $brandingCatId,
                'title'            => 'The Complete Guide to Building a Strong Brand Identity in 2024',
                'slug'             => 'complete-guide-building-strong-brand-identity',
                'meta_title'       => 'Complete Guide to Brand Identity in 2024 | Fidelcom Systems',
                'meta_description' => 'Learn how to build a powerful brand identity that sets your business apart. A step-by-step guide covering logo, colour, typography, tone of voice, and more.',
                'author'           => 'Fidelcom Editorial Team',
                'short_desc'       => 'A strong brand identity is the single most leveraged investment a business can make. Here\'s how to build one from the ground up — the right way.',
                'long_desc'        => '<p>Your brand identity is the visual and verbal personality of your business. It determines how people perceive you before they\'ve even spoken to you. In a competitive market — whether in Lagos, Abuja, or competing globally — a strong brand identity is not a luxury. It\'s a strategic necessity.</p><h2>What Is Brand Identity?</h2><p>Brand identity is the collection of visual and communicative elements that represent your business: your logo, colour palette, typography, imagery style, and tone of voice used in all your communications.</p><h2>Step 1: Define Your Brand Foundation</h2><ul><li><strong>Mission</strong> — why does your business exist?</li><li><strong>Vision</strong> — where are you going?</li><li><strong>Values</strong> — what principles guide your decisions?</li><li><strong>Target audience</strong> — who are you talking to?</li><li><strong>Positioning</strong> — how are you different from competitors?</li></ul><h2>Step 2: Choose Your Visual Identity</h2><h3>Logo</h3><p>Your logo should be simple, distinctive, and timeless. Avoid overly complex designs and following trends too closely.</p><h3>Colour Palette</h3><p>Colour communicates emotion before words do. Choose a primary colour that reflects your brand personality, plus supporting colours and neutrals. Define exact hex, RGB, and CMYK values for consistency.</p><h3>Typography</h3><p>Select two typefaces: a display font for headlines and a body font for readable text. Ensure both work harmoniously across web, print, and mobile.</p><h2>Step 3: Define Your Brand Voice</h2><p>Write it down as a brief voice guide with examples of on-brand and off-brand language — so everyone on your team communicates consistently.</p><h2>Step 4: Document in Brand Guidelines</h2><p>A brand guideline document is the single source of truth. Without it, your brand will drift inconsistently across platforms and materials.</p><p>Ready to build your brand? <a href="/all-services/branding-identity-design">Explore our branding services</a>.</p>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/upload/post/1861104892982425.avif', 'brand-identity', 'blog'),
            ],
            [
                'blog_category_id' => $strategyId,
                'title'            => 'Why Every Nigerian SME Needs a Digital Strategy in 2024',
                'slug'             => 'why-nigerian-sme-needs-digital-strategy-2024',
                'meta_title'       => 'Why Nigerian SMEs Need a Digital Strategy in 2024 | Fidelcom',
                'meta_description' => 'Nigerian SMEs without a digital strategy lose ground daily. Learn to build a practical digital plan that drives growth and customer acquisition.',
                'author'           => 'Fidelcom Editorial Team',
                'short_desc'       => 'Most Nigerian small businesses treat digital as an afterthought. Here\'s why that\'s a dangerous mistake — and how a clear digital strategy changes everything.',
                'long_desc'        => '<p>In 2024, your digital presence is your most important business asset. Yet a majority of Nigerian SMEs still operate without a coherent digital strategy, relying on word-of-mouth and sporadic social media posts. This approach is no longer enough.</p><h2>The Stakes Have Changed</h2><p>Over 70% of Nigerian consumers say they search online before making a purchase decision — even for local services. If your business isn\'t visible where customers are looking, you don\'t exist in their consideration set.</p><h2>What a Digital Strategy Actually Is</h2><p>A digital strategy answers three questions: Who are we trying to reach? What channels are most effective? What actions do we want them to take?</p><h2>The Core Components</h2><ul><li><strong>Website</strong> — your digital headquarters. Everything else points here.</li><li><strong>SEO</strong> — being found when customers search for what you offer.</li><li><strong>Social Media</strong> — building community and brand awareness.</li><li><strong>Content Marketing</strong> — publishing valuable content that earns trust and drives traffic.</li><li><strong>Email Marketing</strong> — maintaining relationships with existing customers at low cost.</li><li><strong>Paid Advertising</strong> — accelerating growth through targeted Google and Meta ads.</li></ul><p>You don\'t need to do everything at once. Start with the channels that best reach your audience, execute well, then expand.</p><p><a href="/contact-us">Contact our consulting team</a> — we work with Nigerian SMEs every day to build practical, results-driven digital plans.</p>',
                'image'            => $this->imgFromUrl('https://fidelcom.org/upload/post/1852948302665922.jpg', 'digital-strategy', 'blog'),
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $this->command->info('Blog posts seeded (' . count($posts) . ').');
    }

    // ──────────────────────────────────────────────
    // Team
    // ──────────────────────────────────────────────
    private function seedTeam(): void
    {
        $this->command->info('Downloading team images...');

        $team = [
            [
                'name'      => 'Emmanuel Okafor',
                'position'  => 'Chief Executive Officer',
                'image'     => $this->imgFromUrl('https://fidelcom.org/upload/team/1853227825299098.jpg', 'ceo', 'team'),
                'linkedin'  => 'https://linkedin.com/company/fidelcomsystems',
                'twitter'   => 'https://x.com/Fidelcomsystems',
                'instagram' => null,
                'facebook'  => null,
            ],
            [
                'name'      => 'Adaeze Nwosu',
                'position'  => 'Head of Design',
                'image'     => $this->imgFromUrl('https://fidelcom.org/upload/team/1853227842878494.jpg', 'designer', 'team'),
                'linkedin'  => 'https://linkedin.com/company/fidelcomsystems',
                'twitter'   => null,
                'instagram' => 'https://instagram.com/fidelcom_systems',
                'facebook'  => null,
            ],
            [
                'name'      => 'Chukwuemeka Eze',
                'position'  => 'Lead Developer',
                'image'     => $this->imgFromUrl('https://fidelcom.org/upload/team/1853227859218162.jpg', 'developer', 'team'),
                'linkedin'  => 'https://linkedin.com/company/fidelcomsystems',
                'twitter'   => 'https://x.com/Fidelcomsystems',
                'instagram' => null,
                'facebook'  => null,
            ],
            [
                'name'      => 'Fatima Abdullahi',
                'position'  => 'IT Consulting Lead',
                'image'     => $this->imgFromUrl('https://fidelcom.org/upload/team/1853227874499496.jpg', 'consultant', 'team'),
                'linkedin'  => 'https://linkedin.com/company/fidelcomsystems',
                'twitter'   => null,
                'instagram' => null,
                'facebook'  => null,
            ],
            [
                'name'      => 'James Johnson',
                'position'  => 'HR Manager',
                'image'     => $this->imgFromUrl('https://fidelcom.org/upload/team/1853227874499496.jpg', 'hr', 'team'),
                'linkedin'  => null,
                'twitter'   => null,
                'instagram' => null,
                'facebook'  => null,
            ],
        ];

        foreach ($team as $member) {
            Team::updateOrCreate(['name' => $member['name']], $member);
        }

        $this->command->info('Team seeded (' . count($team) . ' members).');
    }

    // ──────────────────────────────────────────────
    // Testimonials
    // ──────────────────────────────────────────────
    private function seedTestimonials(): void
    {
        $this->command->info('Downloading testimonial images...');

        $testimonials = [
            [
                'name'     => 'Donac Schools',
                'subtitle' => 'Director, DonacSchools Nigeria',
                'desc'     => 'Fidelcom transformed our school\'s digital presence completely. The website they built is fast, professional, and our parents love how easy it is to access information and make payments online. The team was responsive throughout the entire project.',
                'rating'   => '5',
                'approved' => true,
                'location' => 'Abuja, Nigeria',
                'image'    => $this->imgFromUrl('https://fidelcom.org/upload/testimonial/1852868151242799.jpg', 'donacschools', 'testimonials'),
            ],
            [
                'name'     => '3DTrance',
                'subtitle' => 'Creative Director, 3DTrance',
                'desc'     => 'We came to Fidelcom needing a complete brand overhaul. They exceeded every expectation — the new identity is distinctive, modern, and perfectly captures what our company stands for. We\'ve received so many compliments from clients since the rebrand.',
                'rating'   => '5',
                'approved' => true,
                'location' => 'Lagos, Nigeria',
                'image'    => $this->imgFromUrl('https://fidelcom.org/upload/testimonial/1852868177873681.jpg', '3dtrance', 'testimonials'),
            ],
            [
                'name'     => 'Zicron International School',
                'subtitle' => 'Principal, Zicron International School',
                'desc'     => 'The team at Fidelcom delivered our website on time and on budget. More importantly, the quality of work was outstanding. Enquiries from parents have increased significantly since launch.',
                'rating'   => '5',
                'approved' => true,
                'location' => 'Lagos, Nigeria',
                'image'    => $this->imgFromUrl('https://fidelcom.org/upload/testimonial/1852868209656392.jpg', 'zicron', 'testimonials'),
            ],
            [
                'name'     => 'SecureView',
                'subtitle' => 'CEO, SecureView Limited',
                'desc'     => 'Fidelcom built our security management platform from scratch and the result is exactly what we needed. The system is robust, easy to use, and our field teams have adopted it quickly. Highly recommended for any custom software project.',
                'rating'   => '5',
                'approved' => true,
                'location' => 'Lagos, Nigeria',
                'image'    => $this->imgFromUrl('https://fidelcom.org/upload/testimonial/1852868257333744.jpg', 'secureview', 'testimonials'),
            ],
            [
                'name'     => 'SuperCash Nigeria',
                'subtitle' => 'Product Manager, SuperCash',
                'desc'     => 'Building a fintech app is not simple, but Fidelcom made the process smooth and straightforward. They pushed back thoughtfully on some of our early ideas and the final product is much better for it. Our users love the experience.',
                'rating'   => '5',
                'approved' => true,
                'location' => 'Lagos, Nigeria',
                'image'    => $this->imgFromUrl('https://fidelcom.org/upload/testimonial/1852868294498258.jpg', 'supercash', 'testimonials'),
            ],
            [
                'name'     => 'SafeRush',
                'subtitle' => 'Co-Founder, SafeRush',
                'desc'     => 'We\'ve worked with several digital agencies before Fidelcom, and the difference in quality and communication is night and day. They genuinely care about delivering results, not just ticking boxes. Our conversion rate improved by 40% after the redesign.',
                'rating'   => '5',
                'approved' => true,
                'location' => 'Abuja, Nigeria',
                'image'    => $this->imgFromUrl('https://fidelcom.org/upload/testimonial/1852868966910178.jpg', 'saferush', 'testimonials'),
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }

        $this->command->info('Testimonials seeded (' . count($testimonials) . ').');
    }

    // ──────────────────────────────────────────────
    // FAQs
    // ──────────────────────────────────────────────
    private function seedFaqs(): void
    {
        $faqs = [
            [
                'question' => 'What services does Fidelcom Systems Limited offer?',
                'answer'   => 'Fidelcom offers a comprehensive range of digital services including branding & identity design, web design & development, mobile app development (Android & iOS), UI/UX design, graphic design, IT consulting, and networking & infrastructure solutions. We work with startups, SMEs, and enterprises across Nigeria and Africa.',
            ],
            [
                'question' => 'How much does a website cost in Nigeria?',
                'answer'   => 'Website costs vary depending on complexity and features required. A professional business website typically starts from ₦250,000, while e-commerce platforms and custom web applications are priced based on project scope. Contact us for a free consultation and tailored quote.',
            ],
            [
                'question' => 'How long does it take to build a website?',
                'answer'   => 'A standard business website typically takes 2–4 weeks from project kick-off to launch. E-commerce websites take 4–8 weeks, and complex custom web applications take 8–16 weeks or more. Timeline depends on content readiness, feedback speed, and project complexity.',
            ],
            [
                'question' => 'Do you work with clients outside Lagos?',
                'answer'   => 'Yes. While we are headquartered in Lekki, Lagos, we work with clients across Nigeria — including Abuja, Port Harcourt, Kano, and other cities — as well as internationally. Our collaborative process is designed to work remotely, so location is not a barrier.',
            ],
            [
                'question' => 'What is your mobile app development process?',
                'answer'   => 'Our mobile app development process follows five phases: Discovery & Strategy (defining requirements and technical architecture), Design (wireframing, prototyping, and UI design), Development (engineering the app), Testing (QA across devices), and Launch & Support (App Store/Play Store submission and post-launch maintenance).',
            ],
            [
                'question' => 'Will my website be optimised for search engines (SEO)?',
                'answer'   => 'Yes. Every website we build includes a solid SEO foundation: clean semantic HTML, proper heading structure, meta titles and descriptions, fast loading speed, mobile responsiveness, sitemap.xml, and Google Search Console setup. For ongoing SEO campaigns, we offer separate digital marketing packages.',
            ],
            [
                'question' => 'Do you provide website maintenance and support after launch?',
                'answer'   => 'Yes. We offer flexible maintenance plans covering software updates, security monitoring, content updates, performance optimisation, and technical support. We recommend all clients take a maintenance plan to keep their website secure, fast, and current.',
            ],
            [
                'question' => 'How do I get started with Fidelcom?',
                'answer'   => 'Getting started is easy. Simply visit our Contact page, fill in the enquiry form with details about your project, and one of our team will be in touch within 24 hours to schedule a free discovery call. We\'ll discuss your goals, recommend the right service, and provide a clear proposal with timeline and pricing.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }

        $this->command->info('FAQs seeded (' . count($faqs) . ').');
    }

    // ──────────────────────────────────────────────
    // Sliders
    // ──────────────────────────────────────────────
    private function seedSliders(): void
    {
        $this->command->info('Downloading slider images...');

        $sliders = [
            [
                'title'       => 'Digital Solutions That Drive Real Business Growth',
                'project'     => 'Web Development & Digital Strategy',
                'description' => 'We design, build, and grow digital products for ambitious businesses across Nigeria. From websites and mobile apps to brand identities and IT infrastructure — Fidelcom delivers.',
                'image'       => $this->imgFromUrl('https://fidelcom.org/upload/why/1856404506915779.jpg', 'hero1', 'sliders'),
            ],
            [
                'title'       => 'Professional Mobile Apps Built for Nigerian Users',
                'project'     => 'Mobile App Development',
                'description' => 'Android and iOS applications designed for the African market — built for performance, reliability, and the unique connectivity challenges of our environment.',
                'image'       => $this->imgFromUrl('https://fidelcom.org/upload/why/1856409013727910.jpg', 'hero2', 'sliders'),
            ],
            [
                'title'       => 'Brand Identities That Command Attention',
                'project'     => 'Branding & Identity Design',
                'description' => 'Your brand is your most valuable business asset. Our design team creates distinctive visual identities that build trust, communicate value, and set you apart from the competition.',
                'image'       => $this->imgFromUrl('https://fidelcom.org/upload/why/1856405700457235.jpg', 'hero3', 'sliders'),
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(['title' => $slider['title']], $slider);
        }

        $this->command->info('Sliders seeded (' . count($sliders) . ').');
    }

    // ──────────────────────────────────────────────
    // Successes (Stats)
    // ──────────────────────────────────────────────
    private function seedSuccesses(): void
    {
        $stats = [
            ['title' => 'Projects Delivered',   'value' => '200+'],
            ['title' => 'Happy Clients',         'value' => '150+'],
            ['title' => 'Years of Experience',   'value' => '8+'],
            ['title' => 'Client Retention Rate', 'value' => '92%'],
        ];

        foreach ($stats as $stat) {
            Success::firstOrCreate(['title' => $stat['title']], $stat);
        }

        $this->command->info('Stats seeded (' . count($stats) . ').');
    }

    // ──────────────────────────────────────────────
    // Partners / Clients
    // ──────────────────────────────────────────────
    private function seedPartners(): void
    {
        $this->command->info('Downloading partner logo images...');

        $partners = [
            ['name' => 'DonacSchools',           'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245478427640.png', 'donacschools',  'partners')],
            ['name' => '3DTrance',               'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245549716546.png', '3dtrance',      'partners')],
            ['name' => 'Zicron International',   'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245571990261.png', 'zicron',        'partners')],
            ['name' => 'SecureView',             'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245587835795.png', 'secureview',    'partners')],
            ['name' => 'SuperCash',              'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245603246665.png', 'supercash',     'partners')],
            ['name' => 'SafeRush',               'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245617292530.png', 'saferush',      'partners')],
            ['name' => 'Dove Livami Properties', 'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245635701190.png', 'dove',          'partners')],
            ['name' => 'Anexon Store',           'url' => null, 'image' => $this->imgFromUrl('https://fidelcom.org/upload/partners/1853245662344572.png', 'anexon',        'partners')],
        ];

        foreach ($partners as $p) {
            Partner::updateOrCreate(['name' => $p['name']], $p);
        }

        $this->command->info('Partners seeded (' . count($partners) . ').');
    }

    // ──────────────────────────────────────────────
    // Gallery
    // ──────────────────────────────────────────────
    private function seedGallery(): void
    {
        $this->command->info('Downloading gallery images...');

        $items = [
            ['name' => 'Office Team Collaboration', 'image' => $this->imgFromUrl('https://fidelcom.org/upload/why/1856409013727910.jpg',           'team-collab',  'gallery')],
            ['name' => 'Web Design Process',         'image' => $this->imgFromUrl('https://fidelcom.org/upload/project/1855402550439674.png',      'web-design',   'gallery')],
            ['name' => 'Mobile App Presentation',    'image' => $this->imgFromUrl('https://fidelcom.org/upload/project/1855403145874717.png',      'mobile-app',   'gallery')],
            ['name' => 'Brand Identity Workshop',    'image' => $this->imgFromUrl('https://fidelcom.org/assets/images/services/serviice-01.jpg',   'brand-work',   'gallery')],
            ['name' => 'Networking Installation',    'image' => $this->imgFromUrl('https://fidelcom.org/upload/project/1855403923878010.png',      'networking',   'gallery')],
            ['name' => 'Client Training Session',    'image' => $this->imgFromUrl('https://fidelcom.org/upload/why/1856404506915779.jpg',           'training',     'gallery')],
        ];

        foreach ($items as $item) {
            Gallery::updateOrCreate(['name' => $item['name']], $item);
        }

        $this->command->info('Gallery seeded (' . count($items) . ').');
    }

    // ──────────────────────────────────────────────
    // Processes
    // ──────────────────────────────────────────────
    private function seedProcesses(): void
    {
        $this->command->info('Downloading process images...');

        $processes = [
            [
                'title' => 'Discovery & Strategy',
                'desc'  => 'We start every project with a thorough discovery phase — understanding your business goals, target audience, competitors, and requirements. This research informs a clear project strategy and avoids costly changes later.',
                'image' => $this->imgFromUrl('https://fidelcom.org/upload/why/1856405750565317.jpg', 'discovery', 'processes'),
            ],
            [
                'title' => 'Design & Prototyping',
                'desc'  => 'Our designers translate strategy into visuals — wireframes, prototypes, and high-fidelity mockups. We iterate with your feedback until every detail is right before a single line of production code is written.',
                'image' => $this->imgFromUrl('https://fidelcom.org/upload/why/1856405956151562.jpg', 'design', 'processes'),
            ],
            [
                'title' => 'Build & Develop',
                'desc'  => 'Our engineering team builds your solution with clean, maintainable code — following best practices for performance, security, and accessibility. You receive regular progress updates and demo environments throughout.',
                'image' => $this->imgFromUrl('https://fidelcom.org/upload/why/1856406062188296.jpg', 'build', 'processes'),
            ],
            [
                'title' => 'Launch & Support',
                'desc'  => 'We manage the full launch process — testing, deployment, and go-live. After launch, we\'re available for ongoing support, training, and improvements to ensure your investment keeps delivering value.',
                'image' => $this->imgFromUrl('https://fidelcom.org/upload/why/1856406126027064.jpg', 'launch', 'processes'),
            ],
        ];

        foreach ($processes as $p) {
            Process::updateOrCreate(['title' => $p['title']], $p);
        }

        $this->command->info('Processes seeded (' . count($processes) . ').');
    }

    // ──────────────────────────────────────────────
    // Home Page (blocks)
    // ──────────────────────────────────────────────
    private function seedHomePage(): void
    {
        if (Page::where('slug', 'home')->exists()) {
            $this->command->info('Home page already exists — skipping blocks.');
            return;
        }

        $page = Page::create([
            'title'            => 'Home',
            'slug'             => 'home',
            'status'           => 'published',
            'published_at'     => now(),
            'meta_title'       => 'Fidelcom Systems Limited | IT Solutions & Digital Agency Nigeria',
            'meta_description' => 'Fidelcom Systems Limited delivers professional web development, mobile app development, branding, UI/UX design, IT consulting and networking solutions in Lagos, Nigeria.',
        ]);

        $blocks = [
            ['block_type' => 'slider',         'position' => 0,  'data' => ['autoplay' => true, 'autoplay_speed' => 5000]],
            ['block_type' => 'stats',          'position' => 1,  'data' => ['heading' => 'Our Impact in Numbers', 'source' => 'db']],
            ['block_type' => 'services_grid',  'position' => 2,  'data' => ['heading' => 'What We Do', 'sub' => 'Expert digital services tailored to your business goals', 'limit' => 6]],
            ['block_type' => 'projects_grid',  'position' => 3,  'data' => ['heading' => 'Our Work', 'sub' => 'A selection of projects we\'re proud of', 'limit' => 6]],
            ['block_type' => 'testimonials',   'position' => 4,  'data' => ['heading' => 'What Our Clients Say', 'approved_only' => true, 'limit' => 6]],
            ['block_type' => 'process_steps',  'position' => 5,  'data' => ['heading' => 'How We Work', 'sub' => 'A clear, collaborative process from first call to launch']],
            ['block_type' => 'blog_posts',     'position' => 6,  'data' => ['heading' => 'Latest Insights', 'sub' => 'Practical advice on digital, design, and technology', 'limit' => 3]],
            ['block_type' => 'partners',       'position' => 7,  'data' => ['heading' => 'Trusted By Great Businesses']],
            ['block_type' => 'faqs',           'position' => 8,  'data' => ['heading' => 'Frequently Asked Questions', 'limit' => 6]],
            ['block_type' => 'cta_banner',     'position' => 9,  'data' => [
                'heading'      => 'Ready to Start Your Project?',
                'body'         => 'Tell us about your goals and we\'ll put together a tailored proposal within 24 hours — no obligation.',
                'button_label' => 'Request a Free Quote',
                'button_url'   => '/contact-us',
                'bg_color'     => 'primary',
            ]],
        ];

        foreach ($blocks as $block) {
            $page->blocks()->create($block);
        }

        $this->command->info('Home page created with ' . count($blocks) . ' blocks.');
    }

    // ──────────────────────────────────────────────
    // Static Pages
    // ──────────────────────────────────────────────
    private function seedStaticPages(): void
    {
        $pages = [
            [
                'title'            => 'About Us',
                'slug'             => 'about',
                'status'           => 'published',
                'published_at'     => now(),
                'meta_title'       => 'About Fidelcom Systems Limited | Digital Agency Lagos Nigeria',
                'meta_description' => 'Learn about Fidelcom Systems Limited — our story, mission, values, and the expert team delivering web development, branding, and IT solutions across Nigeria.',
                'blocks'           => [
                    ['block_type' => 'hero',         'position' => 0, 'data' => ['heading' => 'About Fidelcom Systems', 'sub' => 'A team of digital specialists passionate about building technology that works.', 'bg_color' => 'primary']],
                    ['block_type' => 'content',      'position' => 1, 'data' => ['heading' => 'Who We Are', 'body' => '<p>Founded in 2020 and headquartered in Lekki, Lagos, Fidelcom Systems Limited is a full-service digital consulting agency. We help businesses across Nigeria and Africa build their digital presence, streamline their operations, and grow through technology.</p><p>Our multidisciplinary team of designers, developers, and strategists brings together creativity and technical depth to deliver solutions that create real business value — on time, on budget, and built to last.</p>', 'layout' => 'full']],
                    ['block_type' => 'stats',        'position' => 2, 'data' => ['heading' => 'Our Track Record', 'source' => 'db']],
                    ['block_type' => 'team',         'position' => 3, 'data' => ['heading' => 'Meet the Team', 'sub' => 'The people behind your project']],
                    ['block_type' => 'process_steps','position' => 4, 'data' => ['heading' => 'Our Process']],
                    ['block_type' => 'cta_banner',   'position' => 5, 'data' => ['heading' => 'Let\'s Build Something Together', 'body' => 'Have a project in mind? We\'d love to hear about it.', 'button_label' => 'Get in Touch', 'button_url' => '/contact-us', 'bg_color' => 'primary']],
                ],
            ],
            [
                'title'            => 'Contact Us',
                'slug'             => 'contact-us',
                'status'           => 'published',
                'published_at'     => now(),
                'meta_title'       => 'Contact Fidelcom Systems Limited | Lagos, Nigeria',
                'meta_description' => 'Get in touch with Fidelcom Systems Limited. Request a quote, ask a question, or discuss your project with our team in Lagos, Nigeria.',
                'blocks'           => [
                    ['block_type' => 'hero',         'position' => 0, 'data' => ['heading' => 'Get in Touch', 'sub' => 'Tell us about your project and we\'ll respond within 24 hours.', 'bg_color' => 'primary']],
                    ['block_type' => 'contact_form', 'position' => 1, 'data' => ['heading' => 'Send Us a Message', 'show_contact_info' => true]],
                ],
            ],
            [
                'title'            => 'FAQs',
                'slug'             => 'faqs',
                'status'           => 'published',
                'published_at'     => now(),
                'meta_title'       => 'Frequently Asked Questions | Fidelcom Systems Limited',
                'meta_description' => 'Answers to the most common questions about Fidelcom\'s services, pricing, timelines, and process. Start here before getting in touch.',
                'blocks'           => [
                    ['block_type' => 'hero',       'position' => 0, 'data' => ['heading' => 'Frequently Asked Questions', 'sub' => 'Everything you need to know before we talk.', 'bg_color' => 'primary']],
                    ['block_type' => 'faqs',       'position' => 1, 'data' => ['heading' => '', 'limit' => 20]],
                    ['block_type' => 'cta_banner', 'position' => 2, 'data' => ['heading' => 'Still Have Questions?', 'body' => 'Our team is happy to answer anything not covered here.', 'button_label' => 'Contact Us', 'button_url' => '/contact-us', 'bg_color' => 'surface']],
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            $blocks = $pageData['blocks'];
            unset($pageData['blocks']);

            $page = Page::firstOrCreate(['slug' => $pageData['slug']], $pageData);

            if ($page->wasRecentlyCreated && count($blocks)) {
                foreach ($blocks as $block) {
                    $page->blocks()->create($block);
                }
                $this->command->info("Page '{$pageData['slug']}' created with " . count($blocks) . ' blocks.');
            } else {
                $this->command->info("Page '{$pageData['slug']}' already exists — skipping.");
            }
        }
    }

    // ──────────────────────────────────────────────
    // Menus
    // ──────────────────────────────────────────────
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
                    ['label' => 'Blog',       'url' => '/blog'],
                ],
            ],
            [
                'name'     => 'Footer Resources',
                'location' => 'footer-resources',
                'items'    => [
                    ['label' => 'Our Team', 'url' => '/our-teams'],
                    ['label' => 'FAQs',     'url' => '/faqs'],
                    ['label' => 'Gallery',  'url' => '/gallery'],
                ],
            ],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::firstOrCreate(
                ['location' => $menuData['location']],
                ['name'     => $menuData['name']]
            );

            foreach ($menuData['items'] as $i => $item) {
                MenuItem::firstOrCreate(
                    ['menu_id' => $menu->id, 'url' => $item['url']],
                    ['label' => $item['label'], 'position' => $i, 'target' => '_self']
                );
            }
        }

        $this->command->info('Menus seeded.');
    }
}
