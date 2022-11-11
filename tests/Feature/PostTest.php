<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText("No Posts found!");
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();
        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText("New title");
        $response->assertSeeText("Content");
        $response->assertSeeText("No comments yet!");

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
        ]);
    }

    public function testSee1BlogWithComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();
        // $comment = Comment::factory()->create(['blog_post_id' => 1]);
        Comment::factory(4)-> create([
            'blog_post_id' => $post->id
        ]);

        // Act
        $response = $this->get('/posts');
        
        $response->assertSeeText("4 comments");

    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid Title',
            'content' => 'At least 10 characters',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 5 characters.');

    }

    public function testDeletePostCorrectly()
    {
        $post = new BlogPost();
        $post->title = "New title";
        $post->content = "Content";
        $post->save();

        $post->delete();
        $this->assertDatabaseMissing('blog_posts', ['id'=>$post->id]);
    }

    public function testUpdatePostCorrectly()
    {
        $post = new BlogPost();
        $post->title = "New title";
        $post->content = "Content";
        $post->save();

        $post->update([
            'title' => 'New title updated',
            'content' => 'Content updated',
        ]);
        $this->assertDatabaseHas('blog_posts', ['id'=>$post->id, 'title'=>"New title updated"]);
        $this->assertDatabaseMissing('blog_posts', ['id'=>$post->id, 'title'=>"New title"]);
    }

    private function createDummyBlogPost (): BlogPost
    {
        $post = new BlogPost();
        $post->title = "New title";
        $post->content = "Content";
        $post->save();
        return $post;
    }
}
