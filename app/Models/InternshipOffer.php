<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Company;

class InternshipOffer extends Model
{
    use HasFactory;

    /**
     * Offer's types
     * 
     * @var array
     */
    public const TYPES = [
        0 => 'in-site',
        1 => 'home-office'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'position',
        'duration_months',
        'type',
        'schedule',
        'contact_phone',
        'contact_email',
        'vacancies',
        'description'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
