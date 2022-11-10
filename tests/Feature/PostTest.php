<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText("No Posts found!");
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        // Arrange
        $post = new BlogPost();
        $post->title = "New Title";
        $post->content = "New Content";
        $post->save();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText("New Title");
        $response->assertSeeText("New Content");

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
        ]);
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
}
