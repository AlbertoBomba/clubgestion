<?php

if (!function_exists('config_dl')) {
	/**
	 * Get / set the specified configuration value.
	 *
	 * If an array is passed as the key, we will assume you want to set an array of values.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default
	 * @return mixed|\Illuminate\Config\Repository
	 */
	function config_dl($key = null, $default = null)
	{
		if (is_null($key)) {
			return app('config-dl');
		}

		if (is_array($key)) {
			return app('config-dl')->set($key);
		}

		return app('config-dl')->get($key, $default);
	}
}

if (!function_exists('length')) {
	function length($element)
	{
		$count = 0;
		if (is_array($element)) {
			$count = count($element);
		} elseif (is_object($element)) {
			// For objects, check if they're Countable, otherwise count properties
			if ($element instanceof Countable) {
				$count = count($element);
			} else {
				$count = count(get_object_vars($element));
			}
		} elseif (is_string($element)) {
			$count = strlen($element);
		} else {
			$count = 0;
		}
		return ($count);
	}
}

// if (!function_exists('dl_signedRoute')) {
// 	function dl_signedRoute($name, $parameters = [], $absolute = true)
// 	{
// 		return dlURL::signedRoute($name, $parameters, $absolute);
// 	}
// }
// if (!function_exists('dl_signedPublicRoute')) {
// 	function dl_signedPublicRoute($name, $parameters = [], $absolute = true)
// 	{
// 		return dlURL::signedPublicRoute($name, $parameters, $absolute);
// 	}
// }
// if (!function_exists('dl_smcSign')) {
// 	function dl_smcSign($value)
// 	{
// 		return dlSign::smcSign($value);
// 	}
// }

if (!function_exists('dl_stringSVClean')) {
	function dl_stringSVClean(string $vcString, string $vcSeparator = ',', string $vcDefault = '')
	{
		$aSearch = [" ", ",", ".", "\n\r", "\r\n", "\n", "\r"];
		$vcString = str_replace($aSearch, $vcSeparator, $vcString);
		$vcString = preg_replace("/\\" . $vcSeparator . "+/", $vcSeparator, $vcString);
		$vcString = trim($vcString, $vcSeparator);
		$vcString = ($vcString == '') ? $vcDefault : $vcString;
		return $vcString;
	}
}

if (!function_exists('getBase64File')) {
	function getBase64File(string $vcFilePath)
	{
		if (!file_exists($vcFilePath)) {
			return null;
		}

		$fSource = fopen($vcFilePath, 'r');
		$content = stream_get_contents($fSource);
		fclose($fSource);

		return base64_encode($content);
	}
}

if (!function_exists('array_recursive_search_key_map')) {
	function array_recursive_search_key_map($needle, $haystack)
	{
		$needle = str_replace('\\', '', $needle);
		foreach ($haystack as $first_level_key => $value) {
			if ($needle === $value) {
				return array($first_level_key);
			} elseif (is_array($value)) {
				$callback = array_recursive_search_key_map($needle, $value);
				if ($callback) {
					//return array_merge(array($first_level_key), $callback);
					return $first_level_key;
				}
			}
		}
		return false;
	}
}

if (!function_exists('dl_file_size')) {
	function dl_file_size($iSize)
	{
		$aSizes = array('bytes', 'KB', 'MB', 'GB', 'TB');
		// Calcular vcSize
		$iEscala = intval(log($iSize, 2));
		$iEscala = ($iEscala < 1) ? 0 : $iEscala;
		$iOrdenB10 = intdiv($iEscala, 10);
		$iOrdenB10 = ($iOrdenB10 < 1) ? 0 : $iOrdenB10;
		return number_format($iSize / pow(1024, $iOrdenB10), 1, ',', '.') . ' ' . $aSizes[$iOrdenB10];
	}
}

if (!function_exists('dl_file_type')) {
	function dl_file_type($mime)
	{
		if (str_contains($mime, 'excel')) {
			return ['EXCEL', 'text-green'];
		}
		if (str_contains($mime, 'spreadsheet')) {
			return ['EXCEL', 'text-green'];
		}
		if (str_contains($mime, 'word')) {
			return ['WORD', 'text-blue'];
		}
		if (str_contains($mime, 'powerpoint')) {
			return ['POWERPOINT', 'text-red'];
		}
		if (str_contains($mime, 'pdf')) {
			return ['PDF', 'text-red'];
		}
		if (str_contains($mime, 'image')) {
			return ['IMAGE', 'text-yellow'];
		}
		return ['OTHER', 'text-black'];
	}
}

if (!function_exists('dl_decimalTime')) {
	function dl_decimalTime(string $vcValue)
	{
		$hms = explode(":", $vcValue);
		return ($hms[0] + (isset($hms[1]) ? ($hms[1] / 60) : 0));
	}
}

