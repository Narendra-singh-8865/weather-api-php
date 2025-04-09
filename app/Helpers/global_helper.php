<?php

use App\Helpers\CommonAttributeHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


function get_wish() {
    $Hour = date('G');

    if ($Hour >= 1 && $Hour <= 11) {
        return "Morning,";
    } else if ($Hour >= 12 && $Hour <= 18) {
        return "Afternoon,";
    } else if ($Hour >= 19 || $Hour <= 24) {
        return "Evening,";
    }

    return "Morning,";
}


function get_date($start_date=NULL) {

    $start_date = $start_date ?? date('Y-m-d');
    return date('D jS M', strtotime($start_date));
}

function get_date_from_unix_timestamp($start_date=NULL) {


    return date('D jS M, ', $start_date);
}

function get_datetime_from_unix_timestamp($start_date=NULL) {
    return date('D jS M Y g:ia', $start_date);

}


function get_time($time=NULL) {

    $time = $time??date('H:i:s');
    // Create a DateTime object from the input time
    $dateTime = new DateTime($time);

    // Format the time according to your requirements
    $formattedTime = $dateTime->format('H:i');
    $timesplit = explode(':', $formattedTime);

    $min = ($timesplit[0] * 60) + ($timesplit[1]);

    if ($min % 60 < 1) {
        return $dateTime->format('ga');
    } else {
        return $dateTime->format('g:ia');
    }
}


function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function get_event_image_path($event_image)
{
    if (!empty($event_image)) {
//        $event_prefix = "event-image";
//        $appartment_prefix = "appartment-image";
//        $crop_prefix = "crop-event";
//        $blur_prefix = "blur-event";

        // this condition has been added temporarily will remove once image files move to staging servers.
//        if ((strpos($event_image, $event_prefix) === 0) || strpos($event_image, $appartment_prefix) === 0 || (strpos($event_image, $crop_prefix) === 0) || (strpos($event_image, $blur_prefix) === 0)) {
//
//        }

        return config('constants.CT_LISTING_IMAGE') . $event_image;
    }

    return '';
}

function get_common_email_variables($vendor_id)
{

    $vendors = collect(config('constants.VENDORS'))->keyBy('vendor_id');
    $vendor = $vendors[$vendor_id];


    $best_from = $vendor['best_from'];
    $company = $vendor['company'];
    $company_email = $vendor['vendor_email'];
    $full_name = $vendor['full_name'];
    $vendor_website = $vendor['vendor_website'];
    $logo = $vendor['logo'];
    $brand_color = $vendor['brand_color'];
    $footer_text = $vendor['footer_text'];

    $getWish = get_wish();
    return ['footer_text'=>$footer_text,'brand_color'=>$brand_color,'logo'=>$logo,'best_from' => $best_from, 'salutation' => $getWish, 'company' => $company, 'company_email' => $company_email, 'full_name' => $full_name,'vendor_website'=>$vendor_website];
}

function get_from_email_by_vendor($vendor_id)
{
    $vendors = collect(config('constants.VENDORS'))->keyBy('vendor_id');
    $vendor = $vendors[$vendor_id];

    return $vendor['vendor_email'];
}

