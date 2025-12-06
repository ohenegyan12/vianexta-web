<?php

namespace App\Constants;

class PaymentTypes
{
    const PAYPAL_CHECKOUT = 'PAYPAL_CHECKOUT';
    const PAYPAL_CRYPTO = 'PAYPAL_CRYPTO';
    
    /**
     * Get all available payment types
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::PAYPAL_CHECKOUT,
            self::PAYPAL_CRYPTO
        ];
    }
    
    /**
     * Check if a payment type is valid
     *
     * @param string $paymentType
     * @return bool
     */
    public static function isValid($paymentType)
    {
        return in_array($paymentType, self::getAll());
    }
    
    /**
     * Get the default payment type
     *
     * @return string
     */
    public static function getDefault()
    {
        return self::PAYPAL_CHECKOUT;
    }
}