if (!function_exists('dl_stringTime')) {
	function dl_stringTime(float $dValue)
	{
		$hours = floor($dValue);
		$decimal = $dValue - $hours;
		$minutes = round($decimal * 60);
		return $hours . ":" . sprintf("%02d", $minutes);
	}
}

if (!function_exists('string2decimal')) {
	function string2decimal($value)
	{
		//Log::debug('string2decimal: '.$value);
		if ($value == null) $value = 0;
		$number = str_replace(',', '.', str_replace('.', '', $value));
		$number = str_replace('%', '', $number);
		$number = str_replace('€', '', $number);
		$number = trim($number);
		return (is_numeric($number) ? $number * 1 : $value);
	}
}

if (!function_exists('decimal2string')) {
	function decimal2string($value, $decimals = 'money2')
	{
		//Log::debug('decimal2string: '.$value);
		if ($value == null) $value = 0;
		if (!is_numeric($value)) {
			return $value;
		}
		$sufix = '';
		$ndecimals = 2;
		if ($decimals == 'money0') {
			$ndecimals = 0;
			$sufix = ' €';
		}
		if ($decimals == 'money2') {
			$ndecimals = 2;
			$sufix = ' €';
		}
		if ($decimals == 'money3') {
			$ndecimals = 3;
			$sufix = ' €';
		}
		if ($decimals == 'number0') {
			$ndecimals = 0;
			$sufix = '';
		}
		if ($decimals == 'number2') {
			$ndecimals = 2;
			$sufix = '';
		}
		if ($decimals == 'percent2') {
			$value = $value * 100;
			$ndecimals = 2;
			$sufix = ' %';
		}
		return number_format($value, $ndecimals, ',', '.') . $sufix;
	}
}

if (!function_exists('dl_file_type')) {
	function dl_file_type($mime)
	{
		if (str_contains($mime, 'excel')) {
			return ['EXCEL', 'text-green'];
		}
		if (str_contains($mime, 'spreadsheet')) {
			return ['EXCEL', 'text-green'];
		}
		if (str_contains($mime, 'word')) {
			return ['WORD', 'text-blue'];
		}
		if (str_contains($mime, 'powerpoint')) {
			return ['POWERPOINT', 'text-red'];
		}
		if (str_contains($mime, 'pdf')) {
			return ['PDF', 'text-red'];
		}
		if (str_contains($mime, 'image')) {
			return ['IMAGE', 'text-yellow'];
		}
		return ['OTHER', 'text-black'];
	}
}

if (!function_exists('dl_variable_get')) {
	function dl_variable_get($path, $array) {
		$path = explode('.', $path); //if needed
		$temp = $array;

		foreach($path as $key) {
			if (is_array($temp)) {
				$temp = $temp[$key];
			} else {
				$temp = $temp->{$key};
			}
		}
		return $temp;
	}
}

if (!function_exists('dl_var_export')) {
	function dl_var_export($expression, $return = FALSE)
	{
		if (!is_array($expression)) return var_export($expression, $return);
		$export = var_export($expression, TRUE);
		$export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
		$array = preg_split("/\r\n|\n|\r/", $export);
		$array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
		$export = join(PHP_EOL, array_filter(["["] + $array));
		if ((bool)$return) return $export;
		else echo $export;
	}
}

