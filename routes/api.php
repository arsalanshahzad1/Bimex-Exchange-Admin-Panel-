<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/stripe', 'Api\Binance\StripeController@stripe'); // stripe payment
Route::post('/stripe-crypto', 'Api\Binance\StripeController@index'); // stripe payment
Route::group(['namespace' => 'Api\Binance', 'middleware' => ['auth:api','api-user', 'checkApi']], function() {
    /*Broker APIs*/
    Route::post('/subAccount', 'BrokerController@createSubAccount'); // Create Sub Account
    Route::get('/subAccount', 'BrokerController@querySubAccount'); // Get All Sub Accounts
    Route::get('/info', 'BrokerController@accountInformation'); // Broker Account Information
    Route::post('/subAccountApi', 'BrokerController@createSubAccountApiKey'); // Create SubAccount ApiKey
    Route::get('/subAccountApi', 'BrokerController@querySubAccountApiKey'); // Get All SubAccount ApiKey
    Route::delete('/subAccountApi', 'BrokerController@deleteSubAccountApiKey'); // Delete SubAccount ApiKey

    // Account configuration
    Route::get('/apiRestrictions', 'BrokerController@apiRestrictions'); // Get API Key Permission
    Route::get('/apiTradingStatus', 'BrokerController@apiTradingStatus'); // Account API Trading Status
    Route::get('/tradeFee', 'BrokerController@tradeFee'); // Trade Fee
    Route::get('/myTrades', 'BrokerController@myTrades'); // Account Trade List
    Route::get('/depositHistory', 'BrokerController@depositHistory'); // Deposit History
    Route::get('/withdrawHistory', 'BrokerController@withdrawHistory'); // Withdraw History
    
    // Spot Account Trade apis
    Route::group(['namespace' => 'Spot'], function () {
        Route::post('/newOrder', 'OrderController@newOrder');
        Route::delete('/cancelOrder', 'OrderController@cancelOrder'); // cancel order
        Route::delete('/cancelAllOrder', 'OrderController@cancelAllOrder'); // cancel all order
        Route::get('/getOpenOrders', 'OrderController@getOpenOrders'); // user open orders
        Route::get('/getAllOrders', 'OrderController@getAllOrders'); // user all orders
        // Wallet APIs
        Route::get('/getAllCoinsInfo', 'WalletController@allCoinInformation'); // All Coins' Information
        Route::get('/deposit-address', 'WalletController@depositAddress'); // Deposit Address (supporting network)
        Route::get('/getAccountInfo', 'WalletController@getAccountInfo'); // get wallet coins info
        Route::post('/applyForWithdraw', 'WalletController@applyForWithdraw'); // apply for withdraw
        Route::post('/transfer', 'WalletController@transfer'); // transfer
        Route::get('/getAccountSnapshot', 'WalletController@getAccountSnapshot'); // Daily Account Snapshot
        Route::get('/getSpotAndFiatBalance', 'WalletController@getSpotAndFiatBalance'); // get spot & fiat balance
    
    });
    Route::get('/getMyTradeHistory', 'SpotController@getMyTradeHistory');
    Route::get('/subAccountSpotSummery', 'SpotController@subAccountSpotSummery');

    Route::group(['prefix' => 'future'], function () {
        Route::group(['namespace' => 'Future'], function () {
            Route::post('/newOrder', 'OrderController@newOrder'); // add new order
            Route::post('/createMultipleOrder', 'OrderController@createMultipleOrder'); // store multiple orders
            Route::delete('/cancelOrder', 'OrderController@cancelOrder'); // cancel order
            Route::delete('/cancelAllOrder', 'OrderController@cancelAllOrder'); // cancel all order
            Route::post('/autoCancelAllOrder', 'OrderController@autoCancelAllOrder'); // auto cancel all order
            Route::get('/getOpenOrders', 'OrderController@getOpenOrders'); // user open orders
            Route::get('/getAllOrders', 'OrderController@getAllOrders'); // user all orders
            Route::get('/getForceOrders', 'OrderController@getForceOrders'); // user force orders
            Route::get('/getMyTrades', 'OrderController@getMyTrades'); // get my trades
            Route::post('/changePositionMode', 'SettingController@changePositionMode'); // changePositionMode
            Route::get('/getPositionMode', 'SettingController@getPositionMode'); // getPositionMode
            Route::post('/changeMultiAssetMode', 'SettingController@changeMultiAssetMode'); // changeMultiAssetMode
            Route::get('/getMultiAssetMode', 'SettingController@getMultiAssetMode'); // getMultiAssetMode
            Route::post('/changeInitialLeverage', 'SettingController@changeInitialLeverage'); // changeInitialLeverage
            Route::post('/changeMarginType', 'SettingController@changeMarginType'); // Change Margin Type
            Route::post('/modifyPositionMargin', 'SettingController@modifyPositionMargin'); // Modify position margin
            Route::get('/getPositionMargin', 'SettingController@getPositionMargin'); // Get position margin
            Route::get('/getPositionInformation', 'SettingController@getPositionInformation'); // Get position information
            Route::get('/getLeverageBrackets', 'SettingController@getLeverageBrackets'); // Get Leverage Brackets
            Route::get('/getPositionADL', 'SettingController@getPositionADL'); // Get Position ADL
            Route::get('/getTradingRules', 'SettingController@getTradingRules'); // Get Trading Rules
            Route::get('/getCommission', 'SettingController@getCommission'); // User Commission Rate
            Route::get('/getDownloadID', 'SettingController@getDownloadID'); // Get Download Id For Futures Transaction History
            Route::get('/getDownloadLink', 'SettingController@getDownloadLink'); // Get Download Link
            Route::get('/getFutureAccountBalance', 'WalletController@getFutureAccountBalance'); // getFutureAccountBalance
            Route::get('/getAccountInfo', 'WalletController@getAccountInfo'); // get wallet coins info
            Route::get('/getIncomeHistory', 'WalletController@getIncomeHistory'); // get user income history
        });
    });

});
// public apis binance
Route::group(['namespace' => 'Api\Binance', 'middleware' => ['checkApi']], function () {
    // spot APIs
    Route::get('/getKlines', 'SpotController@getChartData'); // get chart data
    Route::get('/getExchangeInfo', 'SpotController@exchangeInfo'); // get exchange info
    Route::get('/getOrderBook', 'SpotController@orderBook'); // get order book data
    Route::get('/get24Ticker', 'SpotController@get24Ticker'); // 24 ticker price
    Route::get('/getPriceTicker', 'SpotController@getPriceTicker'); // get ticker price
    Route::get('/getMarketTrade', 'SpotController@getMarketTradeHistory'); // get market trade history
    Route::get('/socket', 'SpotController@socket');
    Route::get('/socket-connection', 'SocketController@index');


    
    // future apis 
    Route::group(['prefix' => 'future'], function () {
        Route::get('/get24Ticker', 'FutureController@get24Ticker'); // 24 ticker price
        Route::get('/getPriceTicker', 'FutureController@getPriceTicker'); // get ticker price
        Route::get('/getOrderBook', 'FutureController@orderBook'); // get order book data
        Route::get('/getMarketTrade', 'FutureController@getMarketTradeHistory'); // get market trade history
        Route::get('/getKlines', 'FutureController@getChartData'); // get chart data
        Route::get('/getIndexPriceKlines', 'FutureController@getIndexPriceChartData'); // get index price chart data
        Route::get('/getMarkPriceKlines', 'FutureController@getMarkChartData'); // get mark chart data
        Route::get('/getKlines', 'FutureController@getChartData'); // get chart data
        Route::get('/getExchangeInfo', 'FutureController@exchangeInfo'); // get exchange info
        Route::get('/pairPremiumIndex', 'FutureController@pairPremiumIndex'); // pair premium index
    });
});

