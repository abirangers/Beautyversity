<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'thumbnail',
        'author',
        'category',
        'tags',
        'excerpt',
        'post_type',
    ];

    /**
     * Get the article content with WordPress blocks processed
     */
    public function getProcessedContentAttribute()
    {
        return $this->processWordPressBlocks($this->content);
    }

    /**
     * Process WordPress block content to convert block comments to proper HTML
     */
    protected function processWordPressBlocks($content)
    {
        // Remove WordPress block comments but keep the HTML content inside
        $content = preg_replace('/<!--\s*wp:paragraph\s*-->\s*/', '<p class="mb-4 text-gray-700 leading-relaxed">', $content);
        $content = preg_replace('/<!--\s*\/wp:paragraph\s*-->\s*/', '</p>', $content);
        
        // Handle different heading levels - wp:heading with class names
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":1\}\s*-->\s*/', '<h1 class="text-3xl font-bold text-gray-900 mt-8 mb-4">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":2\}\s*-->\s*/', '<h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":3\}\s*-->\s*/', '<h3 class="text-xl font-bold text-gray-900 mt-6 mb-3">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*\{\"level\":4\}\s*-->\s*/', '<h4 class="text-lg font-bold text-gray-900 mt-5 mb-2">', $content);
        $content = preg_replace('/<!--\s*wp:heading\s*-->\s*/', '<h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">', $content); // fallback
        $content = preg_replace('/<!--\s*\/wp:heading\s*-->\s*/', '</h2>', $content); // default closing tag
        
        // Handle lists - remove block comments and add Tailwind styling
        $content = preg_replace('/<!--\s*wp:list\s*-->\s*/', '<ul class="list-disc pl-6 mb-4 space-y-2">', $content);
        $content = preg_replace('/<!--\s*\/wp:list\s*-->\s*/', '</ul>', $content);
        $content = preg_replace('/<!--\s*wp:list-item\s*-->\s*/', '<li class="text-gray-700">', $content);
        $content = preg_replace('/<!--\s*\/wp:list-item\s*-->\s*/', '</li>', $content);
        
        // Handle ordered lists
        $content = preg_replace('/<!--\s*wp:list\s*\{\"ordered\":true\}\s*-->\s*/', '<ol class="list-decimal pl-6 mb-4 space-y-2">', $content);
        
        // Handle other common WordPress blocks if needed
        $content = preg_replace('/<!--\s*wp:quote\s*-->\s*/', '<blockquote class="wp-block-quote border-l-4 border-primary-500 pl-4 italic text-gray-600 my-6 bg-gray-50 p-4 rounded">', $content);
        $content = preg_replace('/<!--\s*\/wp:quote\s*-->\s*/', '</blockquote>', $content);
        $content = preg_replace('/<!--\s*wp:image\s*-->\s*/', '<figure class="wp-block-image my-6 text-center">', $content);
        $content = preg_replace('/<!--\s*\/wp:image\s*-->\s*/', '</figure>', $content);
        
        // Handle strong and em tags if they appear in the content
        $content = str_replace('<strong>', '<strong class="font-bold">', $content);
        $content = str_replace('<em>', '<em class="italic">', $content);
        
        // Add styling to hyperlinks for better UX, especially for "Baca Juga" links
        $content = preg_replace('/<a\s+([^>]*?)class="([^"]*?)"/i', '<a $1class="$2 text-primary-600 hover:text-primary-800 hover:underline transition-colors duration-300"', $content);
        $content = preg_replace('/<a\s+(?![^>]*class=)/i', '<a class="text-primary-600 hover:text-primary-800 hover:underline transition-colors duration-300" ', $content);
        
        // Clean up any extra whitespace that might result from block removal
        $content = preg_replace('/\n\s*\n/', "\n\n", $content);
        $content = trim($content);
        
        return $content;
    }
}