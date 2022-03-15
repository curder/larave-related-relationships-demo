<?php
namespace Tests\Integration\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OneToManyPolymorphicTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_post_morphs_to_many_comments(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->assertInstanceOf(Collection::class, $post->comments);
        $this->assertTrue($post->comments->isEmpty());

        // create many
        Comment::factory()
               ->count(20)
               ->for($post, 'commentable')
               ->create();

        $post->refresh();

        $this->assertInstanceOf(Collection::class, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
        $this->assertInstanceOf(MorphMany::class, $post->comments());
        $this->assertFalse($post->comments->isEmpty());
        $this->assertSame($post->comments->first()->commentable_id, $post->id);
        $this->assertSame($post->comments->first()->commentable_type, get_class($post));
    }

    /** @test */
    public function a_video_morphs_to_many_comments(): void
    {
        /** @var Video $video */
        $video = Video::factory()->create();

        $this->assertInstanceOf(Collection::class, $video->comments);
        $this->assertTrue($video->comments->isEmpty());

        // create many
        Comment::factory()
               ->count(20)
               ->for($video, 'commentable')
               ->create();

        $video->refresh();

        $this->assertInstanceOf(Collection::class, $video->comments);
        $this->assertInstanceOf(Comment::class, $video->comments->first());
        $this->assertInstanceOf(MorphMany::class, $video->comments());
        $this->assertFalse($video->comments->isEmpty());
        $this->assertSame($video->comments->first()->commentable_id, $video->id);
        $this->assertSame($video->comments->first()->commentable_type, get_class($video));
    }
}