if (!function_exists('generatePlayerPayments')) {
	/**
	 * Generate payment orders for a player when assigned to a team
	 * This function checks if payments already exist (including soft deleted ones)
	 * and restores them if they were deleted, or creates new ones if they don't exist.
	 * 
	 * @param \App\Models\Player $player The player to generate payments for
	 * @param \App\Models\Team $team The team the player is being assigned to
	 * @param int $sportsSchoolId The sports school ID
	 * @param int $userId The user ID creating the payments
	 * @return array Array with 'generated' count, 'restored' count and 'skipped' count
	 */
	function generatePlayerPayments($player, $team, $sportsSchoolId, $userId)
	{
		$generatedCount = 0;
		$restoredCount = 0;
		$skippedCount = 0;

		// Load team payments if not already loaded
		if (!$team->relationLoaded('payments')) {
			$team->load('payments');
		}

		// If team has no payments, nothing to generate
		if ($team->payments->isEmpty()) {
			return ['generated' => 0, 'restored' => 0, 'skipped' => 0];
		}

		// Calculate total discounts for the player
		$totalDiscount = 0;
		$discountPercentage = 0;
		
		if ($player->descEnt) {
			$totalDiscount += floatval($player->descEnt);
		}
		
		if ($player->descPerc) {
			$discountPercentage = floatval($player->descPerc);
		}

		// Total number of payments to divide the discount
		$totalPayments = $team->payments->count();
		
		// Calculate discount per payment
		$discountPerPayment = $totalPayments > 0 ? $totalDiscount / $totalPayments : 0;

		// Process each payment from the team
		foreach ($team->payments as $payment) {
			// Check if player already paid this quota (cuota) in this season - regardless of team
			$existsPaidQuota = \App\Models\PaymentPlayer::where('player_id', $player->id)
				->where('cuota', $payment->cuota)
				->whereNull('deleted_at')
				->where('state', 1)
				->whereHas('paymentTeam', function($query) use ($team) {
					$query->where('season_id', $team->season_id);
				})
				->exists();

			if ($existsPaidQuota) {
				// Skip if this quota is already paid in this season
				$skippedCount++;
				continue;
			}

			// Check if this payment already exists and is paid (state = 1)
			$existsPaid = \App\Models\PaymentPlayer::where('player_id', $player->id)
				->where('payment_id', $payment->id)
				->whereNull('deleted_at')
				->where('state', 1)
				->exists();

			if ($existsPaid) {
				// Skip if already paid
				$skippedCount++;
				continue;
			}

			// Check if this active payment already exists (not soft deleted)
			$existsActive = \App\Models\PaymentPlayer::where('player_id', $player->id)
				->where('payment_id', $payment->id)
				->whereNull('deleted_at')
				->exists();

			if ($existsActive) {
				$skippedCount++;
				continue;
			}

			// Check if there's a soft deleted payment to restore
			$deletedPayment = \App\Models\PaymentPlayer::where('player_id', $player->id)
				->where('payment_id', $payment->id)
				->whereNotNull('deleted_at')
				->first();

			if ($deletedPayment) {
				// Restore the deleted payment
				$deletedPayment->deleted_at = null;
				$deletedPayment->state = 0; // Back to pending
				$deletedPayment->payment_date = null;
				$deletedPayment->payment_order = null;
				$deletedPayment->payment_auth = null;
				$deletedPayment->payment_type = null;
				$deletedPayment->updated_user = $userId;
				$deletedPayment->save();
				$restoredCount++;
				continue;
			}

			// Generate payment code
			$code = \App\Models\PaymentCodeSequentials::getCode();

			// Calculate original amount and with discount
			$amountOriginal = floatval($payment->amount);
			$amountWithDiscount = $amountOriginal;

			// Apply discount in euros (divided among all quotas)
			if ($discountPerPayment > 0) {
				$amountWithDiscount -= $discountPerPayment;
			}

			// Apply percentage discount
			if ($discountPercentage > 0) {
				$percentageDiscount = ($amountOriginal * $discountPercentage) / 100;
				$amountWithDiscount -= $percentageDiscount;
			}

			// Ensure amount is not negative
			$amountWithDiscount = max(0, $amountWithDiscount);

			// Calculate discounts applied to this quota
			$descEntApplied = $discountPerPayment;
			$descPercApplied = $discountPercentage;

			// Create payment order for the player
			\App\Models\PaymentPlayer::create([
				'player_id' => $player->id,
				'payment_id' => $payment->id,
				'sports_school_id' => $sportsSchoolId,
				'code' => $code,
				'state' => 0, // Pending
				'cuota' => $payment->cuota,
				'price' => $team->price, // Team enrollment price
				'amount_original' => $amountOriginal,
				'amount' => $amountWithDiscount,
				'descEnt' => $descEntApplied,
				'descPerc' => $descPercApplied,
				'created_user' => $userId,
			]);

			$generatedCount++;
		}

		return ['generated' => $generatedCount, 'restored' => $restoredCount, 'skipped' => $skippedCount];
	}
}

// ==========================================
// TENANT HELPERS
// ==========================================

if (!function_exists('tenantService')) {
	/**
	 * Get the tenant service instance
	 */
	function tenantService(): \App\Services\TenantService
	{
		return app('tenant');
	}
}

if (!function_exists('currentSchool')) {
	/**
	 * Get the current sports school
	 */
	function currentSchool(): ?\App\Models\SportsSchool
	{
		return tenantService()->getCurrentSchool();
	}
}

if (!function_exists('currentSchoolId')) {
	/**
	 * Get the current sports school ID
	 */
	function currentSchoolId(): ?int
	{
		return tenantService()->getCurrentSchoolId();
	}
}

if (!function_exists('tenantConfig')) {
	/**
	 * Get tenant configuration value
	 */
	function tenantConfig(string $key, $default = null)
	{
		return tenantService()->getConfig($key, $default);
	}
}

if (!function_exists('tenantLogo')) {
	/**
	 * Get the tenant logo URL
	 */
	function tenantLogo(): ?string
	{
		$school = currentSchool();
		return $school?->logo ? asset('storage/' . $school->logo) : null;
	}
}

if (!function_exists('tenantName')) {
	/**
	 * Get the tenant name
	 */
	function tenantName(): string
	{
		return currentSchool()?->name ?? config('app.name');
	}
}

if (!function_exists('isTenantContext')) {
	/**
	 * Check if we're in a tenant context
	 */
	function isTenantContext(): bool
	{
		return tenantService()->hasCurrentSchool();
	}
}

