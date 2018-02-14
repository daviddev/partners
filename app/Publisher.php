<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'partner',
		'company_name',
		'company_website',
		'address',
		'address2',
		'city',
		'country',
		'state',
		'region',
		'zip_code',
		'email',
		'first_name',
		'last_name',
		'title',
		'phone_number',
		'company_name_legal',
		'bank_name',
		'bank_account',
		'bic_swift',
		'ein',
		'skype',
		'email_finance',
		'is_interested',
		'date',
	];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
	protected $appends = ['type'];

    /**
     * Get the type of applicant.
     *
     * @return string
     */
	public function getTypeAttribute()
	{
		return 'Publisher';
	}
}
