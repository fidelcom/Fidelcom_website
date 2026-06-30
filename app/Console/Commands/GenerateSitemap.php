<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the XML sitemap for fidelcom.org';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create('/about')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/all-services')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/portfolio')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/blog')->setPriority(0.8)->setChangeFrequency('weekly'));
        $sitemap->add(Url::create('/contact-us')->setPriority(0.7)->setChangeFrequency('yearly'));
        $sitemap->add(Url::create('/our-teams')->setPriority(0.6)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/galleries')->setPriority(0.6)->setChangeFrequency('monthly'));

        // Blog posts
        Post::whereNotNull('slug')->latest()->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.show', $post))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency('monthly')
                    ->setPriority(0.7)
            );
        });

        // Projects
        Project::whereNotNull('slug')->latest()->get()->each(function (Project $project) use ($sitemap) {
            $sitemap->add(
                Url::create(route('all-projects.show', $project))
                    ->setLastModificationDate($project->updated_at)
                    ->setChangeFrequency('monthly')
                    ->setPriority(0.7)
            );
        });

        // Services
        Service::whereNotNull('slug')->latest()->get()->each(function (Service $service) use ($sitemap) {
            $sitemap->add(
                Url::create(route('all-services.show', $service))
                    ->setLastModificationDate($service->updated_at)
                    ->setChangeFrequency('monthly')
                    ->setPriority(0.8)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated at public/sitemap.xml');
    }
}
