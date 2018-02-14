<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\User;
use App\Advertiser;
use App\Publisher;

class GetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:data';

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(['base_uri' => env('PORTAL_DOMAIN')]);
        $res = $client->get('/api/partners');
        $data = json_decode($res->getBody());
        foreach ($data as $key => $value) {
            User::updateOrCreate(['email' => $value->email], [
                'name' => $value->name,
                'partner_id' => $value->partner_id,
                'partner_percentage' => $value->partner_percentage,
                'password' => $value->password
            ]);
        }

        $client = new Client(['base_uri' => env('PORTAL_DOMAIN')]);
        $res = $client->get('/api/advertisers');
        $data = json_decode($res->getBody());
        foreach ($data as $key => $value) {
            Advertiser::whereEmail($value->email)->update(['advertiser_id' => $value->advertiser_id]);
        }

        $client = new Client(['base_uri' => env('PORTAL_DOMAIN')]);
        $res = $client->get('/api/publishers');
        $data = json_decode($res->getBody());
        foreach ($data as $key => $value) {
            Publisher::whereEmail($value->email)->update(['affiliate_id' => $value->affiliate_id]);
        }
    }
}
