<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\CareersSettings;
use App\Models\City;
use App\Models\JobOpening;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->firstOrCreate(
            ['email' => 'editor@growthxestates.com'],
            ['name' => 'GrowthX Editorial', 'password' => bcrypt('password')]
        );

        $cityRows = [
            ['name' => 'New York', 'sort_order' => 1],
            ['name' => 'Miami', 'sort_order' => 2],
            ['name' => 'Chicago', 'sort_order' => 3],
            ['name' => 'Austin', 'sort_order' => 4],
            ['name' => 'Los Angeles', 'sort_order' => 5],
            ['name' => 'San Francisco', 'sort_order' => 6],
            ['name' => 'Seattle', 'sort_order' => 7],
            ['name' => 'Boston', 'sort_order' => 8],
        ];

        $cities = collect($cityRows)->mapWithKeys(function (array $row) {
            $city = City::query()->updateOrCreate(
                ['name' => $row['name']],
                ['sort_order' => $row['sort_order']]
            );

            return [$row['name'] => $city];
        });

        $properties = [
            [
                'slug' => 'skyline-residence',
                'name' => 'Skyline Residence',
                'city' => 'New York',
                'location' => 'Midtown Manhattan',
                'price_display' => '$1.25M',
                'rating' => 4.8,
                'status' => 'Ready to move',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/skyline-residence.pdf',
                'description' => 'A premium high-rise address with panoramic skyline views and private club amenities.',
                'developer_name' => 'Northline Developments',
                'about_developer' => 'Northline Developments is known for design-led urban towers in global gateway cities.',
                'rera_id' => 'NY-RERA-11342',
                'project_size' => '2.8 acres | 3 towers | 420 residences',
                'map_embed_url' => 'https://www.google.com/maps?q=40.7549,-73.9840&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&q=80',
                    'https://images.unsplash.com/photo-1460317442991-0ec209397118?w=1200&q=80',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80',
                ],
                'amenities' => ['Infinity pool', 'Concierge', 'Fitness suite', 'Rooftop terrace', 'Smart security'],
            ],
            [
                'slug' => 'azure-villa',
                'name' => 'Azure Villa',
                'city' => 'Miami',
                'location' => 'Coconut Grove',
                'price_display' => '$2.5M',
                'rating' => 4.9,
                'status' => 'Ready to move',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/azure-villa.pdf',
                'description' => 'Contemporary waterfront villas with private decks and curated concierge services.',
                'developer_name' => 'Azure Living',
                'about_developer' => 'Azure Living delivers waterfront residences that blend tropical design and privacy.',
                'rera_id' => 'FL-RERA-91420',
                'project_size' => '4.1 acres | 64 villas',
                'map_embed_url' => 'https://www.google.com/maps?q=25.7280,-80.2436&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80',
                    'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1200&q=80',
                ],
                'amenities' => ['Pool deck', 'Outdoor kitchen', 'Wine lounge', 'EV charging', 'Pet spa'],
            ],
            [
                'slug' => 'heritage-row',
                'name' => 'Heritage Row',
                'city' => 'Chicago',
                'location' => 'West Loop',
                'price_display' => '$850K',
                'rating' => 4.6,
                'status' => 'Under construction',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/heritage-row.pdf',
                'description' => 'Boutique townhomes with classic facades, smart interiors, and flexible workspaces.',
                'developer_name' => 'Harbor & Stone',
                'about_developer' => 'Harbor & Stone focuses on neighborhood-first projects with timeless architecture.',
                'rera_id' => 'IL-RERA-72103',
                'project_size' => '1.9 acres | 48 homes',
                'map_embed_url' => 'https://www.google.com/maps?q=41.8826,-87.6441&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80',
                    'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200&q=80',
                    'https://images.unsplash.com/photo-1513584684374-8bab748fbf90?w=1200&q=80',
                ],
                'amenities' => ['Co-working lounge', 'Bike storage', 'Parcel lockers', 'Fitness studio', 'Garden court'],
            ],
            [
                'slug' => 'pacific-heights-reserve',
                'name' => 'Pacific Heights Reserve',
                'city' => 'San Francisco',
                'location' => 'Pacific Heights',
                'price_display' => '$3.1M',
                'rating' => 4.9,
                'status' => 'Ready to move',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/pacific-heights-reserve.pdf',
                'description' => 'Hilltop residences with bay views, private lounge floors, and signature concierge services.',
                'developer_name' => 'West Harbor Group',
                'about_developer' => 'West Harbor Group builds design-forward residences in premium west coast neighborhoods.',
                'rera_id' => 'CA-RERA-44188',
                'project_size' => '3.4 acres | 2 towers | 210 residences',
                'map_embed_url' => 'https://www.google.com/maps?q=37.7928,-122.4376&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1200&q=80',
                    'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=1200&q=80',
                    'https://images.unsplash.com/photo-1494526585095-c41746248156?w=1200&q=80',
                ],
                'amenities' => ['Infinity pool', 'Rooftop lounge', 'Wine cellar', 'Valet parking', 'Smart security'],
            ],
            [
                'slug' => 'marina-grove-estates',
                'name' => 'Marina Grove Estates',
                'city' => 'Los Angeles',
                'location' => 'Marina del Rey',
                'price_display' => '$2.9M',
                'rating' => 4.7,
                'status' => 'Under construction',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/marina-grove-estates.pdf',
                'description' => 'Waterfront residences with expansive decks and curated wellness amenities.',
                'developer_name' => 'Blue Crest Living',
                'about_developer' => 'Blue Crest Living specializes in lifestyle waterfront communities.',
                'rera_id' => 'CA-RERA-88210',
                'project_size' => '5.0 acres | 140 residences',
                'map_embed_url' => 'https://www.google.com/maps?q=33.9803,-118.4517&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=1200&q=80',
                    'https://images.unsplash.com/photo-1600047509782-20d39509f26d?w=1200&q=80',
                    'https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=1200&q=80',
                ],
                'amenities' => ['Pool deck', 'Pet spa', 'Co-working lounge', 'EV charging', 'Private marina access'],
            ],
            [
                'slug' => 'east-river-suites',
                'name' => 'East River Suites',
                'city' => 'New York',
                'location' => 'Long Island City',
                'price_display' => '$1.05M',
                'rating' => 4.5,
                'status' => 'New launch',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/east-river-suites.pdf',
                'description' => 'Contemporary city suites with skyline decks and smart-home integration.',
                'developer_name' => 'Urban Arc Developers',
                'about_developer' => 'Urban Arc develops transit-oriented premium towers in high-growth corridors.',
                'rera_id' => 'NY-RERA-55603',
                'project_size' => '1.6 acres | 1 tower | 320 suites',
                'map_embed_url' => 'https://www.google.com/maps?q=40.7447,-73.9485&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1200&q=80',
                    'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1200&q=80',
                    'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&q=80',
                ],
                'amenities' => ['Fitness studio', 'Parcel lockers', 'Rooftop terrace', 'Bike storage', 'Concierge'],
            ],
            [
                'slug' => 'austin-tech-park-sco',
                'name' => 'Austin Tech Park SCO',
                'city' => 'Austin',
                'location' => 'Domain District',
                'price_display' => '$1.9M',
                'rating' => 4.6,
                'status' => 'Ready to move',
                'project_type' => 'sco',
                'brochure_url' => 'https://example.com/brochures/austin-tech-park-sco.pdf',
                'description' => 'High-street SCO units designed for premium retail, office, and hospitality use.',
                'developer_name' => 'Summit Commercial',
                'about_developer' => 'Summit Commercial delivers flexible mixed-use assets in growth cities.',
                'rera_id' => 'TX-RERA-77021',
                'project_size' => '2.2 acres | 36 SCO plots',
                'map_embed_url' => 'https://www.google.com/maps?q=30.3996,-97.7250&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80',
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&q=80',
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=1200&q=80',
                ],
                'amenities' => ['EV charging', 'Visitor parking', 'Security', 'Storage', 'Shuttle connectivity'],
            ],
            [
                'slug' => 'seaport-signature-offices',
                'name' => 'Seaport Signature Offices',
                'city' => 'Boston',
                'location' => 'Seaport',
                'price_display' => '$2.2M',
                'rating' => 4.7,
                'status' => 'Under construction',
                'project_type' => 'commercial',
                'brochure_url' => 'https://example.com/brochures/seaport-signature-offices.pdf',
                'description' => 'Grade-A office suites with hospitality-level lobbies and executive amenities.',
                'developer_name' => 'Northeast Holdings',
                'about_developer' => 'Northeast Holdings focuses on premium office and mixed-use developments.',
                'rera_id' => 'MA-RERA-39011',
                'project_size' => '2.9 acres | 1 campus | 510,000 sq ft',
                'map_embed_url' => 'https://www.google.com/maps?q=42.3505,-71.0468&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&q=80',
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=1200&q=80',
                    'https://images.unsplash.com/photo-1460472178825-e5240623afd5?w=1200&q=80',
                ],
                'amenities' => ['Concierge', 'Co-working', 'Dining plaza', 'Fitness center', 'Smart access'],
            ],
            [
                'slug' => 'emerald-lake-villas',
                'name' => 'Emerald Lake Villas',
                'city' => 'Seattle',
                'location' => 'Lake Union',
                'price_display' => '$2.15M',
                'rating' => 4.8,
                'status' => 'New launch',
                'project_type' => 'residential',
                'brochure_url' => 'https://example.com/brochures/emerald-lake-villas.pdf',
                'description' => 'Nature-integrated villas with lake-facing decks and wellness-centric community spaces.',
                'developer_name' => 'Emerald Urban',
                'about_developer' => 'Emerald Urban blends sustainable design with premium community planning.',
                'rera_id' => 'WA-RERA-66104',
                'project_size' => '3.7 acres | 92 villas',
                'map_embed_url' => 'https://www.google.com/maps?q=47.6394,-122.3360&output=embed',
                'images' => [
                    'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=1200&q=80',
                    'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=1200&q=80',
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200&q=80',
                ],
                'amenities' => ['Yoga deck', 'Garden trails', 'Pet-friendly park', 'Rooftop lounge', 'Security'],
            ],
        ];

        foreach ($properties as $i => $row) {
            Property::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'city_id' => $cities[$row['city']]->id ?? null,
                    'location' => $row['location'],
                    'price_display' => $row['price_display'],
                    'rating' => $row['rating'],
                    'status' => $row['status'],
                    'project_type' => $row['project_type'],
                    'brochure_url' => $row['brochure_url'],
                    'description' => $row['description'],
                    'developer_name' => $row['developer_name'],
                    'about_developer' => $row['about_developer'],
                    'rera_id' => $row['rera_id'],
                    'project_size' => $row['project_size'],
                    'map_embed_url' => $row['map_embed_url'],
                    'images' => $row['images'],
                    'amenities' => $row['amenities'],
                    'videos' => [
                        ['title' => 'Project walkthrough', 'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
                    ],
                    'faq' => [
                        ['q' => 'When is possession?', 'a' => 'Possession timeline is shared after reservation and agreement signing.'],
                        ['q' => 'Is financing available?', 'a' => 'Yes. Our team can connect you with partner lenders.'],
                    ],
                    'is_published' => true,
                    'sort_order' => $i + 1,
                ]
            );
        }

        $blogRows = [
            [
                'title' => 'How to evaluate a luxury home beyond the brochure',
                'excerpt' => 'A practical framework for comparing premium listings on design, utility, and long-term value.',
                'body' => '<p>Luxury value is built on location resilience, floor-plan function, and execution quality. In this guide we break down how to tour with a checklist that surfaces long-term advantages and hidden risks.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&q=80',
            ],
            [
                'title' => 'What high-intent buyers expect during private tours',
                'excerpt' => 'From pre-reads to route planning, details that shape a confident decision-making experience.',
                'body' => '<p>Great tours are structured, contextual, and paced for decision-making. We share the process we use to help buyers compare homes clearly and move with confidence.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200&q=80',
            ],
            [
                'title' => '2026 market pulse: inventory, pricing, and timing',
                'excerpt' => 'What current inventory and buyer demand suggest for sellers and strategic buyers this season.',
                'body' => '<p>Inventory conditions vary by micro-market. This pulse report outlines what matters most for pricing strategy, offer terms, and negotiation leverage.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80',
            ],
            [
                'title' => 'Design features that preserve long-term resale value',
                'excerpt' => 'How layout, daylight, and material choices influence durability and buyer appeal over time.',
                'body' => '<p>Timeless layouts and well-executed fundamentals consistently outperform trend-driven updates. We outline what to prioritize when evaluating premium homes.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1200&q=80',
            ],
            [
                'title' => 'Negotiation playbook for competitive luxury markets',
                'excerpt' => 'A practical framework for structuring offers that protect downside while staying competitive.',
                'body' => '<p>Strong offers are more than headline numbers. We review contingencies, timelines, and communication tactics that improve acceptance odds without overexposure.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200&q=80',
            ],
            [
                'title' => 'Waterfront buying checklist: risk, insurance, and upkeep',
                'excerpt' => 'What buyers should inspect beyond views: flood maps, maintenance cycles, and reserve planning.',
                'body' => '<p>Waterfront ownership can be exceptional when diligence is thorough. This checklist covers the structural, legal, and operational details buyers should review.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=1200&q=80',
            ],
            [
                'title' => 'How to prepare your home for a high-intent showing',
                'excerpt' => 'Staging and presentation tactics that shorten decision cycles and improve offer quality.',
                'body' => '<p>Preparation creates momentum. We share the sequence we use to align styling, lighting, and narrative before private showings.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=1200&q=80',
            ],
            [
                'title' => 'Second-home strategy: lifestyle first, numbers always',
                'excerpt' => 'Balancing personal use with operating costs, tax implications, and rental optionality.',
                'body' => '<p>A successful second-home purchase starts with clear usage goals and realistic carrying assumptions. We walk through a balanced decision framework.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80',
            ],
            [
                'title' => 'Reading neighborhood momentum before it hits headlines',
                'excerpt' => 'Signals we monitor weekly to identify early shifts in demand and pricing power.',
                'body' => '<p>Neighborhood momentum often appears in micro-signals before broad data catches up. Here is how we track those signals for clients making timing decisions.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80',
            ],
        ];

        foreach ($blogRows as $i => $row) {
            BlogPost::query()->updateOrCreate(
                ['title' => $row['title']],
                [
                    'excerpt' => $row['excerpt'],
                    'body' => $row['body'],
                    'featured_image_url' => $row['featured_image_url'],
                    'author_id' => $author->id,
                    'is_published' => true,
                    'published_at' => now()->subDays($i * 5),
                ]
            );
        }

        CareersSettings::query()->updateOrCreate(['id' => 1], ['hr_email' => 'careers@growthxestates.com']);

        $jobs = [
            [
                'title' => 'Luxury Property Advisor',
                'department' => 'Advisory',
                'location' => 'New York (Hybrid)',
                'employment_type' => 'full_time',
                'description' => 'Lead buyer consultations, curate shortlists, and manage high-touch tour experiences.',
                'responsibilities' => "- Lead client discovery calls and needs analysis\n- Coordinate property tours and market briefs\n- Negotiate offer terms with seller agents",
                'qualifications' => "- 3+ years in residential sales or advisory\n- Strong communication and negotiation skills\n- Discretion with high-profile clientele",
            ],
            [
                'title' => 'Marketing & Content Associate',
                'department' => 'Marketing',
                'location' => 'Remote',
                'employment_type' => 'full_time',
                'description' => 'Own listing narratives, campaign briefs, and editorial content for premium audiences.',
                'responsibilities' => "- Write listing copy and campaign assets\n- Coordinate creative production with design partners\n- Track campaign performance and recommend optimizations",
                'qualifications' => "- Portfolio of digital content work\n- Experience with editorial calendars\n- Real-estate or luxury brand exposure preferred",
            ],
            [
                'title' => 'Summer Internship — Market Research',
                'department' => 'Research',
                'location' => 'Chicago',
                'employment_type' => 'internship',
                'description' => 'Support pricing analysis and comp tracking across active neighborhoods.',
                'responsibilities' => "- Gather listing and transaction comps\n- Build neighborhood snapshots and dashboards\n- Support weekly market updates",
                'qualifications' => "- Current undergraduate or postgraduate student\n- Strong Excel or Sheets proficiency\n- Clear written communication",
            ],
        ];

        foreach ($jobs as $i => $job) {
            JobOpening::query()->updateOrCreate(
                ['title' => $job['title']],
                $job + ['is_published' => true, 'sort_order' => $i + 1]
            );
        }
    }
}