function clean_input($input) {
    // Remove HTML tags
    $input = strip_tags($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    // Decode entities like &#039; back to characters
    $input = html_entity_decode($input, ENT_QUOTES, 'UTF-8');
    // Trim whitespace
    return trim($input);
}

function ref_id() {
    $refId = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $refId = strtoupper(chr(rand(97, 122)) . chr(rand(97, 122))) . $refId;
    return $refId;
}

function get_image_url($image,$fully_booked)
{
    $image=str_replace("png","jpg",$image);
    if (strpos($image, 'local') !== false)
    {


        if ($fully_booked==1)
        {
            $event_image=config('constants.LOCAL_EVENT_IMAGE').$image;
        }
        else
        {
            $event_image=config('constants.LOCAL_EVENT_IMAGE').$image;
        }

    }
    else
    {


        $event_image=config('constants.DO_EVENT_IMAGE').$image;

        if ($fully_booked==1)
        {
            $event_image=config('constants.DO_EVENT_IMAGE').$image;
        }
        else
        {
            $event_image=config('constants.DO_EVENT_IMAGE').$image;
        }
    }

    return  $event_image;
}




function IdentifySupplier($booking_id)
{

    if (str_contains($booking_id, 'ING')) {

        $booking_id = str_replace('ING-', "", $booking_id);
        $array = ['booking_id' => $booking_id, 'supplier' => 'ING'];
    } else if (str_contains($booking_id, 'TTG')) {
        $booking_id = str_replace('TTG_', "", $booking_id);

        $array = ['booking_id' => $booking_id, 'supplier' => 'TTG'];
    } else if (str_contains($booking_id, 'LTD')) {
        $booking_id = str_replace('LTD_', "", $booking_id);

        $array = ['booking_id' => $booking_id, 'supplier' => 'LTD'];
    } else {
        $array = ['booking_id' => $booking_id, 'supplier' => 'CT'];
    }
    return $array;
}


function encodeURIComponent($str)
{
    $revert = [
        "%21" => "!",
        "%2A" => "*",
        "%27" => "'",
        "%28" => "(",
        "%29" => ")",
    ];
    return strtr(rawurlencode($str), $revert);
}





function get_query($query){

    $sql = $query->toSql();

    $sql = $query->toSql();
$bindings = $query->getBindings();


foreach ($bindings as $binding) {
$pos = strpos($sql, '?');
if ($pos !== false) {
$sql = substr_replace($sql, "'" . $binding . "'", $pos, 1);
}
}


echo $sql;
die;

}


function address_withcomma($address) {
    $address = explode(',', $address);
    $address = array_filter($address);
    return implode(', ', $address);
}

function create_get_public_temp_folder()
{
    $temp_path = 'storage/temp_files';
    // creating temp folder if not exists
    $temp_folder = public_path($temp_path);
    if (!File::exists($temp_folder)) {
        File::makeDirectory($temp_folder);
    }

    return [ 'temp_folder' => $temp_folder, 'temp_path' => $temp_path ];
}

function get_tickets_type_pdf($ticket_type)
{
    $ticket_type = (int) $ticket_type;

    switch ($ticket_type) {
        case 51 : return 'etickets - scan for entry ';
        case 52 : return 'Collect from Rep at meeting point';
        case 53 : return 'Seat Numbers to be Allocated';
        case 54 : return 'Seat Numbers to be Allocated (by venue)';

        case 55:
        case 56 : return 'Standing – General Admission';

        case 57 : return 'Online Streaming Events';

        default: return 'Collection from Box Office - Best Available';
    }
    // 'Stream Only', 'Stream + Book Package';
}

function delete_file($array) {
    if (is_array($array)) {
        foreach ($array as $value) {
            unlink($value);
        }
    } else {
        unlink($array);
    }
}

 function amount_round($price){

    return number_format((float)$price, 2, '.', '');

 }

function booking_type_terms($is_flex)
{
    if ($is_flex) {
        return '<p style="font-size:14px;font-family:Arial,serif;background:white;"><span style="font-size:14px;font-family:Arial,Helvetica,sans-serif;color:blue;">Your flexi bookings can be cancelled within your account with sufficient notice for wallet credits as per below:</span></p>

    <ol style="list-style-type: disc;
    color:blue;
    margin-block-start: 10px;
    margin-block-end: 0px;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 30px;">
        <li><span style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:blue;">More than 24 hours &ndash; 100% wallet credit.</span></li>
        <li><span style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:blue;">Between 8-24 hours &ndash; 50% wallet credit.</span></li>
        <li><span style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:blue;">Less than 8 hours &ndash; no account credit.</span></li>
    </ol>
    <p style="color:blue;">Flexi-benefits are valid once and any refunds are made back into your account wallet and do not include the premium paid for the flexi-ticket.</p>';
    } else {
        return '<p style="font-size:14px;font-family:Arial,serif;background:white;"><span style="font-size:14px;font-family:Arial,Helvetica,sans-serif;">Please cancel your booking within your account if you can\'t attend providing at least 3 hours notice. Venues will report no-shows, and failure to notify us in advance may result in a permanent account pause.</span></p>';
    }

}

function render_collection_instruction($value)
{
    return '<p style="font-size:14px;font-family:Arial,serif;background:white;"><span style="font-size:14px;font-family:Arial,Helvetica,sans-serif;">' . $value . '</span></p>';
}

function formate_mobile($mobileNumber) {

    if($mobileNumber=="") return $mobileNumber;
    // Remove whitespace
    $mobileNumber = preg_replace('/\s+/', '', $mobileNumber);

    // Remove +44 or 44 if present
    if (substr($mobileNumber, 0, 3) === '+44') {
        $mobileNumber = '0' . substr($mobileNumber, 3);
    } elseif (substr($mobileNumber, 0, 2) === '44') {
        $mobileNumber = '0' . substr($mobileNumber, 2);
    }

    // Add 0 at the front if not present
    if (substr($mobileNumber, 0, 1) !== '0') {
        $mobileNumber = '0' . $mobileNumber;
    }



    return $mobileNumber;
}

function convertToInternationalFormat($mobileNumber) {
    // Remove whitespace
    $mobileNumber = preg_replace('/\s+/', '', $mobileNumber);

    // Check if the number starts with '0'
    if (substr($mobileNumber, 0, 1) === '0') {
        // Replace '0' with '+44'
        $mobileNumber = '+44' . substr($mobileNumber, 1);
    }

    return $mobileNumber;
}

function check_disposable_email($email) {

    
    // List of common disposable email domains (you can extend this list)
    $disposableDomains = [
        'mailinator.com',
        '10minutemail.com',
        'guerrillamail.com',
        'throwawaymail.com',
        'temp-mail.org',
        'sharklasers.com',
        'getnada.com',
        'yopmail.com',
        'inboxkitten.com'
        // Add more disposable email providers as needed
    ];

    // Extract the domain from the email
    $emailParts = explode('@', $email);

    if (count($emailParts) != 2) {
        return false; // Invalid email format
    }

    $localPart = $emailParts[0];
    $domainPart = strtolower($emailParts[1]); // Case-insensitive domain check

    // Check if the domain is in the disposable domains list
    if (in_array($domainPart, $disposableDomains)) {
        return false; // It's a disposable email
    }

    // Check if the local part contains a "+" (alias in Gmail)
    if (strpos($localPart, '+') !== false) {
        return false; // Aliased email
    }

    return true; // It's a valid, non-disposable, non-aliased email
}

function password_verification($model, $current_password) {

    if (is_null($model->password_updated_at)) {
        return sha1($current_password) == $model->password;
    } else {
        return Hash::check($current_password , $model->password);
    }
}
function encode($string){

    return Crypt::encryptString($string);
}

function decode($string){

    return Crypt::decryptString($string);
}


function maskEmail($email)
{

    $parts = explode("@", $email);


    $name = $parts[0] ??'';
    $domain = $parts[1]??'';

    $maskedName = substr($name, 0, 1) . str_repeat('*', max(0, strlen($name) - 2)) . substr($name, -1);

    return $maskedName . '@' . $domain;
}

function get_postman_request()
{
    $method = strtoupper(request()->method());
    $url = request()->fullUrl();
    $headers = request()->headers->all();
    $body = request()->getContent();

    // Include only essential headers
    $essentialHeaders = ['authorization', 'content-type'];
    $headerString = '';
    foreach ($headers as $key => $values) {
        if (in_array(strtolower($key), $essentialHeaders)) {
            $headerString .= "-H \"" . addslashes($key) . ": " . addslashes($values[0]) . "\" ";
        }
    }

    // Handle body data
    $dataString = '';
    if (!empty($body) && $method !== 'GET') {
        $dataString = "-d \"" . addslashes($body) . "\" ";
    }

    // Build the curl command
    $curlCommand = "curl -X {$method} \"{$url}\" {$headerString}{$dataString}";

    return $curlCommand;
}

function cross_vendor_registration_messages($site_vendor_id, $member_vendor_id) {

    $config_vendors = collect(config('constants.VENDORS'))->keyBy('vendor_id')->toArray();

    if ($site_vendor_id == config('constants.VENDORS.NHS.vendor_id') && $member_vendor_id == config('constants.VENDORS.CT.vendor_id')) {
        return "{$config_vendors[$site_vendor_id]['company']} is operated by {$config_vendors[$member_vendor_id]['company']}, so you don't need a separate account if you're already registered. Simply send us an email at ({$config_vendors[$site_vendor_id]['vendor_email']}), and we'll merge your account, allowing you to use it across both platforms.";
    } else if ($site_vendor_id == config('constants.VENDORS.AJ.vendor_id') && $member_vendor_id == config('constants.VENDORS.NHS.vendor_id')) {
        return "{$config_vendors[$site_vendor_id]['company']} operated by the same company that powers {$config_vendors[$member_vendor_id]['company']}, so you don't need a separate account if you're already registered. Simply send us an email at ({$config_vendors[$site_vendor_id]['vendor_email']}), and we'll merge your account, allowing you to use it across both platforms.";
    } else if ($site_vendor_id == config('constants.VENDORS.CT.vendor_id') && $member_vendor_id == config('constants.VENDORS.NHS.vendor_id')) {
        return "{$config_vendors[$site_vendor_id]['company']} also runs by {$config_vendors[$member_vendor_id]['company']}, so you don't need a separate account if you're already registered. Simply send us an email at ({$config_vendors[$site_vendor_id]['vendor_email']}), and we'll merge your account, allowing you to use it across both platforms.";
    } else if ($site_vendor_id == config('constants.VENDORS.NHS.vendor_id') && $member_vendor_id == config('constants.VENDORS.AJ.vendor_id')) {
        return "{$config_vendors[$site_vendor_id]['company']} is operated by the same company that powers {$config_vendors[$member_vendor_id]['company']}, so you don't need a separate account if you're already registered. Simply send us an email at ({$config_vendors[$site_vendor_id]['vendor_email']}), and we'll merge your account, allowing you to use it across both platforms.";
    }

    return "Because we work closely with {$config_vendors[$member_vendor_id]['company']}, we don't accept their members and they don't accept ours to prevent any cross over and maintain good rapport.  Thanks for your understanding.";

}

/* Removing spacial chars from Opayo */
function removeSpecialChars($inputString) {

    $cleanString = preg_replace('/[^A-Za-z0-9\s]/', ' ', $inputString);
    $cleanString = preg_replace('/\s+/', ' ', $cleanString);
    $cleanString = trim($cleanString);

    return substr($cleanString, 0, 20);

}


if (!function_exists('number_to_alphabet')) {
    function number_to_alphabet(int $number): string {
        $alphabet = '';
        while ($number > 0) {
            $number--; // Make it zero-based
            $alphabet = chr($number % 26 + 65) . $alphabet;
            $number = intdiv($number, 26); // Integer division
        }
        return $alphabet;
    }
}

function custom_encrypt($value, $serialize = true)
{

    $skey = "CNTICKETSS_PRODUCT-CRTD16092016\0";
    $encryptMethod = 'AES-256-CBC';
    $key = 'CentralTickets1234';

    $key_n = hash('sha256', $skey);
    $iv = substr(hash('sha256', $key), 0, 16);
    $output = openssl_encrypt($value, $encryptMethod, $key_n, 0, $iv);
    return $output = base64_encode($output);
}


function custom_decrypt($payload, $unserialize = true)
{

    $skey = "CNTICKETSS_PRODUCT-CRTD16092016\0";
    $encryptMethod = 'AES-256-CBC';
    $key = 'CentralTickets1234';

    $key_n = hash('sha256', $skey);
    $iv = substr(hash('sha256', $key), 0, 16);
    return $output = openssl_decrypt(base64_decode($payload), $encryptMethod, $key_n, 0, $iv);
}

function getOrdinalSuffix($number)
{
    $lastDigit = $number % 10;
    $lastTwoDigits = $number % 100;

    if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
        return $number . 'th';
    }

    switch ($lastDigit) {
        case 1:
            return $number . 'st';
        case 2:
            return $number . 'nd';
        case 3:
            return $number . 'rd';
        default:
            return $number . 'th';
    }
}

function entity_id(){

    return Str::uuid()->toString();
}




