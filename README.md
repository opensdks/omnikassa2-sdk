# ROFE PHP SDK

This is a fork of the official Rabobank Omnikassa v2 SDK which was packaged as `opensdks/omnikassa2-sdk`. All that has changed is:

- removal of the english Documentation PDF
- support Guzzle6
- support for non-integer OrderIDs (i.e. HEX)

## Usage

- `composer require opensdks/omnikassa2-sdk`
- use the library (luke) (as documented in the PDF)
```php
<?php
require 'vendor/autoload';

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Money;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\OrderItem;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrand;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrandForce;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\ProductType;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request\MerchantOrder;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Address;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\CustomerInformation;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\VatCategory;

$orderItems = [OrderItem::createFrom([
    'id' => '1',
    'name' => 'Test product',
    'description' => 'Description',
    'quantity' => 1,
    'amount' => Money::fromDecimal('EUR', 99.99),
    'tax' => Money::fromDecimal('EUR', 21.00),
    'category' => ProductType::DIGITAL,
    'vatCategory' => VatCategory::HIGH
])];
$shippingDetail = Address::createFrom([
    'firstName' => 'Jan',
    'middleName' => 'van',
    'lastName' => 'Veen',
    'street' => 'Voorbeeldstraat',
    'postalCode' => '1234AB',
    'city' => 'Haarlem',
    'countryCode' => 'NL',
    'houseNumber' => '5',
    'houseNumberAddition' => 'a'
]);
$billingDetails = Address::createFrom([
    'firstName' => 'Jan',
    'middleName' => 'van',
    'lastName' => 'Veen',
    'street' => 'Factuurstraat',
    'postalCode' => '2314BA',
    'city' => 'Haarlem',
    'countryCode' => 'NL',
    'houseNumber' => '15'
]);
$customerInformation = CustomerInformation::createFrom([
    'emailAddress' => 'jan.van.veen@gmail.com',
    'dateOfBirth' => '20-03-1987',
    'gender' => 'M',
    'initials' => 'J.M.',
    'telephoneNumber' => '0204971111'
]);
$order = MerchantOrder::createFrom([
    'merchantOrderId' => '100',
    'description' => 'Order ID: 100',
    'orderItems' => $orderItems,
    'amount' => Money::fromDecimal('EUR', 99.99),
    'shippingDetail' => $shippingDetail,
    'billingDetail' => $billingDetails,
    'customerInformation' => $customerInformation,
    'language' => 'NL',
    'merchantReturnURL' => 'http://localhost`/',
    'paymentBrand' => PaymentBrand::IDEAL,
    'paymentBrandForce' => PaymentBrandForce::FORCE_ONCE
]);

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Environment;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SigningKey;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\endpoint\Endpoint;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\connector\TokenProvider;

/**
 * This is an in memory token provider copied from the official doc (PDF)
 * Class InMemoryTokenProvider
 */
class InMemoryTokenProvider extends TokenProvider
{
    private $map = array();
    
    /**
     * Construct the in memory token provider with the given refresh token.
     * @param string $refreshToken The refresh token used to retrieve the access tokens with.
     */
    public function __construct($refreshToken)
    {
        $this->setValue(static::REFRESH_TOKEN, $refreshToken);
    }
    
    /**
     * Retrieve the value for the given key.
     *
     * @param string $key
     * @return string Value of the given key or null if it does not exists.
     */
    protected function getValue($key)
    {
        return array_key_exists($key, $this->map) ? $this->map[$key] : null;
    }
    
    /**
     * Store the value by the given key.
     *
     * @param string $key
     * @param string $value
     */
    protected function setValue($key, $value)
    {
        $this->map[$key] = $value;
    }
    
    /**
     * Optional functionality to flush your systems.
     * It is called after storing all the values of the access token and can be used for example to clean caches or reload changes from the database.
    */
    protected function flush()
    {
    }
}

// Please make sure to have your signing-key and refreshtoken ready. These are provided via the dashboard of Rabobank
$endpoint = Endpoint::createInstance(
    ENVIRONMENT::PRODUCTION, // ENVIRONMENT::SANDBOX
    new SigningKey(base64_decode($YOUR_GIVEN_SIGNINGKEY_AS_PROVIDED_BY_RABOBANK)),
    new InMemoryTokenProvider($YOUR_GIVEN_REFRESHTOKEN_AS_PROVIDED_BY_RABOBANK)
);

$redirectUrl = $endpoint->announceMerchantOrder($order);
// Redirect user to Rabo OmniKassa
header('Location: ' . $redirectUrl);
die();                                 