Route::post('/coin-payment-notifier', 'Api\WalletNotifier@coinPaymentNotifier')->name('coinPaymentNotifier');
Route::post('bitgo-wallet-webhook', 'Api\WalletNotifier@bitgoWalletWebhook')->name('bitgoWalletWebhook');

Route::group(['namespace' => 'Api', 'middleware' => 'wallet_notify'], function () {
    Route::post('wallet-notifier', 'WalletNotifier@walletNotify');
    Route::post('wallet-notifier-confirm', 'WalletNotifier@notifyConfirm');
});
// For Two factor
Route::group(['namespace' => 'Api', 'middleware' => ['api-user', 'checkApi']], function () {
    Route::get('two-factor-list', 'AuthController@twoFactorList')->name("twoFactorListApi");
    Route::match(['GET', 'POST'], '/google-two-factor', 'AuthController@twoFactorGoogleSetup')->name("twoFactorGoogleApi");
    Route::post('save-two-factor', 'AuthController@twoFactorSave')->name("twoFactorSaveApi");
    Route::post('send-two-factor', 'AuthController@twoFactorSend')->name("twoFactorSendApi");
    Route::post('check-two-factor', 'AuthController@twoFactorCheck')->name("twoFactorCheckApi");
});


Route::group(['middleware' => 'maintenanceMode'], function () {

    Route::group(['namespace' => 'Api\Public', 'prefix' => 'v1/markets'], function () {
        Route::get('price/{pair?}', 'PublicController@getExchangePrice')->name('getExchangeTrade');
        Route::get('orderBook/{pair}', 'PublicController@getExchangeOrderBook')->name('getExchangeOrderBook');
        Route::get('trade/{pair}', 'PublicController@getExchangeTrade')->name('getExchangeTrade');
        Route::get('chart/{pair}', 'PublicController@getExchangeChart')->name('getExchangeChart');
    });

    Route::group(['middleware' => ['checkApi']], function () {
        Route::group(['namespace' => 'Api', 'middleware' => []], function () {
            // favourite 
            Route::post('add-or-remove-pair-favourite', 'FavouriteController@storeOrRemove');
            // auth
            Route::get('common-settings', 'LandingController@commonSettings');
            Route::post('update-phone', 'AuthController@updatePhone');
            Route::post('sign-up', 'AuthController@signUp');
            Route::post('google-auth', 'AuthController@googleAuth');
            Route::post('sign-in', 'AuthController@signIn');
            Route::post('verify-email', 'AuthController@verifyEmail');
            Route::post('resend-verify-email-code', 'AuthController@resendVerifyEmailCode');
            Route::post('send-phone-otp', 'AuthController@sendPhoneOtp');
            Route::post('verify-email-and-phone', 'AuthController@verifyEmailAndPhone');
            Route::post('forgot-password', 'AuthController@forgotPassword');
            Route::post('reset-password', 'AuthController@resetPassword');
            Route::post('g2f-verify', 'AuthController@g2fVerify');
            Route::get('landing', 'LandingController@index');
            Route::get('banner-list/{id?}', 'LandingController@bannerList');
            Route::get('announcement-list/{id?}', 'LandingController@announcementList');
            Route::get('feature-list/{id?}', 'LandingController@featureList');
            Route::get('social-media-list/{id?}', 'LandingController@socialMediaList');
            Route::get('recaptcha-settings', 'LandingController@reCaptchaSettings');
            Route::get('custom-pages/{type?}', 'LandingController@getCustomPageList');
            Route::get('pages-details/{slug}', 'LandingController@getCustomPageDetails');

            Route::get('faq-list', 'FaqController@faqList');

        });
        Route::group(['namespace' => 'Api\User', 'middleware' => []], function () {
            Route::get('get-exchange-all-orders-app', 'ExchangeController@getExchangeAllOrdersApp')->name('getExchangeAllOrdersApp');
            Route::get('app-get-pair', 'ExchangeController@appExchangeGetAllPair')->name('appExchangeGetAllPair');
            Route::get('app-dashboard/{pair?}', 'ExchangeController@appExchangeDashboard')->name('appExchangeDashboard');
            Route::get('get-exchange-market-trades-app', 'ExchangeController@getExchangeMarketTradesApp')->name('getExchangeMarketTradesApp');
            Route::get('get-exchange-chart-data-app', 'ExchangeController@getExchangeChartDataApp')->name('getExchangeChartDataApp');

        });

        Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']], function () {
            //Chat
            Route::post('add-user-to-chat', 'FriendshipController@store');
            Route::get('get-all-users', 'FriendshipController@getAllUsers');
            Route::get('get-all-chat-list', 'FriendshipController@index');
            Route::get('get-single-chat', 'FriendshipController@getSingleChat');
            Route::post('chat', 'FriendshipController@sendChat');
            //logout
            Route::post('log-out-app', 'AuthController@logOutApp')->name('logOutApp');
        });

        Route::group(['namespace' => 'Api\User', 'middleware' => ['auth:api', 'api-user', 'last_seen']], function () {
            // profile
            Route::get('profile', 'ProfileController@profile');
            Route::get('notifications', 'ProfileController@userNotification');
            Route::post('notification-seen', 'ProfileController@userNotificationSeen');
            Route::get('activity-list', 'ProfileController@activityList');
            Route::post('update-profile', 'ProfileController@updateProfile');
            Route::post('change-password', 'ProfileController@changePassword');

            // kyc
            Route::post('send-phone-verification-sms', 'ProfileController@sendPhoneVerificationSms');
            Route::post('phone-verify', 'ProfileController@phoneVerifyProcess');
            Route::post('upload-nid', 'ProfileController@uploadNid');
            Route::post('upload-passport', 'ProfileController@uploadPassport');
            Route::post('upload-driving-licence', 'ProfileController@uploadDrivingLicence');
            Route::post('upload-voter-card', 'ProfileController@uploadVoterCard');
            Route::get('kyc-details', 'ProfileController@kycDetails');
            Route::get('user-setting', 'ProfileController@userSetting');
            Route::get('language-list', 'ProfileController@languageList');
            Route::post('language-setup', 'ProfileController@languageSetup');
            Route::post('update-currency', 'ProfileController@updateFiatCurrency');
            Route::get('kyc-active-list', 'KycController@kycActiveList');

            Route::group(['middleware' => 'check_demo'], function () {
                Route::post('google2fa-setup', 'ProfileController@google2faSetup');
                Route::get('setup-google2fa-login', 'ProfileController@setupGoogle2faLogin');
            });


            // coin
            Route::get('get-coin-list', 'CoinController@getCoinList');
            Route::get('get-coin-pair-list', 'CoinController@getCoinPairList');

            // wallet
            Route::get('wallet-list', 'WalletController@walletList');
            Route::get('wallet-deposit-{id}', 'WalletController@walletDeposit');
            Route::get('wallet-withdrawal-{id}', 'WalletController@walletWithdrawal');
            Route::post('wallet-withdrawal-process', 'WalletController@walletWithdrawalProcess')->middleware('kycVerification:kyc_withdrawal_setting_status');
            Route::post('get-wallet-network-address', 'WalletController@getWalletNetworkAddress');

            //Dashboard and reports
            Route::get('get-all-buy-orders-app', 'ExchangeController@getExchangeAllBuyOrdersApp')->name('getExchangeAllBuyOrdersApp');
            Route::get('get-all-sell-orders-app', 'ExchangeController@getExchangeAllSellOrdersApp')->name('getExchangeAllSellOrdersApp');

            Route::get('get-my-all-orders-app', 'ExchangeController@getMyExchangeOrdersApp')->name('getMyExchangeOrdersApp');
            Route::get('get-my-trades-app', 'ExchangeController@getMyExchangeTradesApp')->name('getMyExchangeTradesApp');
            Route::post('cancel-open-order-app', 'ExchangeController@deleteMyOrderApp')->name('deleteMyOrderApp');
            Route::get('all-buy-orders-history-app', 'ReportController@getAllOrdersHistoryBuyApp')->name('getAllOrdersHistoryBuyApp');
            Route::get('all-sell-orders-history-app', 'ReportController@getAllOrdersHistorySellApp')->name('getAllOrdersHistorySellApp');
            Route::get('all-transaction-history-app', 'ReportController@getAllTransactionHistoryApp')->name('getAllTransactionHistoryApp');

            Route::get('wallet-history-app', 'WalletController@walletHistoryApp')->name('walletHistoryApp');
            Route::group(['middleware' => ['checkSwap']], function () {
                Route::get('swap-coin-details-app', 'WalletController@getCoinSwapDetailsApp')->name('getCoinSwapDetailsApp');
                Route::get('get-rate-app', 'WalletController@getRateApp')->name('getRateApp');
                Route::get('coin-swap-app', 'WalletController@coinSwapApp')->name('coinSwapApp');
                Route::post('swap-coin-app', 'WalletController@swapCoinApp')->name('swapCoinApp');
                Route::get('coin-convert-history-app', 'WalletController@coinSwapHistoryApp')->name('coinSwapHistoryApp');
            });

            Route::get('referral-app', 'ProfileController@myReferralApp')->name('myReferralApp');

            Route::post('buy-limit-app', "BuyOrderController@placeBuyLimitOrderApp")->name('placeBuyLimitOrderApp')->middleware('kycVerification:kyc_trade_setting_status');
            Route::post('buy-market-app', "BuyOrderController@placeBuyMarketOrderApp")->name('placeBuyMarketOrderApp')->middleware('kycVerification:kyc_trade_setting_status');;
            Route::post('buy-stop-limit-app', "BuyOrderController@placeBuyStopLimitOrderApp")->name('placeBuyStopLimitOrderApp')->middleware('kycVerification:kyc_trade_setting_status');;
            Route::post('sell-limit-app', "SellOrderController@placeSellLimitOrderApp")->name('placeSellLimitOrderApp')->middleware('kycVerification:kyc_trade_setting_status');;
            Route::post('sell-market-app', "SellOrderController@placeSellMarketOrderApp")->name('placeSellMarketOrderApp')->middleware('kycVerification:kyc_trade_setting_status');;
            Route::post('sell-stop-limit-app', "SellOrderController@placeStopLimitSellOrderApp")->name('placeStopLimitSellOrderApp')->middleware('kycVerification:kyc_trade_setting_status');;

            Route::group(['middleware' => ['checkCurrencyDeposit']], function () {
                Route::get('deposit-bank-details/{id}', 'DepositController@depositBankDetails')->name('depositBankDetails');
                Route::get('currency-deposit', 'DepositController@currencyDepositInfo')->name('currencyDepositInfo');
                Route::post('get-currency-deposit-rate', 'DepositController@currencyDepositRate')->name('currencyDepositRate');
                Route::post('currency-deposit-process', 'DepositController@currencyDepositProcess')->name('currencyDepositProcess');
                Route::get('currency-deposit-history', 'DepositController@currencyDepositHistory')->name('currencyDepositHistory');
            });

            // fiat withdrawal
            Route::get('fiat-withdrawal', 'FiatWithdrawalController@fiatWithdrawal')->name('fiatWithdrawal');
            Route::post('get-fiat-withdrawal-rate', 'FiatWithdrawalController@getFiatWithdrawalRate')->name('getFiatWithdrawalRate');
            Route::post('fiat-withdrawal-process', 'FiatWithdrawalController@fiatWithdrawalProcess')->name('fiatWithdrawalProcess');
            Route::get('fiat-withdrawal-history', 'FiatWithdrawalController@fiatWithdrawHistory')->name('fiatWithdrawHistory');

            // User Bank
            Route::get('user-bank-list', 'UserBankController@UserbankGet')->name("UserbankGet");
            Route::post('user-bank-save', 'UserBankController@UserBankSave')->name("UserBankSave");
            Route::post('user-bank-delete', 'UserBankController@UserBankDelete')->name("UserBankDelete");


        });
    });
});

