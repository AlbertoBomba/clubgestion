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
	 * Generar órdenes de pago para un jugador cuando se asigna a un equipo.
	 *
	 * - El importe original de cada cuota se toma de payments_teams.amount
	 *   (cada cuota puede tener un importe distinto).
	 * - Las cuotas ya pagadas por el jugador en la temporada NO se regeneran.
	 * - Descuentos del jugador:
	 *     · descPerc: se aplica a cada cuota sobre su propio amount_original.
	 *     · descEnt : se reparte proporcionalmente entre las cuotas a generar
	 *                 según el peso de cada una.
	 *
	 * @param \App\Models\Player $player
	 * @param \App\Models\Team   $team
	 * @param int                $sportsSchoolId
	 * @param int                $userId
	 * @return array{generated:int,restored:int,skipped:int}
	 */
	function generatePlayerPayments($player, $team, $sportsSchoolId, $userId)
	{
		$generatedCount = 0;
		$restoredCount = 0;
		$skippedCount = 0;

		if (!$team->relationLoaded('payments')) {
			$team->load('payments');
		}

		if ($team->payments->isEmpty()) {
			return ['generated' => 0, 'restored' => 0, 'skipped' => 0];
		}

		$seasonId = $team->season_id;

		// Cuotas de la temporada ya pagadas por el jugador (para no regenerarlas)
		$paidCuotas = \App\Models\PaymentPlayer::where('player_id', $player->id)
			->where('sports_school_id', $sportsSchoolId)
			->where('state', 1)
			->whereHas('paymentTeam', function ($query) use ($seasonId) {
				$query->whereHas('team', function ($q) use ($seasonId) {
					$q->where('season_id', $seasonId);
				});
			})
			->pluck('cuota')
			->unique()
			->toArray();

		// Descuentos del jugador
		$totalDiscountEnt = $player->descEnt ? floatval($player->descEnt) : 0;
		$discountPercentage = $player->descPerc ? floatval($player->descPerc) : 0;

		// Cuotas del equipo a generar (excluyendo las ya pagadas)
		$paymentsToGenerate = $team->payments->filter(function ($payment) use ($paidCuotas) {
			return !in_array($payment->cuota, $paidCuotas);
		});

		if ($paymentsToGenerate->isEmpty()) {
			return ['generated' => 0, 'restored' => 0, 'skipped' => 0];
		}

		// Suma total de importes originales para el reparto proporcional del descuento fijo
		$totalAmountToGenerate = $paymentsToGenerate->sum(function ($payment) {
			return floatval($payment->amount ?? 0);
		});

		foreach ($paymentsToGenerate as $payment) {
			// Importe original de esta cuota tal cual está en payments_teams
			$amountOriginal = floatval($payment->amount ?? 0);

			// Reparto proporcional del descuento fijo según el peso de la cuota
			$discountEnt = ($totalAmountToGenerate > 0)
				? $totalDiscountEnt * ($amountOriginal / $totalAmountToGenerate)
				: 0;

			// Descuento porcentual aplicado sobre el importe de esta cuota
			$discountPerc = $amountOriginal * $discountPercentage / 100;

			// Importe final tras descuentos (nunca negativo)
			$amountFinal = max(0, $amountOriginal - $discountEnt - $discountPerc);

			$existsActive = \App\Models\PaymentPlayer::where('player_id', $player->id)
				->where('payment_id', $payment->id)
				->whereNull('deleted_at')
				->exists();

			if ($existsActive) {
				$skippedCount++;
				continue;
			}

			$deletedPayment = \App\Models\PaymentPlayer::where('player_id', $player->id)
				->where('payment_id', $payment->id)
				->whereNotNull('deleted_at')
				->first();

			if ($deletedPayment) {
				$deletedPayment->deleted_at = null;
				$deletedPayment->state = 0;
				$deletedPayment->payment_date = null;
				$deletedPayment->payment_order = null;
				$deletedPayment->payment_auth = null;
				$deletedPayment->payment_type = null;
				$deletedPayment->price = $team->price;
				$deletedPayment->amount_original = round($amountOriginal, 2);
				$deletedPayment->amount = round($amountFinal, 2);
				$deletedPayment->descEnt = round($discountEnt, 2);
				$deletedPayment->descPerc = $discountPercentage;
				$deletedPayment->updated_user = $userId;
				$deletedPayment->save();
				$restoredCount++;
				continue;
			}

			$code = \App\Models\PaymentCodeSequentials::getCode();

			\App\Models\PaymentPlayer::create([
				'player_id' => $player->id,
				'payment_id' => $payment->id,
				'sports_school_id' => $sportsSchoolId,
				'code' => $code,
				'state' => 0,
				'cuota' => $payment->cuota,
				'price' => $team->price,
				'amount_original' => round($amountOriginal, 2),
				'amount' => round($amountFinal, 2),
				'descEnt' => round($discountEnt, 2),
				'descPerc' => $discountPercentage,
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

