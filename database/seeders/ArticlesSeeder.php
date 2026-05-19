<?php

namespace Database\Seeders;

use App\Models\Article;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $baseDate = CarbonImmutable::parse('2026-05-19');

        $articles = [
            [
                'title' => 'How to Choose the Right Custom Strap',
                'category' => 'Guide',
                'description' => 'A quick guide to choosing strap materials, sizes, and finishing details for custom orders.',
            ],
            [
                'title' => 'Artwork Checklist Before Production',
                'category' => 'Artwork',
                'description' => 'Check file formats, safe areas, colors, and print-ready details before sending artwork.',
            ],
            [
                'title' => 'Hotstrap Product Setup Tips',
                'category' => 'Product',
                'description' => 'Practical tips for configuring Hotstrap products with the right options and gallery images.',
            ],
            [
                'title' => 'Hotmobily Display Ideas for Events',
                'category' => 'Product',
                'description' => 'Ideas for using Hotmobily products at launches, exhibitions, and corporate events.',
            ],
            [
                'title' => 'Material Comparison for Daily Use',
                'category' => 'Material',
                'description' => 'Compare common product materials by texture, durability, and visual style.',
            ],
            [
                'title' => 'Simple Ways to Improve Brand Visibility',
                'category' => 'Branding',
                'description' => 'Small product design choices that can make logos and campaign messages easier to notice.',
            ],
            [
                'title' => 'Preparing Bulk Orders Without Delays',
                'category' => 'Production',
                'description' => 'Steps customers can take to keep bulk custom product orders moving smoothly.',
            ],
            [
                'title' => 'Color Selection Tips for Custom Products',
                'category' => 'Design',
                'description' => 'How to choose colors that match your brand while staying clear and readable.',
            ],
            [
                'title' => 'What to Check in a Product Proof',
                'category' => 'Artwork',
                'description' => 'Review size, alignment, colors, and spelling before approving a production proof.',
            ],
            [
                'title' => 'Event Giveaway Planning Guide',
                'category' => 'Guide',
                'description' => 'Plan useful giveaway products by matching audience, budget, and event schedule.',
            ],
            [
                'title' => 'Premium Finishing Options Explained',
                'category' => 'Design',
                'description' => 'A simple overview of premium finishes and when they are worth using.',
            ],
            [
                'title' => 'How Quantity Affects Product Pricing',
                'category' => 'Pricing',
                'description' => 'Understand quantity tiers and why larger orders can reduce the unit price.',
            ],
            [
                'title' => 'Custom Product Trends for 2026',
                'category' => 'Trends',
                'description' => 'A look at practical, clean, and brand-focused custom product trends.',
            ],
            [
                'title' => 'Choosing Templates for Faster Artwork',
                'category' => 'Artwork',
                'description' => 'Use artwork templates to reduce setup time and keep designs consistent.',
            ],
            [
                'title' => 'Product Photography Tips for Online Stores',
                'category' => 'Marketing',
                'description' => 'Improve product listing quality with clear angles, lighting, and image order.',
            ],
            [
                'title' => 'Common Mistakes in Custom Orders',
                'category' => 'Guide',
                'description' => 'Avoid common issues with artwork, quantities, deadlines, and option selection.',
            ],
            [
                'title' => 'How to Organize Product Options',
                'category' => 'Product',
                'description' => 'Group options clearly so customers can configure products with less friction.',
            ],
            [
                'title' => 'Designing Products for Corporate Teams',
                'category' => 'Branding',
                'description' => 'Tips for matching custom products with team identity and internal events.',
            ],
            [
                'title' => 'Shipping Timeline Basics for Campaigns',
                'category' => 'Production',
                'description' => 'Plan production and shipping timelines around campaign launch dates.',
            ],
            [
                'title' => 'Using Gallery Images to Build Trust',
                'category' => 'Marketing',
                'description' => 'Show details, scale, and real-world usage with a stronger product image gallery.',
            ],
        ];

        foreach ($articles as $index => $article) {
            $number = $index + 1;
            $translationKey = 'test_article_' . str_pad((string) $number, 2, '0', STR_PAD_LEFT);

            Article::updateOrCreate(
                [
                    'translation_key' => $translationKey,
                    'language' => 'pt',
                ],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'article_date' => $baseDate->subDays($index)->toDateString(),
                    'detail' => $this->detailHtml($article['title'], $article['description']),
                    'cover_image' => null,
                    'description' => $article['description'],
                    'is_active' => 1,
                ]
            );
        }
    }

    private function detailHtml(string $title, string $description): string
    {
        return <<<HTML
<h2>{$title}</h2>
<p>{$description}</p>
<p>This is test article content for layout review, pagination checks, search filters, and blog detail page testing.</p>
<ul>
    <li>Review how the card looks on the blog index page.</li>
    <li>Check category filtering and newest/oldest sorting.</li>
    <li>Open the detail page to confirm long content spacing.</li>
</ul>
HTML;
    }
}
