# Wallet
A general wallet for users that they can charge.  Site admin can utilize that wallet balance using set of available APIs. PayPal is the method available  to load the wallet. Minimum amount is set is 10 and default current is USD.  You may can edit these details in ossn_com.php file. The wallet only supports the amounts that are not in floating points.

    define('WALLET_CURRENCY_CODE', 'USD'); //your 3 digits currency code from PayPal
    define('WALLET_MINIMUM_LOAD', 10);  //Minimum amount integer only (no floating)

## API END POINTS
### Debit 
    CURL https://www.yourwebsite.com/api/v1.0/wallet/debit
    
### Credit
    CURL https://www.yourwebsite.com/api/v1.0/wallet/credit

### Responces and parameter required

 | Parameter | Type |  Description | Required |
 | ------------- | -------------  | -------------  | -------------  |
 |api_key_token | string | Your API token | Yes | 
 |guid | integer | User GUID | Yes | 
 |amount | integer | Amount to debit must not be in points | Yes | 
 |description | integer | Description | Yes | 
 
``` 
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
## Access using PHP
```
<?php
....
....
try {
    $user_guid = ossn_loggedin_user()->guid;
    $wallet = new Wallet\Wallet($user_guid);
    $amount = 20;
    $description = 'Some description';
    var_dump($wallet->credit($amount, $description)); //credit amount
} catch (Wallet\NoUserException $e) {
    echo $e->getMessage();
}  catch (Wallet\CreditException $e) {
    echo $e->getMessage();
}

//debit

try {
    $user_guid = ossn_loggedin_user()->guid;
    $wallet = new Wallet\Wallet($user_guid);
    $amount = 20;
    $description = 'Some description';
    var_dump($wallet->debit($amount, $description)); //debit amount
} catch (Wallet\NoUserException $e) {
    echo $e->getMessage();
}  catch (Wallet\DebitException $e) {
    echo $e->getMessage();
}

//getting balance
$user_guid = ossn_loggedin_user()->guid;
$wallet = new Wallet\Wallet($user_guid);
echo $wallet->getBalance();

//changing balance
$user_guid = ossn_loggedin_user()->guid;
$wallet = new Wallet\Wallet($user_guid);
echo $wallet->setBalance(<new amount>);

```
