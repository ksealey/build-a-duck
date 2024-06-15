<?php

namespace Tests\Feature;

use App\Models\Duck;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DuckTest extends TestCase
{
    use WithFaker;

    public function test_it_can_render_the_duck_builder()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('ducks.create'))
             ->assertInertia(function($page){
                $page->component('Ducks/Create');
             })
             ->assertOk();
    }

    public function test_it_can_create_a_duck()
    {
        Storage::fake();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->followingRedirects()
             ->post(route('ducks.store'), [
                'name' => $this->faker->firstName(),
                'color' => '#EF2B3C',
                'hair' => 'hair_' . mt_rand(1,3),
                'accessory' => 'acc_' . mt_rand(1,3),
                'shoes' => 'shoes_' . mt_rand(1,3),
            ])
             ->assertInertia(function($page){
                $page->component('Ducks/View');
             })
             ->assertOk();

        Storage::shouldReceive('disk');
        Storage::shouldReceive('put');
    }

    public function test_it_can_view_a_duck()
    {
        $user = User::factory()->create();
        $duck = Duck::factory()->make();
        $user->ducks()->attach($duck);

        $this->actingAs($user)->get(route('ducks.view', ['duckId' => $duck->id]))
             ->assertInertia(function($page){
                $page->component('Ducks/View');
             })
             ->assertOk();
    }

    public function test_it_cannot_view_another_users_duck()
    {
        $user = User::factory()->create();
        $myDuck = Duck::factory()->make();
        $user->ducks()->attach($myDuck);

        $otherUser = User::factory()->create();
        $notMyDuck = Duck::factory()->make();
        $otherUser->ducks()->attach($notMyDuck);

        $this->actingAs($user)->get(route('ducks.view', ['duckId' => $notMyDuck->id]))
             ->assertNotFound();
    }

    public function test_it_can_view_all_ducks()
    {
        $user = User::factory()->create();

        Duck::factory(5)->make()->each(fn($duck) => $user->ducks()->attach($duck));

        $this->actingAs($user)->get(route('ducks.index'))
             ->assertInertia(function($page){
                $page->component('Ducks/Index')
                     ->has('ducks', 5);
             })
             ->assertOk();
    }
}
