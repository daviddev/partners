<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publisher;
use App\Advertiser;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Controllers\CakeApiController;

class ApplicantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user           = auth()->user();
        $publishers     = Publisher::wherePartner($user->partner_id)->get(['id', 'affiliate_id', 'date']);
        $newPublishers  = Publisher::wherePartner($user->partner_id)->where('date', '>', Carbon::now()->subDays(7))->get(['id', 'affiliate_id', 'date']);
        $advertisers    = Advertiser::wherePartner($user->partner_id)->get(['id', 'advertiser_id', 'date']);
        $newAdvertisers = Advertiser::wherePartner($user->partner_id)->where('date', '>', Carbon::now()->subDays(7))->get(['id', 'advertiser_id', 'date']);

        $applicants         = $publishers->concat($advertisers);
        $applicantsCount    = $publishers->count() + $advertisers->count();
        $newApplicantsCount = $newPublishers->count() + $newAdvertisers->count();

        $start  = Carbon::now()->addMonth();
        $monthlyArr = [];
        for ($i=0; $i < 12; $i++) {
            $month      = clone $start->subMonth();
            $monthStart = clone $month->startOfMonth();
            $monthEnd   = clone $month->endOfMonth();

            $monthApplicants = $applicants->where('date', '>', $monthStart)->where('date', '<', $monthEnd);
            $sales = 0;
            foreach ($monthApplicants as $value) {
                if ($value->affiliate_id)
                    $sales += $this->getSales($value->affiliate_id, $monthStart->format('m-d-Y'), $monthEnd->format('m-d-Y'));
                elseif ($value->advertiser_id)
                    $sales += $this->getSales($value->advertiser_id, $monthStart->format('m-d-Y'), $monthEnd->format('m-d-Y'));
                else continue;
            }

            $monthlyArr[] = [
                'month'      => $month,
                'applicants' => $monthApplicants->count(),
                'sales'      => $sales
            ];
        }
        $monthlyCol     = collect($monthlyArr);
        $curMonthSales  = $monthlyCol->first()['sales'];
        $lastYearSales  = $monthlyCol->sum('sales');

        $data = [
            'applicantsCount'       => $applicantsCount,
            'newApplicantsCount'    => $newApplicantsCount,
            'monthlyArr'            => $monthlyArr,
            'curMonthSales'         => $curMonthSales,
            'lastYearSales'         => $lastYearSales,

        ];

        return response()->json($data);
    }

    public function getSales($affiliateId, $start, $end)
    {
        $api = new CakeApiController($affiliateId, '1', $start, $end);
        $res = $api->getInternalAndExternalSummary();
        $sum = 0;
        foreach ($res['external'] as $key => $value) {
            $sum += floatVal($value->revenue);
        }
        $percentage = floatVal(auth()->user()->partner_percentage);
        if ($percentage)
            $sum *= $percentage / 100;
        else
            $sum = 0;

        return $sum;
    }
}
