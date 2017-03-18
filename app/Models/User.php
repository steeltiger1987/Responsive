<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;


    /**
     * Declaring database table
     * @var string
     */
    protected $table = "users";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_name', 'phone_number', 'is_client', 'is_mover', 'base_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship to orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function is_approved(){
        return false;
    }

    public function createBalance()
    {
        if ($this->balance()->first() == null) {
            return $this->balance()->save(new Balance(['amount' => 0, 'user_id' => $this->id]));
        }
        return false;
    }

    public function approve(){
        if(!$this->is_approved){
            $this->is_approved = true;

        }
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function getMoverImagePath()
    {
        if (!$this->images()->first()) {
            return false;
        }

        return '/uploads/mover/' . $this->images()->first()->path;
    }

    /**
     * Creating order for client
     * @param Order $order
     * @return Model
     */
    public function createOrder(Order $order)
    {
        return $this->orders()->save($order);
    }

    public function billingInfo()
    {
        return $this->hasOne(BillingInfo::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function updateBillingInfo(Request $request)
    {
        return $this->billingInfo()->updateOrCreate(['id' => $request->id], $request->except('_token', 'send'));
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getRating()
    {
        if (count($this->ratings()->get()) == 0) {
            return 0;
        }

        $rating_sum = 0;
        $count = 0;
        foreach ($this->ratings()->get() as $rating) {
            $rating_sum += $rating->rating;
            $count++;
        }

        return round($rating_sum / $count);
    }

    public function getJobs()
    {
        return count($this->jobs()->get());
    }

    public function isMover()
    {
        return $this->is_mover;
    }

    public function isUser()
    {
        return $this->is_client;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Relationship with cars
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    /**
     * Method to add car to mover.
     * @param Car $car
     * @return Model
     */
    public function addCar(Car $car)
    {
        $this->cars()->save($car);
        return $this;
    }

    /**
     * Adding bid to order
     * @param $bid
     * @param $order
     * @return mixed
     */
    public function addBid($bid, $order)
    {
        $order->addBid($bid, $this);
        return $this;
    }

    public function isApplied($orderId)
    {

        if ($this->bids()->where(['order_id' => $orderId, 'user_id' => Auth::user()->id])->first()) {
            return true;
        }

        return false;
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function getShortNameAttribute()
    {
        return $this->name . ' ' . $this->last_name[0] . '.';
    }


    public function hasInsurance()
    {
        if ($this->insurance()->first() != null) {
            if ($this->insurance()->first()->is_insured) {
                return true;
            }
        }

        return false;
    }

    public function getInsuranceAmout()
    {
        if ($this->insurance()->first() == null) {
            return 0;
        }
        return $this->insurance()->first()->amount;
    }

    private function generateVariable()
    {
        $number = mt_rand(100000, 999999); // better than rand()

        // call the same function if the barcode exists already
        if ($this->variableExist($number)) {
            return generateVariable();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    private function variableExist($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return User::whereVariable($number)->exists();
    }

    //Call only this.
    public function getVariable()
    {
        if ($this->variable != 0) {
            return $this->variable;
        }

        $this->variable = $this->generateVariable();
        $this->save();

        return $this->variable;
    }

    public function hasSetPreferences()
    {
        if (Region::where('user_id', $this->id)->exists()) {
            return true;
        }

        return false;
    }


    /**
     * Admin part
     */

    public function getAllBidsThatAreMade(){
        return count(Bid::where('user_id', $this->id)->get());
    }

    public function isActivated(){
        return $this->activated;
    }

    public function activateMover(){
        $this->activated = true;
        $this->save;
        return $this->save();
    }

    public function deactivateMover(){
        $this->activated = false;
        $this->save;
        return $this->save();
    }

    public function setComission($comission){
        $this->comission = $comission;
        return $this->save();
    }



    /**
     * Account balance stuff
     */

    public function addFunds($amount)
    {
        if ($this->balance()->first() == null) {
            $this->createBalance();
        }

        return $this->balance()->first()->addFunds($amount);
    }

    public function removeFunds($amount)
    {
        if ($this->balance()->first() == null) {
            $this->createBalance();
        }

        return $this->balance()->first()->removeFunds($amount);
    }

    public function getBalance()
    {
        if ($this->balance()->first() == null) {
            $this->createBalance();
        }

        return $this->balance()->first()->getBalance();
    }


}
