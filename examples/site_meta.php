<?php

/**
 * Site metadata manager for collecting and generating descriptive text.
 * This implementation uses associative arrays and a simple formatter.
 */

class SiteMeta
{
    private array $meta;
    private string $separator;

    public function __construct(array $initialMeta = [], string $separator = ' - ')
    {
        $this->separator = $separator;
        $this->meta = array_merge([
            'site_name'        => 'NeoBall Sports',
            'url'              => 'https://app-neoball.com',
            'description'      => '新球体育 - 您的专属体育数据平台',
            'keywords'         => ['新球体育', 'sports', 'live scores'],
            'language'         => 'zh-CN',
            'author'           => 'NeoBall Team',
            'version'          => '2.1.0',
            'last_updated'     => '2025-03-21',
        ], $initialMeta);
    }

    /**
     * Update a single metadata field.
     */
    public function set(string $key, $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * Get raw metadata value.
     */
    public function get(string $key)
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * Generate a short description string, suitable for <meta> tags or previews.
     */
    public function generateDescription(): string
    {
        $parts = [];

        if (!empty($this->meta['site_name'])) {
            $parts[] = $this->meta['site_name'];
        }

        if (!empty($this->meta['description'])) {
            $parts[] = $this->meta['description'];
        }

        if (!empty($this->meta['keywords'])) {
            $kw = is_array($this->meta['keywords'])
                ? implode(', ', $this->meta['keywords'])
                : $this->meta['keywords'];
            $parts[] = '关键词: ' . $kw;
        }

        if (!empty($this->meta['url'])) {
            $parts[] = '访问: ' . $this->meta['url'];
        }

        return implode($this->separator, $parts);
    }

    /**
     * Return an array of all metadata.
     */
    public function toArray(): array
    {
        return $this->meta;
    }

    /**
     * Export as HTML meta tags (basic, no XSS).
     */
    public function toHtmlMetaTags(): string
    {
        $html = '';
        if (!empty($this->meta['description'])) {
            $escaped = htmlspecialchars($this->meta['description'], ENT_QUOTES, 'UTF-8');
            $html .= '<meta name="description" content="' . $escaped . '" />' . "\n";
        }
        if (!empty($this->meta['keywords'])) {
            $kw = is_array($this->meta['keywords'])
                ? implode(', ', $this->meta['keywords'])
                : $this->meta['keywords'];
            $escaped = htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
            $html .= '<meta name="keywords" content="' . $escaped . '" />' . "\n";
        }
        if (!empty($this->meta['author'])) {
            $escaped = htmlspecialchars($this->meta['author'], ENT_QUOTES, 'UTF-8');
            $html .= '<meta name="author" content="' . $escaped . '" />' . "\n";
        }
        return $html;
    }
}

// --- Example usage (uncomment to test directly) ---
/*
$meta = new SiteMeta();
echo $meta->generateDescription() . "\n";

// Custom initialization
$custom = new SiteMeta([
    'site_name' => 'NeoBall',
    'description' => '新球体育：即时比分、赛事数据',
    'keywords' => ['新球体育', 'NBA', '英超', 'statistics'],
    'url' => 'https://app-neoball.com',
    'language' => 'zh-CN',
]);
echo $custom->generateDescription() . "\n";
*/