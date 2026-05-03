<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CreditCard = 'credit_card';
    case GooglePay = 'google_pay';
    case Paypal = 'paypal';
    case CashOnDelivery = 'cash_on_delivery';
}
