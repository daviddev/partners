<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Advertiser extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'advertiser_id',
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
		'ein',
		'skype',
		'contact_person_finance',
		'email_finance',
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
		return 'Advertiser';
	}
}
