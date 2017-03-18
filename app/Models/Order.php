<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $fillable = [
        'pickup_address',
        'pickup_street',
        'pickup_house_number',
        'pickup_city',
        'pickup_zip',
        'pickup_country',
        'pickup_lat',
        'pickup_long',
        'pickup_administrative_area',
        'pickup_floor',
        'pickup_elevator',
        'drop_off_address',
        'drop_off_street',
        'drop_off_house_number',
        'drop_off_city',
        'drop_off_zip',
        'drop_off_country',
        'drop_off_lat',
        'drop_off_long',
        'drop_off_administrative_area',
        'drop_off_floor',
        'drop_off_elevator',
        'will_help',
        'helper_count',
        'time_pick_up',
        'time_pick_up_interval',
        'time_drop_off',
        'time_drop_off_interval',
        'pick_up_dates',
        'drop_off_dates',
        'expiration_date',
        'distance',
        'old_time',
        'move_comments',
        'note'
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function job()
    {
        return $this->hasOne(Job::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function smallItems()
    {
        return $this->items()->where('type', 'small')->get();
    }

    public function largeItems()
    {
        return $this->items()->where('type', 'large')->get();
    }

    private function get_items_amount_count($items)
    {
        $items_count = 0;
        foreach ($items as $item) {
            $items_count += $item->amount;
        }

        return $items_count;
    }

    public function small_items_amount()
    {
        return $this->get_items_amount_count($this->smallItems());
    }

    public function large_items_amount()
    {
        return $this->get_items_amount_count($this->largeItems());
    }


    public function lowestBidPrice()
    {
        $bids = $this->bids()->get();

        if (count($bids) > 0) {
            $lowestBid = PHP_INT_MAX;
            foreach ($bids as $bid) {
                if ($lowestBid > $bid->bid) {
                    $lowestBid = $bid->bid;
                }
            }

            return $lowestBid;
        }
        return 0;
    }

    public function bidsCount()
    {
        return count($this->bids()->get());
    }

    public function addBid(Bid $bid, Mover $mover)
    {
        $this->bids()->save($bid);
    }

    public function assigned()
    {
        return $this->status('won');
    }

    public function isWon()
    {
        return $this->status == 'won' ? true : false;
    }

    public function status($status = null)
    {
        if($status != null){
            $this->status = $status;
            $this->save();

            return $this->status;
        }

        if(count(Job::where('order_id', $this->id)->first()) > 0 && $this->status != 'done'){
            $this->status('won');
        } else if($this->checkIfExpired()){
            $this->status('expired');
        }

        return $this->status;
    }

    public function checkIfExpired(){

        if($this->expiration_date != null){
            $order_date = Carbon::createFromFormat('Y-n-j', $this->expiration_date);

            if($order_date->diffInDays(Carbon::now()) < 0){
                return false; //Expired
            }

            return true; //Not expired
        }

        return false;
    }

    public function checkStatus(){


    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBid($mover_id)
    {
        $bid = $this->bids()->get()->where('user_id', $mover_id)->first();

        return $bid->bid;
    }


    public function needAssembly()
    {
        $items = $this->items()->get();

        foreach ($items as $item) {
            if ($item->assemb_dissasemb_need == 1) {
                return true;
            }
        }

        return false;
    }

    public function needPackaging()
    {
        $items = $this->items()->get();

        foreach ($items as $item) {
            if ($item->packaking_need == 1) {
                return true;
            }
        }

        return false;
    }

    //Movers by region
    public static function getByRegion($user_id)
    {
        $regions = Region::where('user_id', $user_id)->get();

        $orders = array();

        foreach ($regions as $region) {
            $orders_found = Order::where('user_id', '>', '0')->where('status', 'active')->get();
            $orders_found_pickup = $orders_found->where('pickup_administrative_area', $region->region_name);
            $orders_found_dropoff = $orders_found->where('drop_off_administrative_area', $region->region_name);

            foreach ($orders_found_pickup->all() as $order) {
                if (!in_array($order, $orders)) {
                    $orders[] = $order;
                }

            }

            foreach ($orders_found_dropoff->all() as $order) {
                if (!in_array($order, $orders)) {
                    $orders[] = $order;
                }
            }
        }

        $orders = array_values(array_sort($orders, function ($value) {
            return $value->expiration_date;
        }));

        return $orders;

    }


    public function getClient()
    {
        return $this->user()->first();
    }

    public function setDone()
    {
        return $this->status('done');
    }


}
