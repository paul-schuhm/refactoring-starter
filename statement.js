import { Buffer } from 'node:buffer';

// Plays
const plays = {
    'hamlet': { 'name': 'Hamlet', 'type': 'tragedy' },
    'as-like': { 'name': 'As You Like It', 'type': 'comedy' },
    'othello': { 'name': 'Othello', 'type': 'tragedy' }
};

// Invoices
const invoices = {
    'bigco': {
        'customer': 'BigCo',
        'performances': [
            { 'playId': 'hamlet', 'audience': 55 },
            { 'playId': 'as-like', 'audience': 35 },
            { 'playId': 'othello', 'audience': 40 }
        ]
    }
};

/**
 * Génère la facture textuelle pour un client.
 * @param {Object} invoice - Les données de facturation du client
 * @param {Object} plays - Le catalogue des pièces
 * @returns {string}
 */
function statement(invoice, plays) {
    let totalAmount = 0;
    let volumeCredits = 0;
    let result = `Statement for ${invoice.customer}\n`;

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    for (const perf of invoice.performances) {
        const play = plays[perf.playId];
        let amount = 0;

        switch (play.type) {
            case 'tragedy':
                amount = 40000;
                if (perf.audience > 30) {
                    amount += 1000 * (perf.audience - 30);
                }
                break;
            case 'comedy':
                amount = 30000;
                if (perf.audience > 20) {
                    amount += 10000 + 500 * (perf.audience - 20);
                }
                amount += 300 * perf.audience;
                break;
            default:
                throw new Error(`unknown play type : ${play.type}`);
        }

        volumeCredits += Math.max(perf.audience - 30, 0);
        
        if (play.type === 'comedy') {
            volumeCredits += Math.floor(perf.audience / 5);
        }

        result += `\t${play.name} : ${formatter.format(amount / 100)} (${perf.audience} seats)\n`;
        totalAmount += amount;
    }
    
    result += `Amount owed is ${formatter.format(totalAmount / 100)}\n`;
    result += `You earned ${volumeCredits} credits\n`;

    return result;
}

// Affichage du résultat pour le premier client (BigCo)
console.log(statement(invoices.bigco, plays));
