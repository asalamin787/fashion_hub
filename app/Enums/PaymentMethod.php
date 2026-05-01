<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CreditCard = 'credit_card';
    case Paypal = 'paypal';
    case CashOnDelivery = 'cash_on_delivery';
}
