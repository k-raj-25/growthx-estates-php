<?php

namespace App\Console\Commands;

use App\Models\AwardRecognition;
use App\Models\BlogPost;
use App\Models\CareersSettings;
use App\Models\City;
use App\Models\JobOpening;
use App\Models\NewsEventsItem;
use App\Models\Property;
use App\Models\SiteEnquiry;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ImportDjangoData extends Command
{
    protected $signature = 'import:django {json : Path to dumpdata JSON}';

    protected $description = 'Import Django dumpdata JSON into Laravel website_* tables';

    public function handle(): int
    {
        $path = (string) $this->argument('json');
        if (!file_exists($path)) {
            $this->error("File not found: {$path}");
            return self::FAILURE;
        }

        $rows = json_decode((string) file_get_contents($path), true);
        if (!is_array($rows)) {
            $this->error('Invalid JSON payload.');
            return self::FAILURE;
        }

        $userMap = [];
        foreach ($rows as $row) {
            if (($row['model'] ?? '') !== 'auth.user') {
                continue;
            }
            $fields = $row['fields'] ?? [];
            $user = User::query()->updateOrCreate(
                ['email' => $fields['email'] ?: ($fields['username'].'@local.invalid')],
                ['name' => $fields['username'] ?? 'user', 'password' => Hash::make('ChangeMe123!')]
            );
            $userMap[(int) $row['pk']] = $user->id;
        }

        foreach ($rows as $row) {
            $model = $row['model'] ?? '';
            $pk = (int) ($row['pk'] ?? 0);
            $f = $row['fields'] ?? [];

            match ($model) {
                'website.city' => City::query()->updateOrCreate(['id' => $pk], ['name' => $f['name'] ?? '', 'slug' => $f['slug'] ?? null, 'sort_order' => $f['sort_order'] ?? 0]),
                'website.property' => Property::query()->updateOrCreate(['id' => $pk], [
                    'slug' => $f['slug'] ?? null, 'name' => $f['name'] ?? '', 'city_id' => $f['city'] ?? null, 'location' => $f['location'] ?? '',
                    'price_display' => $f['price_display'] ?? '', 'rating' => $f['rating'] ?? 4.5, 'status' => $f['status'] ?? 'Ready to move',
                    'project_type' => $f['project_type'] ?? 'residential', 'brochure_url' => $f['brochure_url'] ?? null, 'description' => $f['description'] ?? '',
                    'developer_name' => $f['developer_name'] ?? '', 'about_developer' => $f['about_developer'] ?? '', 'rera_id' => $f['rera_id'] ?? '',
                    'project_size' => $f['project_size'] ?? '', 'map_embed_url' => $f['map_embed_url'] ?? '', 'images' => $f['images'] ?? [],
                    'amenities' => $f['amenities'] ?? [], 'videos' => $f['videos'] ?? [], 'faq' => $f['faq'] ?? [], 'is_published' => $f['is_published'] ?? true,
                    'is_featured' => $f['is_featured'] ?? false,
                    'sort_order' => $f['sort_order'] ?? 0,
                ]),
                'website.siteenquiry' => SiteEnquiry::query()->updateOrCreate(['id' => $pk], [
                    'enquiry_type' => $f['enquiry_type'] ?? 'contact', 'name' => $f['name'] ?? '', 'phone' => $f['phone'] ?? '',
                    'message' => $f['message'] ?? null, 'property_id' => $f['property'] ?? null, 'created_at' => $f['created_at'] ?? now(),
                ]),
                'website.blogpost' => BlogPost::query()->updateOrCreate(['id' => $pk], [
                    'title' => $f['title'] ?? '', 'slug' => $f['slug'] ?? null, 'excerpt' => $f['excerpt'] ?? null, 'body' => $f['body'] ?? '',
                    'featured_image' => $f['featured_image'] ?? null, 'featured_image_url' => $f['featured_image_url'] ?? null,
                    'author_id' => isset($f['author']) ? ($userMap[(int) $f['author']] ?? null) : null, 'is_published' => $f['is_published'] ?? false,
                    'published_at' => $f['published_at'] ?? null,
                ]),
                'website.newseventsitem' => NewsEventsItem::query()->updateOrCreate(['id' => $pk], [
                    'section' => $f['section'] ?? 'news', 'title' => $f['title'] ?? '', 'summary' => $f['summary'] ?? null,
                    'image' => $f['image'] ?? null, 'image_url' => $f['image_url'] ?? null, 'link_url' => $f['link_url'] ?? null,
                    'is_published' => $f['is_published'] ?? true, 'sort_order' => $f['sort_order'] ?? 0,
                ]),
                'website.awardrecognition' => AwardRecognition::query()->updateOrCreate(['id' => $pk], [
                    'title' => $f['title'] ?? '', 'issuer' => $f['issuer'] ?? null, 'year_label' => $f['year_label'] ?? null,
                    'summary' => $f['summary'] ?? null, 'image' => $f['image'] ?? null, 'image_url' => $f['image_url'] ?? null,
                    'link_url' => $f['link_url'] ?? null, 'is_published' => $f['is_published'] ?? true, 'sort_order' => $f['sort_order'] ?? 0,
                ]),
                'website.careerssettings' => CareersSettings::query()->updateOrCreate(['id' => 1], ['hr_email' => $f['hr_email'] ?? 'hello@growthestates.com']),
                'website.jobopening' => JobOpening::query()->updateOrCreate(['id' => $pk], [
                    'title' => $f['title'] ?? '', 'department' => $f['department'] ?? null, 'location' => $f['location'] ?? null,
                    'employment_type' => $f['employment_type'] ?? 'full_time', 'description' => $f['description'] ?? '',
                    'responsibilities' => $f['responsibilities'] ?? null, 'qualifications' => $f['qualifications'] ?? null,
                    'is_published' => $f['is_published'] ?? true, 'sort_order' => $f['sort_order'] ?? 0,
                ]),
                default => null,
            };
        }

        $this->info('Import completed.');

        return self::SUCCESS;
    }
}
