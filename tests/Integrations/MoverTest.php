<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Order;


class MoverTest extends TestCase
{
    //use DatabaseTransactions;

    protected $mover;

    public function setUp(){
        parent::setUp();

        $this->mover = factory(App\Models\Mover::class)->create();
    }

    /** @test */
    public function it_can_have_a_cars(){
        $car = factory(App\Models\Car::class)->create();
        $this->mover->addCar($car);

        $this->assertCount(1, $this->mover->cars()->get());
    }

    /** @test */
    public function it_can_apply_to_order_and_place_bid(){
        $bid = factory(App\Models\Bid::class)->create();

        $order = Order::find($bid->order_id);

        $this->assertCount(1, $order->bids()->get());
    }




}
