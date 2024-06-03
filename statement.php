<?php

/**
 * Code de départ. Fournit la fonction pour délivrer 
 la facture aux clients pour les prestations réalisées
 */

declare(strict_types=1);


//Plays (loaded from JSON)
$plays = <<<LOADED_JSON
{
	"hamlet": {"name": "Hamlet", "type": "tragedy"},
	"as­like": {"name": "As You Like It", "type": "comedy"},
	"othello": {"name": "Othello", "type": "tragedy"}
}
LOADED_JSON;

//Invoices (loaded from JSON)
$invoices = <<<LOADED_JSON
[
	{
	"customer": "BigCo",
	"performances": [
	{
	"playID": "hamlet",
	"audience": 55
	},
	{
	"playID": "as-like",
	"audience": 35
	},
	{
	"playID": "othello",
	"audience": 40
	}
	]
	}
	]
LOADED_JSON;

/** 
 * Remarque : pour pas passer du temps en plus sur le formatage des données en entrée
 * on démarre avec des données fournies au format PHP (à voir ensuite si on a le temps d'ajouter
 * cette partie supplémentaire)
 * Tip : utiliser json_validate et json_decode
 * @link https://www.php.net/manual/en/ref.json.php
 */



$plays = [
	'hamlet' => [
		'type' => 'tragedy',
		'name' => 'Hamlet'
	],
	'as-like' => [
		'type' => 'comedy',
		'name' => 'As you like it'
	],
	'othello' => [
		'type' => 'tragedy',
		'name' => 'Othello'
	],
];

$invoices =  [
	'bigco' => [
		'customer' => 'BigCo',
		'performances' => [
			[
				'playId' => 'hamlet',
				'audience' => 55,
			],
			[
				'playId' => 'as-like',
				'audience' => 35,
			],
			[
				'playId' => 'othello',
				'audience' => 40,
			],
			
		]
	]
];

function statement(array $invoice, array $plays): string
{

	$totalAmount = 0;
	$volumeCredits = 0;
	$result =  "Statement for {$invoice['customer']}\n";

	//US Format currency
	$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

	foreach ($invoice['performances'] as $perf) {

		$play = $plays[$perf['playId']];
		$amount = 0;

		switch ($play['type']) {
			case 'tragedy':
				$amount = 40000;
				if ($perf['audience'] > 30) {
					$amount += 1000 * ($perf['audience'] - 30);
				}
				break;
			case 'comedy':
				$amount = 30000;
				if ($perf['audience'] > 20) {
					$amount += 10000 + 500 * ($perf['audience'] - 20);
				}
				$amount += 300 * $perf['audience'];
				break;
			default:
				throw new Exception("unknown play type : {$perf['type']}");
		}

		//Add volume credits
		$volumeCredits += max($perf['audience'] - 30, 0);
		//Add extra credit for every ten comedy attendees
		if ($play['type'] === 'comedy') {
			$volumeCredits += floor($perf['audience'] / 5);
		}

		$result .= "\t{$play['name']} : {$formatter->formatCurrency($amount / 100, 'USD')} ({$perf['audience']}) \n";
		$totalAmount += $amount;
	}

	//Print line for this order
	$result .= "Amount owed is {$formatter->formatCurrency($totalAmount / 100, 'USD')}\n";
	$result .= "You earned {$volumeCredits} credits\n";

	return $result;
}

//Print the statement for the first client (BigCo)
echo statement($invoices['bigco'], $plays);
