<?php

namespace App\Models;

use Database\Factories\AboutPageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutPage extends Model
{
    /** @use HasFactory<AboutPageFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'story_title',
        'story_body',
        'story_image',
        'values_title',
        'values_subtitle',
        'values_items',
        'team_title',
        'team_subtitle',
        'team_members',
        'stats_items',
        'is_active',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'values_items' => 'array',
            'team_members' => 'array',
            'stats_items' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getStoryImageUrlAttribute(): ?string
    {
        if (blank($this->story_image)) {
            return null;
        }

        if (Str::startsWith((string) $this->story_image, ['http://', 'https://'])) {
            return $this->story_image;
        }

        return Storage::url((string) $this->story_image);
    }
}
