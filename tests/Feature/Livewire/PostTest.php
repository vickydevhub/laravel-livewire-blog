<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Post;
use App\Models\POST as POSTMODEL;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Post::class);

        $component->assertStatus(200);
    }

    /** @test */
    function can_create_post()
    {
        
        $response = Livewire::test(Post::class)
            ->set('title', 'foo')
            ->set('content', 'para')
            ->call('storePost');
 
        $response->assertStatus(200);
    }
 
     
}
