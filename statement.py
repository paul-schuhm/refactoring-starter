import math
import locale
from typing import Dict, Any

# Configuration de la locale pour le formatage monétaire en USD
try:
    locale.setlocale(locale.LC_ALL, 'en_US.UTF-8')
except locale.Error:
    # Alternative si la locale en_US n'est pas installée sur le système
    locale.setlocale(locale.LC_ALL, '')

# Plays (Dictionnaire)
plays: Dict[str, Dict[str, str]] = {
    "hamlet": {"name": "Hamlet", "type": "tragedy"},
    "as-like": {"name": "As You Like It", "type": "comedy"},
    "othello": {"name": "Othello", "type": "tragedy"}
}

# Invoices (Dictionnaire)
invoices: Dict[str, Any] = {
    "bigco": {
        "customer": "BigCo",
        "performances": [
            {"playId": "hamlet", "audience": 55},
            {"playId": "as-like", "audience": 35},
            {"playId": "othello", "audience": 40}
        ]
    }
}

def statement(invoice: Dict[str, Any], plays: Dict[str, Dict[str, str]]) -> str:
    total_amount = 0
    volume_credits = 0
    result = f"Statement for {invoice['customer']}\n"

    for perf in invoice['performances']:
        play = plays[perf['playId']]
        amount = 0

        match play['type']:
            case 'tragedy':
                amount = 40000
                if perf['audience'] > 30:
                    amount += 1000 * (perf['audience'] - 30)
            
            case 'comedy':
                amount = 30000
                if perf['audience'] > 20:
                    amount += 10000 + 500 * (perf['audience'] - 20)
                amount += 300 * perf['audience']
                
            case _:
                raise ValueError(f"unknown play type : {play['type']}")

        # Ajout des crédits de volume
        volume_credits += max(perf['audience'] - 30, 0)
        
        # Crédit supplémentaire pour toutes les 5 personnes à une comédie
        if play['type'] == 'comedy':
            volume_credits += math.floor(perf['audience'] / 5)

        # Formatage de la devise en USD
        # division par 100 car les montants de base sont stockés en centimes
        formatted_amount = locale.currency(amount / 100, grouping=True)

        # Affichage de la ligne de cette performance
        result += f"\t{play['name']} : {formatted_amount} ({perf['audience']} seats)\n"
        total_amount += amount

    formatted_total = locale.currency(total_amount / 100, grouping=True)
    result += f"Amount owed is {formatted_total}\n"
    result += f"You earned {volume_credits} credits\n"

    return result

# Affichage du résultat pour le premier client (BigCo)
print(statement(invoices['bigco'], plays))
