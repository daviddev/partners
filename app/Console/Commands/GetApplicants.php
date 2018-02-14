<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Publisher;
use App\Advertiser;

class GetApplicants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:applicants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
		$this->api_key    = config('wordpress.api_key');
		$this->expires    = Carbon::now()->addHour()->timestamp;
		$this->start_date = Carbon::now()->subDays(30)->format('Y-m-d');
		$this->end_date = Carbon::now()->format('Y-m-d');
		$this->client     = new Client(['base_uri' => config('wordpress.base_url')]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$entries = $this->getEntries();
		$forms = $this->getForms();

		foreach ($forms as $key => $form) {
			if ($form->title == 'Advertisers')
				$advertiserForm = $form;
			if ($form->title == 'Publisher')
				$publisherForm = $form;
		}

		foreach ($entries->entries as $key => $entry) {
			if ($entry->form_id == $publisherForm->id) {
				Publisher::updateOrCreate([
					'partner' => $entry->{30},
					'company_name' => $entry->{1},
					'company_website' => $entry->{2},
					'address' => $entry->{17},
					'address2' => $entry->{18},
					'city' => $entry->{19},
					'country' => $entry->{20},
					'state' => $entry->{21},
					'region' => $entry->{22},
					'zip_code' => $entry->{23},
					'email' => $entry->{7},
					'first_name' => $entry->{6},
					'last_name' => $entry->{11},
					'title' => $entry->{8},
					'phone_number' => $entry->{9},
					'company_name_legal' => $entry->{12},
					'bank_name' => $entry->{13},
					'bank_account' => $entry->{25},
					'bic_swift' => $entry->{26},
					'ein' => $entry->{24},
					'skype' => $entry->{14},
					'email_finance' => $entry->{16},
					'is_interested' => boolVal($entry->{27.1})
				], ['date' => $entry->date_created]);
			}
			if ($entry->form_id == $advertiserForm->id) {
				Advertiser::updateOrCreate([
					'partner' => $entry->{24},
					'company_name' => $entry->{1},
					'company_website' => $entry->{2},
					'address' => $entry->{17},
					'address2' => $entry->{18},
					'city' => $entry->{19},
					'country' => $entry->{20},
					'state' => $entry->{21},
					'region' => $entry->{22},
					'zip_code' => $entry->{23},
					'email' => $entry->{7},
					'first_name' => $entry->{6},
					'last_name' => $entry->{11},
					'title' => $entry->{8},
					'phone_number' => $entry->{9},
					'company_name_legal' => $entry->{12},
					'ein' => $entry->{13},
					'skype' => $entry->{14},
					'contact_person_finance' => $entry->{15},
					'email_finance' => $entry->{16}
				], ['date' => $entry->date_created]);
			}
		}
    }

	public function getEntries()
	{
		$route  = 'entries';
		$sig    = $this->createSignature($route);
		$data   = $this->getData($route, $sig);
		return $data;
	}

	public function getForms()
	{
		$route  = 'forms';
		$sig    = $this->createSignature($route);
		$data   = $this->getData($route, $sig);
		return $data;
	}

	public function createSignature($route)
	{
		$private_key    = config('wordpress.private_key');
		$string_to_sign = sprintf("%s:%s:%s:%s", $this->api_key, 'GET', $route, $this->expires);
		$hash           = hash_hmac("sha1", $string_to_sign, $private_key, true);
		$sig            = rawurlencode(base64_encode($hash));
		return $sig;
	}

	public function getData($route, $sig)
	{
		$res = $this->client->get($route, [
			'query' => [
				'api_key'   => $this->api_key,
				'expires'   => $this->expires,
				'signature' => $sig,
				'search'    => [
					'start_date' 	=> $this->start_date,
					'end_date'		=> $this->end_date
				]
			]
		]);
		return json_decode($res->getBody())->response;
	}
}
