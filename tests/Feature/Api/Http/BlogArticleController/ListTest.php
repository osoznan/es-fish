<?php

namespace Tests\Feature\Api\Http\BlogArticleController;

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\Api\BlogArticleController as TestedController;

class ListTest extends TestCase
{
    // use LazilyRefreshDatabase;

    public function testIsEqualJson(): void
    {
        $this->actingAs(User::query()->whereKey(1)->first(), 'web');
        // $r = $this->withToken('1|CuGcYovMogmeG2unGnzhZPrPdBMbTQqlRiBWVvso')
        $r = $this->json('get', '/api/blog');
        $this->assertAuthenticated();
        $r->assertStatus(200);
        $r->assertSeeText('success');
        $r->assertJsonFragment(['hidden' => 1]);
/*        $r->assertJson(
            [
                'id' => 1,
            ]);*/
    }
}
