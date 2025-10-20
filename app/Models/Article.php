<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Cviebrock\EloquentSluggable\Sluggable;

class Article extends Model
{
    use HasFactory;
    use HasRichText;
    use HasSEO;
    use Sluggable;

    protected $fillable = [
        'title',
        'content',
        'body',
        'thumbnail',
        'author',
        'excerpt',
        'post_type',
        'content_format',
        'slug',
        'scheduled_at',
        'status',
        'published_at',
    ];

    protected $richTextAttributes = [
        'body',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => false, // Slug tidak berubah saat update
                'unique' => true,
                'separator' => '-',
                'maxLength' => 100,
                'maxLengthKeepWords' => true,
            ]
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_article_category')->orderBy('name');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }

    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('name');
    }

    public function getTagNamesAttribute()
    {
        return $this->tags->pluck('name');
    }

    /**
     * Get the article content with WordPress blocks processed
     */
    public function getProcessedContentAttribute()
    {
        return match ($this->content_format) {
            'rich_text' => $this->renderRichTextContent(),
            default => $this->renderWordPressContent(),
        };
    }

    /**
     * Process WordPress block content to convert block comments to proper HTML
     */
    protected function processWordPressBlocks($content)
    {
        if (blank($content)) {
            return '';
        }

        // Remove WordPress block comments but keep the HTML content inside
        $content = preg_replace('/<!--\s*wp:paragraph\s*-->\s*/', '<p class="mb-4 text-gray-800 leading-relaxed">', $content);
        $content = preg_replace('/<!--\s*\/wp:paragraph\s*-->\s*/', '</p>', $content);

        // Handle different heading levels with proper closing tags
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":1[^\}]*\}\s*-->\s*/', '<h1 class="text-3xl font-bold text-gray-900 mt-8 mb-4">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":2[^\}]*\}\s*-->\s*/', '<h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":3[^\}]*\}\s*-->\s*/', '<h3 class="text-xl font-bold text-gray-900 mt-6 mb-3">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":4[^\}]*\}\s*-->\s*/', '<h4 class="text-lg font-bold text-gray-900 mt-5 mb-2">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":5[^\}]*\}\s*-->\s*/', '<h5 class="text-base font-bold text-gray-900 mt-4 mb-2">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":6[^\}]*\}\s*-->\s*/', '<h6 class="text-sm font-bold text-gray-900 mt-3 mb-2">', $content);
        
        // Handle heading without level (default to h2)
        $content = preg_replace('/<!--\s*wp:heading\s*-->\s*/', '<h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">', $content);
        
        // Replace closing tags individually for each level
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*<\/h1>/', '</h1>', $content);
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*<\/h2>/', '</h2>', $content);
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*<\/h3>/', '</h3>', $content);
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*<\/h4>/', '</h4>', $content);
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*<\/h5>/', '</h5>', $content);
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*<\/h6>/', '</h6>', $content);

        // Catch any remaining closing heading comments
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*/', '', $content);

        // Process WordPress blocks with wp-block-heading className to make them larger
        $content = preg_replace('/<!--\s*wp:heading\s*(\{[^\}]*\"level\":2[^\}]*\"className\":\"wp-block-heading\"[^\}]*)\}\s*-->\s*/', '<h2 class="wp-block-heading text-3xl font-bold text-gray-900 mt-8 mb-4">', $content);

        // Handle h2 elements with wp-block-heading class to make them slightly larger
        $content = str_replace('<h2 class="wp-block-heading">', '<h2 class="wp-block-heading text-3xl">', $content);

        // Also handle h2 elements with wp-block-heading class that contain strong tags
        $content = preg_replace('/<h2 class="wp-block-heading">(<strong[^>]*>.*?<\/strong>)/i', '<h2 class="wp-block-heading text-3xl">$1', $content);

        // Handle lists - remove block comments and add Tailwind styling
        $content = preg_replace('/<!--\s*wp:list\s*-->\s*/', '<ul class="list-disc pl-6 mb-4 space-y-2">', $content);
        $content = preg_replace('/<!--\s*\/wp:list\s*-->\s*/', '</ul>', $content);
        $content = preg_replace('/<!--\s*wp:list-item\s*-->\s*/', '<li class="text-gray-800">', $content);
        $content = preg_replace('/<!--\s*\/wp:list-item\s*-->\s*/', '</li>', $content);

        // Handle ordered lists
        $content = preg_replace('/<!--\s*wp:list\s*\{\"ordered\":true\}\s*-->\s*/', '<ol class="list-decimal pl-6 mb-4 space-y-2">', $content);

        // Handle other common WordPress blocks if needed
        $content = preg_replace('/<!--\s*wp:quote\s*-->\s*/', '<blockquote class="wp-block-quote border-l-4 border-primary-500 pl-4 italic text-gray-600 my-6 bg-gray-50 p-4 rounded">', $content);
        $content = preg_replace('/<!--\s*\/wp:quote\s*-->\s*/', '</blockquote>', $content);
        $content = preg_replace('/<!--\s*wp:image\s*-->\s*/', '<figure class="wp-block-image my-6 text-center">', $content);
        $content = preg_replace('/<!--\s*\/wp:image\s*-->\s*/', '</figure>', $content);

        // Handle strong and em tags - add class if not present
        $content = preg_replace('/<strong(?![^>]*class=)([^>]*)>/i', '<strong class="font-bold"$1>', $content);
        $content = preg_replace('/<em(?![^>]*class=)([^>]*)>/i', '<em class="italic"$1>', $content);

        // Add styling to hyperlinks for better UX
        // For links with existing classes, append our classes
        $content = preg_replace_callback(
            '/<a\s+([^>]*?)class="([^"]*?)"/i',
            function ($matches) {
                $classes = $matches[2];
                // Only add if primary classes not already present
                if (!str_contains($classes, 'text-primary')) {
                    $classes .= ' text-primary-600 hover:text-primary-800 hover:underline transition-colors duration-300';
                }
                return '<a ' . $matches[1] . 'class="' . trim($classes) . '"';
            },
            $content
        );
        // For links without classes
        $content = preg_replace('/<a\s+(?![^>]*class=)/i', '<a class="text-primary-600 hover:text-primary-800 hover:underline transition-colors duration-300" ', $content);

        // Clean up any extra whitespace that might result from block removal
        $content = preg_replace('/\n\s*\n/', "\n\n", $content);
        $content = trim($content);

        return $content;
    }

    protected function renderRichTextContent(): string
    {
        return $this->body ? (string) $this->body : '';
    }

    protected function renderWordPressContent(): string
    {
        return $this->processWordPressBlocks($this->content ?? '');
    }

    /**
     * Get dynamic SEO data for this article
     */
    public function getDynamicSEOData(): \RalphJSmit\Laravel\SEO\Support\SEOData
    {
        return new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: $this->title,
            description: $this->excerpt ?: \Str::limit(strip_tags($this->content ?? ''), 160),
            author: $this->author ?: 'Kelas Digital Team',
            image: $this->thumbnail ?: '/logo.webp',
            url: route('article.show', $this->slug),
            published_time: $this->published_at ?? $this->created_at,
            modified_time: $this->updated_at,
            tags: $this->tagNames->toArray(),
            section: $this->categories->first()?->name,
        );
    }

    // ==================== SCHEDULING FUNCTIONALITY ====================

    /**
     * Scope to get only published articles (for public display)
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where(function ($q) {
                        $q->whereNull('scheduled_at')
                          ->orWhere('scheduled_at', '<=', now());
                    });
    }

    /**
     * Scope to get only scheduled articles
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '>', now());
    }

    /**
     * Scope to get only draft articles
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope to get articles ready to be published (scheduled time has passed)
     */
    public function scopeReadyToPublish($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '<=', now());
    }

    /**
     * Check if article is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && 
               ($this->scheduled_at === null || $this->scheduled_at <= now());
    }

    /**
     * Check if article is scheduled
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled' && 
               $this->scheduled_at > now();
    }

    /**
     * Check if article is draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Publish the article
     */
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Schedule the article for future publication
     */
    public function schedule(\DateTime $scheduledAt): bool
    {
        return $this->update([
            'status' => 'scheduled',
            'scheduled_at' => $scheduledAt,
        ]);
    }

    /**
     * Unschedule the article (make it draft)
     */
    public function unschedule(): bool
    {
        return $this->update([
            'status' => 'draft',
            'scheduled_at' => null,
        ]);
    }

    /**
     * Get the effective published date (published_at or created_at)
     */
    public function getEffectivePublishedAtAttribute(): \DateTime
    {
        return $this->published_at ?? $this->created_at;
    }
}
