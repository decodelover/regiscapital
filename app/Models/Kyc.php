<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'gender',
        'zipcode',
        'phone_number',
        'dob',
        'social_media',
        'address',
        'city',
        'state',
        'country',
        'document_type',
        'frontimg',
        'backimg',
        'status',
        'statenumber',
        'accounttype',
        'employer',
        'income',
        'kinname',
        'kinaddress',
        'relationship',
        'age',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
        'age' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the KYC record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get default values for KYC creation.
     *
     * @return array
     */
    public static function getDefaultValues()
    {
        return [
            'status' => 'Under review',
        ];
    }
}
