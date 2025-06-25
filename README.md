# Wallet

> A general-purpose wallet system for users, allowing them to add balance to their account. The site administrator can utilize the user's wallet balance through a set of available APIs.

* **Supported Payment Method:** PayPal/Stripe/Iyzipay
* **Minimum Deposit:** The minimum allowed deposit is 10.
* **Currency:** The default currency is **USD** (editable in `ossn_com.php`).
* **Amount Format:** Only whole numbers are supported — floating point values are not accepted.

### 🔐 **Seamless Payments (Stripe Only)**

Wallet now supports **seamless payments**, allowing users to securely save their card for future charges. This feature is only available when **Stripe** is configured as the payment gateway.

### 📧 **Transaction Notifications**

Users receive email notifications for every **credit or debit** transaction, including **both successful and failed** attempts.

### ⚙️ Configuration Constants

```php
define('WALLET_CURRENCY_CODE', 'USD');         // Your 3-letter currency code (e.g., USD)
define('WALLET_MINIMUM_LOAD', 10);             // Minimum wallet load (integer only)
define('WALLET_SEAMLESS_CHARGE', 1);           // Minimum charge to store card for seamless payments
````

## API ENDPOINTS

### ➖ Debit

```bash
CURL https://www.yourwebsite.com/api/v1.0/wallet/debit
```

### ➕ Credit

```bash
CURL https://www.yourwebsite.com/api/v1.0/wallet/credit
```

### 📥 Parameters & Responses

| Parameter       | Type    | Description                              | Required |
| --------------- | ------- | ---------------------------------------- | -------- |
| api\_key\_token | string  | Your API token                           | Yes      |
| guid            | integer | User GUID                                | Yes      |
| amount          | integer | Amount to debit (must be a whole number) | Yes      |
| description     | string  | Transaction description                  | Yes      |

### ✅ Sample JSON Response

```json
{
  "merchant": "Open Source Social Network",
  "url": "https:\/\/yourwebsite.com\/",
  "time_token": 1637513403,
  "payload": {
    "status": "success",
    "amount": "50",
    "guid": "1"
  },
  "code": "100",
  "message": "Request successfully executed"
}
```

## 🧩 Access Using PHP

```php
<?php
// Credit wallet
try {
    $user_guid = ossn_loggedin_user()->guid;
    $wallet = new Wallet\Wallet($user_guid);
    $amount = 20;
    $description = 'Some description';
    var_dump($wallet->credit($amount, $description));
} catch (Wallet\NoUserException $e) {
    echo $e->getMessage();
} catch (Wallet\CreditException $e) {
    echo $e->getMessage();
}

// Debit wallet
try {
    $user_guid = ossn_loggedin_user()->guid;
    $wallet = new Wallet\Wallet($user_guid);
    $amount = 20;
    $description = 'Some description';
    var_dump($wallet->debit($amount, $description));
} catch (Wallet\NoUserException $e) {
    echo $e->getMessage();
} catch (Wallet\DebitException $e) {
    echo $e->getMessage();
}

// Get wallet balance
$user_guid = ossn_loggedin_user()->guid;
$wallet = new Wallet\Wallet($user_guid);
echo $wallet->getBalance();

// Set new balance
$user_guid = ossn_loggedin_user()->guid;
$wallet = new Wallet\Wallet($user_guid);
echo $wallet->setBalance(<new amount>);
```