<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CompanyDocument;
use App\Models\InternshipOffer;

class Company extends Model
{
    use HasFactory;

    /**
     * Companys' sectors
     * 
     * @var array
     */
    public const SECTORS = [
        0 => 'Health',
        1 => 'Finances',
        2 => 'Food',
        3 => 'Software'
    ];

    /**
     * Companys' situations
     * 
     * @var array
     */
    public const SITUATIONS = [
        0 => 'Waiting',
        1 => 'Accepted',
        2 => 'Rejected',
    ];

    // /**
    //  * returns the id of a given sector
    //  *
    //  * @param string $sector  company's sector
    //  * @return int sectorID
    //  */
    // public static function getSectorID($sector)
    // {
    //     return array_search($sector, self::SECTORS);
    // }
    // /**
    //  * get company sector
    //  */
    // public function getSectorAttribute()
    // {
    //     return self::SECTORS[ $this->attributes['sector_id'] ];
    // }
    // /**
    //  * set company sector
    //  */
    // public function setSectorAttribute($value)
    // {
    //     $sectorID = self::getSectorID($value);
    //     if ($sectorID) {
    //         $this->attributes['sector_id'] = $sectorID;
    //     }
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nit',
        'sector',
        'country',
        'state',
        'city',
        'situation',
        'observation'
    ];

    public function companyDocuments(){
        return $this->hasMany(CompanyDocument::class);
    }

    public function internshipOffers(){
        return $this->hasMany(InternshipOffer::class);
    }
}
