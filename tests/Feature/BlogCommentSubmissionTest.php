<?php

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a visitor can submit a blog comment', function () {
    $blogPost = BlogPost::factory()->create([
        'is_published' => true,
        'publish_date' => now()->subDay(),
        'comments_count' => 0,
    ]);

    $response = $this->post(route('blog.comments.store', ['blogPost' => $blogPost->slug]), [
        'name' => 'Reader Name',
        'email' => 'reader@example.com',
        'website' => 'https://example.com',
        'content' => 'This article was genuinely helpful and easy to follow.',
    ]);

    $response
        ->assertRedirect(route('blog.details', ['blogPost' => $blogPost->slug]))
        ->assertSessionHas('commentSubmitted');

    expect(BlogComment::query()->count())->toBe(1);

    $this->assertDatabaseHas('blog_comments', [
        'blog_post_id' => $blogPost->id,
        'name' => 'Reader Name',
        'email' => 'reader@example.com',
        'website' => 'https://example.com',
        'is_approved' => true,
    ]);

    expect($blogPost->fresh()->comments_count)->toBe(1);
});

test('a blog comment requires valid input', function () {
    $blogPost = BlogPost::factory()->create([
        'is_published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $response = $this->from(route('blog.details', ['blogPost' => $blogPost->slug]))
        ->post(route('blog.comments.store', ['blogPost' => $blogPost->slug]), [
            'name' => '',
            'email' => 'not-an-email',
            'website' => 'invalid-url',
            'content' => 'short',
        ]);

    $response
        ->assertRedirect(route('blog.details', ['blogPost' => $blogPost->slug]))
        ->assertSessionHasErrors(['name', 'email', 'website', 'content']);
});
