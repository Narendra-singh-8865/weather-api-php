<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Logging;


class ApiSignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {



       $startTime = microtime(true);

       $input = $request->all();

        array_walk_recursive($input, function (&$input) {
            $input = clean_input($input);
        });

        $request->merge($input);


        // Add current logged-in member object to request
        $member = Auth::user(); // Assuming you are using Laravel's authentication

        if ($member) {
          
            $request->merge(['user_id' => $member->id]);
            $request->merge(['store_id' => $member->store_id]);
            $request->merge(['user_email' => $member->email]);
        }



        $response =  $next($request);





        $this->handleLogging($request,$response,$startTime);

        return $response;





    }


    public function handleLogging($request,$response,$startTime){



      $member_id = NULL;
      $store_id=NULL;
      if(Auth::user()){
        $member_id = Auth::user()->id;
        $store_id = Auth::user()->store_id;
      }

      $response_data = $response->getContent();
      if(strlen($response_data) > 5000){
        $response_data = NULL;
      }

      $url = $_SERVER['REQUEST_URI'];
      $url = str_replace('/frontend/', '', $url);
      $request_data = $request->all();


      $filteredData = collect($request_data)->mapWithKeys(function ($value, $key) {
        if (Str::contains($key, 'password')) {
            return [$key => '******'];
        }


      if (Str::contains($key, 'email') && !empty($value)) {
            $maskedEmail = maskEmail($value);
          return [$key => $maskedEmail];
      }
        return [$key => $value];
    });


    $endTime = microtime(true);

    $timeTaken = ($endTime - $startTime) * 1000;


      $insert = [
        'request_data' => json_encode($filteredData),
        'response_data' => $response_data,
        'store_id' => $store_id,
        'headers' => json_encode(getallheaders()),
        'url' => $url,
        'ip_address' => $request->ip(),
        'response_code' => $response->getStatusCode(),
        'user_id' => $member_id,
        'ttl_time' => $timeTaken,
      //  'response_code' => $response->getStatusCode(),
        'created_at' => date('Y-m-d H:i:s')
      ];


      Logging::create($insert);




    }
}
