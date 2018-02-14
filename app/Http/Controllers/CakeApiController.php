<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use DOMDocument;
use SimpleXMLElement;

class CakeApiController {
	private $starting;
	private $ending;
	private $api_key = "x4C9I1wYlezsa7jEL27C4OCJqNxxj5k";
	private $tz;
	private $sameDay;
	private $affSum;
	/**
	 * Initializer.
	 *
	 * @access   public
	 * @return \BaseController
	 */
	public function __construct($affID = "0", $tz = "1", $startDate = null, $endDate = null) {
		$this -> tz = $tz;
		$this -> affID = $affID;
		$this -> sameDay = $startDate == null && $endDate == null ? true : false;
		$this -> sameDay = $startDate == $endDate ? true : false;
        if($startDate == null){
            $this->starting = date("m-d-Y", strtotime("today"));
        }
        else{
            $this->starting = $startDate;
        }
        if($endDate == null){
            $this->ending = date("m-d-Y", strtotime("tomorrow"));
        }
        else{
            $this->ending = $endDate;
        }
	}

	/*
	 * Get the Affiliate Summary
	 */
	public function getAffiliateSummary() {
        /* Relook at giving dates */
		$start = $this->starting;
		$end = $this->ending;
		$url = "http://egtracking.com/api/2/reports.asmx/AffiliateSummary?api_key=$this->api_key&start_date=$start&end_date=$end&affiliate_id=$this->affID&affiliate_manager_id=0&affiliate_tag_id=0&event_id=0&offer_tag_id=0&revenue_filter=conversions_and_events";
        //echo $url; exit();
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
	public function getInternalAndExternalSummary(){
		$this->affSum = $this->getAffiliateSummary();
		$a = $this->affSum->affiliates->affiliate_summary;
		//$in = ActMgmtIdentifiers::all();
		$int = array();
		$ext = array();
		foreach($a as $key=>$value){
			$i=false;
			/*foreach($in as $k=>$v){
				if($value->affiliate->affiliate_id == $v['cakeID']){
					array_push($int, $value);
					$i=true;
					break;
				}
			}*/
			if(!$i){
				array_push($ext, $value);
			}
		}
		//$fin['internal'] = $int;
		$fin['external'] = $ext;
		return $fin;
	}

	public function affiliateExportData($affID){
		//$url = "https://egtracking.com/api/5/export.asmx/Affiliates?api_key=$this->api_key&affiliate_id=$affID&affiliate_name=&account_manager_id=0&tag_id=0&start_at_row=1&row_limit=0&sort_field=affiliate_id&sort_descending=FALSE";
        $url = "https://egtracking.com/api/5/export.asmx/Affiliates?api_key=$this->api_key&affiliate_id=0&affiliate_name=0&account_manager_id=0&tag_id=0";
        echo $url; exit();


		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
/*
	public function setApiKeys(){
		$u = User::where('userTypeID', '=', 103)->join('advertiser_identifiers', 'advertiser_identifiers.userID', '=', 'users.userID')->get();
		foreach($u as $v){
			$af = $this->affiliateExportData($v->cakeID);
			$key = $af->affiliates->affiliate->api_key;
			AdvertiserIdentifiers::where('userID', '=', $v->userID)->update(array(
				"cake_api_key"=> $key
			));
		}

	}
	*/
	public function addAffiliate($companyName, $fname, $lname, $email, $password, $phone, $ssn_tax_id, $address = 'set', $city = 'set', $state = 'set', $zip = '11111'){
		$url = "https://egtracking.com/api/4/signup.asmx/Affiliate?api_key=$this->api_key&affiliate_name=".urlencode($companyName)."&account_status_id=1&affiliate_tier_id=1&hide_offers=FALSE&website=&tax_class=Other&ssn_tax_id=$ssn_tax_id&vat_tax_required=FALSE&swift_iban=0&payment_to=1&payment_fee=0&payment_min_threshold=0&currency_id=1&payment_setting_id=1&billing_cycle_id=1&payment_type_id=1&payment_type_info=&address_street=".urlencode($address)."&address_street2=&address_city=".urlencode($city)."&address_state=$state&address_zip_code=$zip&address_country=US&contact_first_name=$fname&contact_middle_name=&contact_last_name=$lname&contact_email_address=$email&contact_password=$password&contact_title=contact&contact_phone_work=$phone&contact_phone_cell=$phone&contact_phone_fax=0&contact_im_service=1&contact_im_name=&contact_timezone=PST&contact_language_id=1&media_type_ids=&price_format_ids=&vertical_category_ids=&country_codes=US&tag_ids=&date_added=".date("m/d/Y")."&signup_ip_address=".$_SERVER['REMOTE_ADDR']."&referral_affiliate_id=0&referral_notes=&terms_and_conditions_agreed=TRUE&notes=".urlencode("This Affiliate was CREATED by the amazing EPC Portal!");
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
	public function updateAffiliate($companyName, $ssn_tax_id, $address = 'set', $city = 'set', $state = 'set', $zip = '11111'){
		$url = "https://egtracking.com/api/2/addedit.asmx/Affiliate?api_key=$this->api_key&affiliate_id=$this->affID&affiliate_name=".urlencode($companyName)."&third_party_name=NULL&account_status_id=1&inactive_reason_id=0&affiliate_tier_id=0&account_manager_id=0&hide_offers=FALSE&website=&tax_class=Other&ssn_tax_id=$ssn_tax_id&vat_tax_required=FALSE&swift_iban=0&payment_to=2&payment_fee=0.00&payment_min_threshold=0.00&currency_id=0&payment_setting_id=1&billing_cycle_id=1&payment_type_id=2&payment_type_info=&address_street=&address_street2=&address_city=&address_state=&address_zip_code=&address_country=US&media_type_ids=0&price_format_ids=0&vertical_category_ids=0&country_codes=US&tags=0&pixel_html=&postback_url=&postback_delay_ms=0&fire_global_pixel=TRUE&date_added=".date("m/d/Y")."&online_signup=FALSE&signup_ip_address=".$_SERVER['REMOTE_ADDR']."&referral_affiliate_id=0&referral_notes=&terms_and_conditions_agreed=TRUE&notes=".urlencode("This Affiliate was UPDATED by the amazing EPC Portal!");
		$xml = $this -> callMeMaybe($url);
	}

    public function getAffiliateStatsByTagId($tag_id, $start_date, $end_date){

        $url ="http://egtracking.com/api/3/reports.asmx/SourceAffiliateSummary?api_key=$this->api_key&start_date=$start_date&end_date=$end_date&source_affiliate_id=0&source_affiliate_manager_id=0&source_affiliate_tag_id=0&site_offer_tag_id=$tag_id&event_id=0&event_type=all";
        $xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }


	public function addAdvertiser($companyName, $fname, $lname, $email, $password, $phone, $ssn_tax_id, $address = 'set', $city = 'set', $state = 'set', $zip = '11111'){
		$url = "http://egtracking.com/api/1/signup.asmx/Advertiser?api_key=$this->api_key&company_name=".urlencode($companyName)."&address_street=$address&address_street2=&address_city=$city&address_state=$state&address_zip_code=$zip&address_country=US&first_name=$fname&last_name=$lname&email_address=$email&password=$password&website=".urlencode("http://rollepc.com")."&notes=".urlencode("This Affiliate was created by the amazing EPC Portal!")."&contact_title=contact&contact_phone_work=$phone&contact_phone_cell=$phone&contact_phone_fax=&contact_im_name=&contact_im_service=1&ip_address=".$_SERVER['REMOTE_ADDR'];
		print_r($url);
		$xml = $this -> callMeMaybe($url);
		print_r($xml);
		return new SimpleXMLElement($xml);
	}

    /*
     * Get Advertiser Information
     *
     */
	public function getAdvertisers(){
        $url = "http://egtracking.com/api/6/export.asmx/Advertisers?api_key=$this->api_key&advertiser_id=0&advertiser_name=&account_manager_id=0&tag_id=0&start_at_row=1&row_limit=0&sort_field=advertiser_id&sort_descending=FALSE";
        $xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }


	/*
	 * Get Offer Information (-1 = all or specify OfferID)
	 * Date format MUST be m-d-Y... Why.. b/c Cake sucks ass
	 */
	public function getOffer($offID = 0, $evtID = 0, $filter = "conversions_and_events") {
	    $aff = $this->affID;
        /* Relook at sending dates to function */
	    $start = $this->starting;
		$end = $this->ending;
		$url = "http://egtracking.com/api/2/reports.asmx/OfferSummary?api_key=$this->api_key&start_date=$start&end_date=$end&advertiser_id=0&affiliate_id=$aff&advertiser_manager_id=0&offer_id=$offID&offer_tag_id=0&affiliate_tag_id=0&event_id=$evtID&revenue_filter=conversions_and_events";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
	public function getAdvOffers(){
		$adv = $this->affID;
		$url = "http://egtracking.com/api/6/export.asmx/Offers?api_key=$this->api_key&offer_id=0&offer_name=&advertiser_id=$adv&vertical_id=0&offer_type_id=0&media_type_id=0&offer_status_id=0&tag_id=0&start_at_row=1&row_limit=0&sort_field=offer_id&sort_descending=FALSE";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}

    public function getAdvOffersByAdv($adv){
        $url = "http://egtracking.com/api/6/export.asmx/Offers?api_key={$this->api_key}&offer_id=0&offer_name=&advertiser_id=79&vertical_id=0&offer_type_id=0&media_type_id=0&tag_id=0&start_at_row=0&row_limit=3&sort_field=offer_id&sort_descending=FALSE&offer_status_id=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}

    public function getOfferSalesByDate($start, $end){
        $url = "http://egtracking.com/api/4/reports.asmx/SiteOfferSummary?api_key=$this->api_key&start_date=$start&end_date=$end&brand_advertiser_id=0&brand_advertiser_manager_id=0&site_offer_id=0&site_offer_tag_id=0&source_affiliate_tag_id=0&event_id=0&event_type=0";
        $xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }

    public function getAllOffers(){
        $url = "http://egtracking.com/api/6/export.asmx/Offers?api_key=$this->api_key&offer_id=0&offer_name=&advertiser_id=0&vertical_id=0&offer_type_id=0&media_type_id=0&tag_id=0&start_at_row=0&row_limit=0&sort_field=offer_id&sort_descending=FALSE&offer_status_id=0";
        $xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }

	/*
	 * Get Campaign Information (-1 = all or specify CampaignID)
	 *
	 */
	public function getCampaign($campID = -1) {
		$url = "http://egtracking.com/api/1/export.asmx/Affiliates?api_key=$this->api_key&affiliate_id=" . $campID;
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}

	public function getBilling($type, $start_date = null, $end_date = null) {
		$startDate = $start_date == null ? date("Y-m-d", strtotime("-12 months")) : $start_date;
		$endDate = $end_date == null ? date("Y-m-d") : $end_date;
		switch($type) {
			case "adv" :
				$url = "http://egtracking.com/api/1/accounting.asmx/ExportAdvertiserBills?api_key=$this->api_key&billing_cycle=weekly&billing_period_start_date=$startDate&billing_period_end_date=$endDate";
				break;
			case "aff" :
				$url = "http://egtracking.com/api/1/accounting.asmx/ExportAffiliateBills?api_key=$this->api_key&billing_cycle=weekly&billing_period_start_date=$this->starting&billing_period_end_date=$this->ending&paid_only=FALSE&payment_type_id=0";
				break;
		}
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}

	public function dailySummary($adv = false, $account_manager_id = 0, $start, $end) {
		if(!$adv){
			$aff = $this->affID;
			$adv = 0;
		}else{
			$aff = 0;
			$adv = $this->affID;
		}
		$s = str_replace("%20", " ", $this->starting);
		$e = str_replace("%20", " ", $this->ending);
		$s = date("M-d-Y", strtotime($s));
		$e = date("M-d-Y", strtotime($e));
		$sy = new DateTime($s);
		$ey = new DateTime($e);
		$em = new DateTime($e);
		$st = new DateTime($s);
		$em_now = new DateTime($e);
		$sm_now = new DateTime($s);
		$sy->createFromFormat("Y", $s);
		$ey->createFromFormat("Y", $e);
		$em->createFromFormat("m +1 Month", $e);
		$em->add(new DateInterval('P1M'));
		$em_now->createFromFormat('m', $e);
		$sm_now->createFromFormat('m', $s);
        ## Todo, fix this later
		//$start = $sm_now->format('m') . "-1-" . $sy->format("Y");
		//$end = $em_now->format('m') != '12' ? $em->format("m")."-01-".$ey->format("Y") : $em->format("m") . "-01-" . date('y', strtotime($ey->format("Y") . " +1 year"));

		$url = "http://egtracking.com/api/1/reports.asmx/DailySummaryExport?api_key=$this->api_key&start_date=$start&end_date=$end&affiliate_id=$aff&advertiser_id=$adv&offer_id=0&vertical_id=0&campaign_id=0&creative_id=0&account_manager_id=$account_manager_id&include_tests=false";
		$xml = $this -> callMeMaybe($url);
		if($this->is_valid_xml($xml)){
			return new SimpleXMLElement($xml);
		}else{
			return 0;
		}

	}

    public function dailySummaryByMonth($adv = false, $start, $end) {
		if(!$adv){
			$aff = $this->affID;
			$adv = 0;
		}else{
			$aff = 0;
			$adv = $this->affID;
		}

		$url = "http://egtracking.com/api/1/reports.asmx/DailySummaryExport?api_key=$this->api_key&start_date=$start&end_date=$end&affiliate_id=$aff&advertiser_id=$adv&offer_id=0&vertical_id=0&campaign_id=0&creative_id=0&account_manager_id=0&include_tests=false";

		$xml = $this -> callMeMaybe($url);
		if($this->is_valid_xml($xml)){
			return new SimpleXMLElement($xml);
		}else{
			return 0;
		}

	}

	public function is_valid_xml ( $xml ) {
	    libxml_use_internal_errors( true );

	    $doc = new DOMDocument('1.0', 'utf-8');

	    $doc->loadXML( $xml );

	    $errors = libxml_get_errors();

	    return empty( $errors );
	}
	public function conversions($offID = 0) {
		if($offID == 0){
			$aff = $this->affID;
		}else{
			$aff = 0;
		}
		$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;

		$url = "http://egtracking.com/api/3/reports.asmx/ConversionExport?api_key=$this->api_key&start_date=$start&end_date=$end&affiliate_id=$aff&offer_id=$offID&include_tests=false";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
	public function cvrs($offID = 0) {
		if($offID == 0){
			$aff = $this->affID;
		}else{
			$aff = 0;
		}
		$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;

		$url = "http://egtracking.com/api/11/reports.asmx/Conversions?api_key=$this->api_key&start_date=$start&end_date=$end&conversion_type=conversions&event_id=0&affiliate_id=$aff&advertiser_id=0&offer_id=$offID&affiliate_tag_id=0&advertiser_tag_id=0&offer_tag_id=0&campaign_id=0&creative_id=0&price_format_id=0&disposition_type=all&disposition_id=0&affiliate_billing_status=all&advertiser_billing_status=all&test_filter=non_tests&start_at_row=0&row_limit=10000&sort_field=conversion_date&sort_descending=false";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
	public function events($offID = 0) {
		if($offID == 0){
			$aff = $this->affID;
		}else{
			$aff = 0;
		}
		$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;

		$url = "http://egtracking.com/api/11/reports.asmx/Conversions?api_key=$this->api_key&start_date=$start&end_date=$end&conversion_type=events&event_id=0&affiliate_id=$aff&advertiser_id=0&offer_id=$offID&affiliate_tag_id=0&advertiser_tag_id=0&offer_tag_id=0&campaign_id=0&creative_id=0&price_format_id=0&disposition_type=all&disposition_id=0&affiliate_billing_status=all&advertiser_billing_status=all&test_filter=non_tests&start_at_row=0&row_limit=10000&sort_field=conversion_date&sort_descending=false";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}
	public function getClicks() {
		$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;
		$url = "https://egtracking.com/api/7/reports.asmx/Clicks?api_key=$this->api_key&start_date=$start&end_date=$end&affiliate_id=$this->affID&advertiser_id=0&offer_id=0&campaign_id=0&creative_id=0&include_tests=false&start_at_row=0&row_limit=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}



	/************************************************************************
	--------------------------- AFFILIATE SPECIFIC API CALLS --------------------------
    *************************************************************************/
    //Bills
    public function affiliateBills($key){
    	$url = "http://egtracking.com/affiliates/api/3/reports.asmx/Bills?api_key=$key&affiliate_id=$this->affID&start_at_row=1&row_limit=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }
    //Daily Summary
    public function affiliateDaily($key){
     	$s = str_replace("%20", " ", $this->starting);
		$e = str_replace("%20", " ", $this->ending);
		$s = date("M-d-Y", strtotime($s));
		$e = date("M-d-Y", strtotime($e));
		$sy = new DateTime($s);
		$ey = new DateTime($e);
		$em = new DateTime($e);
		$st = new DateTime($s);
		$em_now = new DateTime($e);
		$sm_now = new DateTime($s);
		$sy->createFromFormat("Y", $s);
		$ey->createFromFormat("Y", $e);
		$em->createFromFormat("m +1 Month", $e);
		$em->add(new DateInterval('P1M'));
		$em_now->createFromFormat('m', $e);
		$sm_now->createFromFormat('m', $s);
		$start = $sm_now->format('m') . "-1-" . $sy->format("Y");
		$end = $em_now->format('m') != '12' ? $em->format("m")."-01-".$ey->format("Y") : $em->format("m") . "-01-" . date('y', strtotime($ey->format("Y") . " +1 year"));
		$url = "https://egtracking.com/affiliates/api/2/reports.asmx/DailySummary?api_key=$key&affiliate_id=$this->affID&start_date=$start&end_date=$end&offer_id=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }
	//Offer
	public function affiliateOfferFeed($key){
		$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;
		$url = "http://egtracking.com/affiliates/api/4/offers.asmx/OfferFeed?api_key=$key&affiliate_id=$this->affID&start_date=$start&end_date=$end&media_type_category_id=0&campaign_name=0&vertical_category_id=0&vertical_id=0&offer_status_id=0&tag_id=0&start_at_row=1&row_limit=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}

    //Clicks
    public function affiliateClicks($key){
     	$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;
    		$url = "http://egtracking.com/affiliates/api/3/reports.asmx/Clicks?api_key=$key&affiliate_id=$this->affID&start_date=$start&end_date=$end&offer_id=0&campaign_id=0&Include_duplicates=FALSE&start_at_row=1&row_limit=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }
    //Conversions
    public function affiliateConversions($key){
     	$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;
    		$url = "http://egtracking.com/affiliates/api/3/reports.asmx/Conversions?api_key=$key&affiliate_id=$this->affID&start_date=$start&end_date=$end&offer_id=0&start_at_row=1&row_limit=0&currency_id=0&exclude_bot_traffic=TRUE";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }
    //Hourly Summary
    public function affiliateHourly($key){
     	$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;
    		$url = "http://egtracking.com/affiliates/api/2/reports.asmx/HourlySummary?api_key=$key&affiliate_id=$this->affID&start_date=$start&end_date=$end&offer_id=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }
    //Performance Summary
    public function affiliatePerformance($key){
    	$url = "http://egtracking.com/affiliates/api/2/reports.asmx/PerformanceSummary?api_key=$key&affiliate_id=$this->affID&date=".date("m/d/Y");
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }
    //SubAffiliate Summary
    public function affiliateSubAffiliate($key){
     	$s = strstr($this->starting, "%20", true);
		$e = strstr($this->ending, "%20", true);
		$st = str_replace("%20", "", strstr($this->starting, "%20", false));
		$et = str_replace("%20", "", strstr($this->ending, "%20", false));
		$start = date("m-d-Y", strtotime($s))."%20".$st;
		$end = date("m-d-Y", strtotime($e))."%20".$et;
    		$url = "http://egtracking.com/affiliates/api/3/reports.asmx/SubAffiliateSummary?api_key=$key&affiliate_id=$this->affID&start_date=$start&end_date=$end&offer_id=0&start_at_row=1&row_limit=0";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
    }



	/*
	 * Make Proper Timezone
	 */
	private function timezone($dateString, $pos) {
		$date = new DateTime($dateString);
		switch($this->tz) {
			case '1' :
				//PST
				if ($pos == 'start') {
					return $date -> format("M-d-Y%2000:00:00");
				} else {
					return $date -> format("M-d-Y%2023:59:59");
				}
				break;
			case '2' :
				//MST
				if ($pos == 'start') {
					return $date -> modify("-1 day") -> format("M-d-Y%2023:00:00");
				} else {
					return $date -> format("M-d-Y%2023:59:59");
				}
				break;
			case '3' :
				//CST
				if ($pos == 'start') {
					return $date -> modify("-1 day") -> format("M-d-Y%2022:00:00");
				} else {
					return $date -> format("M-d-Y%2023:59:59");
				}
				break;
			case '4' :
				//EST
				if ($pos == 'start') {
					return $date -> modify("-1 day") -> format("M-d-Y%2021:00:00");
				} else {
					return $date -> format("M-d-Y%2023:59:59");
				}
				break;
		}
	}




	/*
	 * CURL Call
	 *
	 */
	protected function callMeMaybe($url) {
		//echo $url;
		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, $url);
		curl_setopt($curlSession, CURLOPT_FAILONERROR, 0);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlSession, CURLOPT_TIMEOUT, 5000);
		curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, 1);
		$rawresponse = curl_exec($curlSession);
		curl_close($curlSession);
		return $rawresponse;
	}

	public function getCreativeInfoOffers($oid){
		$url = "http://egtracking.com/api/3/export.asmx/Creatives?api_key=$this->api_key&creative_id=0&creative_name=&offer_id=$oid&creative_type_id=0&creative_status_id=0&start_at_row=1&row_limit=3&sort_field=creative_id&sort_descending=FALSE";
		$xml = $this -> callMeMaybe($url);
		return new SimpleXMLElement($xml);
	}

    /***** SPECIAL FUNCTIONS *******/

    public function grabAdvertisers(){
        $advertisers = $this->getAdvertisers();

        $advertisers = (array) $advertisers;
        $advertisers = (array) $advertisers['advertisers'];
        $advertisers = $advertisers['advertiser'];

        $count = 0;

        foreach($advertisers as $adv){
            $adv = (array) $adv;
            $results[$adv['advertiser_id']] = ucwords($adv['advertiser_name']);
            $count++;
        }

        return $results;

    }

    public function grabOffersWithTags(){

        $offers = $this->getAdvOffers();


        $offers = (array) $offers;
        $offers = (array) $offers['offers'];
        $offers = (array) $offers['offer'];

        foreach($offers as $offer){

            $offer = (array) $offer;


            if($offer['tags']){

                $advertiser = (array) $offer['advertiser'];
                $advertiser_name = $advertiser['advertiser_name'];
                $advertiser_id = $advertiser['advertiser_id'];

                $tag = (array) $offer['tags']; // select <tags></tags> nest
                $tag = (array) $tag['tag'];

                if(isset($tag['tag_name']) && isset($tag['tag_id'])){ // make sure we have a tag
                    $tag_name = $tag['tag_name'];

                    $tag_id = $tag['tag_id'];

                    $tag_group[$tag_id]['tag_name'] = $tag_name;
                    $tag_group[$tag_id]['tag_id'] = $tag_id;
                    $tag_group[$tag_id]['advertiser_name'] = $advertiser_name;
                    $tag_group[$tag_id]['advertiser_id'] = $advertiser_id;

                    if(!isset($tag_group[$tag_id]['num_offers'])) {
                        $tag_group[$tag_id]['num_offers'] = 1; // set initial offer count
                    }
                    else{
                        $tag_group[$tag_id]['num_offers']++;
                    }

                    $vertical = (array) $offer['vertical'];
                    $vertical = $vertical['vertical_name'];
                    $tag_group[$tag_id]['vertical'] = $vertical; // set the vertical

                    $tag_group[$tag_id]['offer_ids'][] = $offer['offer_id']; // load up the product id's that belong to this tag id
                }
            }
        }

        return $tag_group;

    }

    public function generateCapAddSelect(){

        $tag_groups = $this->grabOffersWithTags();

        $count = 0;

        foreach($tag_groups as $tag_group){
            $results[$tag_group['tag_id']] = ucwords($tag_group['advertiser_name']) . ' - ' . ucwords($tag_group['tag_name']) . ' (' . $tag_group['num_offers'] . ')';
            $count++;
        }

        return $results;


    }

    public function grabOffers($adv_id){

        $offers = $this->getAdvOffersByAdv($adv_id);
        $offers = (array) $offers;
        $offers = (array) $offers['offers'][0];
        $offers = $offers['offer'];

        $count = 0;


        foreach($offers as $offer){

            $offer = (array) $offer;
            echo "offer: {$count}";
            echo "<pre>";

            if($offer['tags']){
                $tag = (array) $offer['tags'];
                $tag = (array) $tag['tag'];
                $tag = $tag['tag_name'];
                echo "tag: {$tag}";
            }

            echo "</pre>";
            $count++;
        }

    }

}


/*$cake_test = new CakeApiController();
$cake_test->grabAdvertisers();
$cake_test->grabOffers('79');
$cake_test->generateCapSelect();


*/


// only show advertisers who have offers, who have tags
