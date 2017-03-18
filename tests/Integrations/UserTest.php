<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Order;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(){
        parent::setUp();

        $this->user = factory(App\Models\User::class)->create();
    }

    /**
     * Account creation related tests
     */

    /**
     * Order related tests
     */

    /** @test */
    public function it_can_create_order(){
        $order = new Order();
        $this->user->createOrder($order);

        $this->assertCount(1, $this->user->orders()->get());
    }

    /** @test */
    public function it_can_see_all_order(){
        $order = new Order();
        $otherOrder = new Order();

        $this->user->orders()->save($order);
        $this->user->orders()->save($otherOrder);

        $this->assertCount(2, $this->user->orders()->get());
    }
    /** @test */
    public function it_has_attribute_is_client(){
        $this->assertEquals($this->user->is_client, 1);
    }



}
