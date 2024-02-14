<?php

use Illuminate\Support\Facades\Config;

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
