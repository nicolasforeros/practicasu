<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\InternshipOffer;

class Application extends Model
{
    use HasFactory;

    /**
     * Application's states
     * 
     * @var array
     */
    public const STATES = [
        0 => 'Waiting',
        1 => 'Accepted',
        2 => 'Rejected'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'internship_offer_id',
        'state'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function internshipOffer(){
        return $this->belongsTo(InternshipOffer::class);
    }
}
