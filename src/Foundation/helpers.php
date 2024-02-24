<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

const TAX_INVOICE       = 'Tax';
const PROFORMA_INVOICE  = 'Proforma';
const OVERDUE           = 'Overdue';
const VOID_STATUS       = 'Void';

if (!function_exists('stastusPending')) { function stastusPending() { return 'Pending'; } }
if (!function_exists('stastusPaid')) { function stastusPaid() { return 'Paid'; } }

/*
|------------------------------------------------------------------------------
| Session Helpers
|------------------------------------------------------------------------------
| in Laravel, you can have multiple session configurations with different
| expiration times. Laravel provides flexibility in configuring session drivers
| and options, allowing you to define separate session configurations as needed
| for your application.
|
*/
if (!function_exists('getSession')) {
    function getSession($key = null, $config = null, $default = null)
    {
        # Save the original default session driver
        $originalDriver = config('session.default');

        # Temporarily change the default session driver if a custom configuration is provided
        if ($config !== null && config()->has('session.drivers.' . $config)) {
            Config::set('session.default', $config);
        }

        # Access session data using the specified key
        $value = session($key, $default);

        # Restore the original default session driver
        Config::set('session.default', $originalDriver);

        return $value;
    }
}

if (!function_exists('putSession')) {
    function putSession($key, $content, $config = null)
    {
        # Save the original default session driver
        $originalDriver = config('session.default');

        # Temporarily change the default session driver if a custom configuration is provided
        if ($config !== null && config()->has('session.drivers.' . $config)) {
            Config::set('session.default', $config);
        }

        # Store the value in the session using the specified key
        session()->put($key, $content);

        # Restore the original default session driver
        Config::set('session.default', $originalDriver);
    }
}

if (!function_exists('clearSession')) {
    function clearSession($key, $config = null)
    {
        # Save the original default session driver
        $originalDriver = config('session.default');

        # Temporarily change the default session driver if a custom configuration is provided
        if ($config !== null && config()->has('session.drivers.' . $config)) {
            Config::set('session.default', $config);
        }

        # Clear the value from the session using the specified key
        session()->forget($key);

        # Restore the original default session driver
        Config::set('session.default', $originalDriver);
    }
}


/*
|------------------------------------------------------------------------------
| Localization Helpers:
|------------------------------------------------------------------------------
|
|
*/


/*
|------------------------------------------------------------------------------
| Formating Helpers:
|------------------------------------------------------------------------------
|
|
*/

if (!function_exists('formatUuid')) {
    function formatUuid($hexString)
    {
        # Format Your string as UUID-like
        return substr($hexString, 0, 8) . '-' .
            substr($hexString, 8, 4) . '-' .
            '4' . substr($hexString, 12, 3) . '-' .
            dechex(hexdec(substr($hexString, 16, 1)) & 0x3 | 0x8) . substr($hexString, 17, 3) . '-' .
            substr($hexString, 20, 12);
    }
}

if (!function_exists('deviceUniqueID')) {
  	function deviceUniqueID($key = 'device') {
    		# get device id if exist in reuest sesion
    		$deviceId = request()->session()->get($key);

    		if (!$deviceId) {
          # Generate unique device ID based on user-agent
          # by usin md5 generate string values
    			$deviceId = md5(request()->header('User-Agent'));
    			putSession([$key =>  $deviceId], 'put');
    		}

    		return $deviceId;
  	}
}

// if(!function_exists('greatingUser')) {
//     function greatingUser($withName = false)
//     {
//         $currentTime = nowAsdatetime();
//         $greeting = '';
//         if ($currentTime->hour >= 5 && $currentTime->hour < 12) {
//             $greeting = 'Good morning';
//         } elseif ($currentTime->hour >= 12 && $currentTime->hour < 18) {
//             $greeting = 'Good afternoon';
//         } else {
//             $greeting = 'Good evening';
//         }

//         // $greeting = Str::title($greeting)

//         if ($withName && Auth::check() && isset(Auth::user()->name)) {
//             $greeting = Auth::user()->name .' '.$greeting;
//         }

//         return $greeting;
//     }
// }



# INVOICES
if (!function_exists('invoiceTypeDisplay')) {
    function invoiceTypeDisplay($invoiceable)
    {
        if ($invoiceable->type == PROFORMA_INVOICE) {
            $invoiceableObject = [
                'color' => 'info',
                'type'  => Str::title($invoiceable->type) .' Invoice',
            ];
        } else {
            $invoiceableObject = [
                'color' => 'success',
                'type'  => Str::title($invoiceable->type) .' Invoice',
            ];
        }

        return (object)$invoiceableObject;
    }
}

if (!function_exists('invoiceStatusDisplay')) {
    function invoiceStatusDisplay($invoiceable)
    {
        $status = $invoiceable->status;
        $invoiceableObject['status'] = ($status == VOID_STATUS) ? 'Canceled' : Str::title($status);
        $invoiceableObject['color']  = ($status == stastusPaid()) ? 'success' :
            (($status == stastusPending()) ? 'info' :
                (($status == OVERDUE) ? 'warning' : 'danger')
            );

        return (object)$invoiceableObject;
    }
}
