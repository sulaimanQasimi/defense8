<?php

namespace Sq\Fingerprint\Models;

use Illuminate\Database\Eloquent\Model;

class BiometricData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'biometric_data';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'record_id',
        'Manufacturer',
        'Model',
        'SerialNumber',
        'ImageWidth',
        'ImageHeight',
        'ImageDPI',
        'ImageQuality',
        'NFIQ',
        'ImageDataBase64',
        'BMPBase64',
        'ISOTemplateBase64',
        'TemplateBase64',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'record_id' => 'integer',
        'ImageWidth' => 'integer',
        'ImageHeight' => 'integer',
        'ImageDPI' => 'integer',
        'ImageQuality' => 'integer',
        'NFIQ' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}