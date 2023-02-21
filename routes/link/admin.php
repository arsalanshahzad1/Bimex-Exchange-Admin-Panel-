<?php

//Chat
Route::group(['prefix' => 'admin', 'namespace' => 'Api', 'middleware' => ['auth', 'admin', 'permission', 'default_lang']], function () {
    // chat
    Route::post('add-user-to-chat','FriendshipController@store');
    Route::get('get-all-users','FriendshipController@getAllUsers');
    Route::get('get-all-chat-list','FriendshipController@index');
    Route::get('get-single-chat','FriendshipController@getSingleChat');
    Route::post('chat','FriendshipController@sendChat');
    Route::get('testSignals','FriendshipController@testSignals');

});

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth', 'admin', 'permission', 'default_lang']], function () {

    // Logs
    Route::group(['group' => 'log'], function () {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('adminLogs')->per('log');
    });

    Route::group(['group' => 'dashboard'], function () {
        Route::get('dashboard', 'DashboardController@adminDashboard')->name('adminDashboard');
        Route::get('pending-withdrawals', 'TransactionController@adminPendingWithdrawal')->name('adminPendingWithdrawals');
    });

    Route::get('earning-report', 'DashboardController@adminEarningReport')->name('adminEarningReport');

    // user management
    Route::group(['group' => 'user'], function () {
        Route::get('users', 'UserController@adminUsers')->name('adminUsers');
        Route::get('user-profile', 'UserController@adminUserProfile')->name('adminUserProfile');
        Route::get('user-add', 'UserController@UserAddEdit')->name('admin.UserAddEdit');
        Route::get('user-edit', 'UserController@UserEdit')->name('admin.UserEdit');
        Route::get('user-delete-{id}', 'UserController@adminUserDelete')->name('admin.user.delete');
        Route::get('user-force-delete-{id}', 'UserController@adminUserForceDelete')->name('adminUserForceDelete');
        Route::get('user-suspend-{id}', 'UserController@adminUserSuspend')->name('admin.user.suspend');
        Route::get('user-active-{id}', 'UserController@adminUserActive')->name('admin.user.active');
        Route::get('user-remove-gauth-set-{id}', 'UserController@adminUserRemoveGauth')->name('admin.user.remove.gauth');
        Route::get('user-email-verify-{id}', 'UserController@adminUserEmailVerified')->name('admin.user.email.verify');
        Route::get('user-phone-verify-{id}', 'UserController@adminUserPhoneVerified')->name('admin.user.phone.verify');
        Route::get('deleted-users', 'UserController@adminDeletedUser')->name('adminDeletedUser');
    });

    Route::group(['group' => 'profile'], function () {
        Route::get('profile', 'DashboardController@adminProfile')->name('adminProfile');
    });
    Route::group(['middleware'=>'check_demo','group' => 'profile'], function() {
        Route::post('user-profile-update', 'DashboardController@UserProfileUpdate')->name('UserProfileUpdate');
        Route::post('upload-profile-image', 'DashboardController@uploadProfileImage')->name('uploadProfileImage');
        Route::post("google-two-factor-enable","DashboardController@g2fa_enable")->name("SaveTwoFactorAdmin");
        Route::post('update-two-factor',"DashboardController@updateTwoFactor")->name("UpdateTwoFactor");
    });

    // ID Varification
    Route::group(['group' => 'pending_id'], function (){
        Route::get('verification-details-{id}', 'UserController@VerificationDetails')->name('adminUserDetails');
        Route::get('pending-id-verified-user', 'UserController@adminUserIdVerificationPending')->name('adminUserIdVerificationPending');
        Route::get('verification-active-{id}-{type}', 'UserController@adminUserVerificationActive')->name('adminUserVerificationActive');
        Route::get('verification-reject', 'UserController@varificationReject')->name('varificationReject');
    });

    // coin
    Route::group(['group' => 'coin_list'], function(){
        Route::get('total-user-coin', 'CoinController@adminUserCoinList')->name('adminUserCoinList');
        Route::get('coin-list', 'CoinController@adminCoinList')->name('adminCoinList');
        Route::get('add-new-coin', 'CoinController@adminAddCoin')->name('adminAddCoin');
        Route::get('coin-edit/{id}', 'CoinController@adminCoinEdit')->name('adminCoinEdit');
        Route::get('coin-settings/{id}', 'CoinController@adminCoinSettings')->name('adminCoinSettings');
    });
    Route::group(['middleware'=>'check_demo','group'=>'coin_list'], function() {
        Route::get('coin-delete/{id}', 'CoinController@adminCoinDelete')->name('adminCoinDelete');
        Route::get('change-coin-rate', 'CoinController@adminCoinRate')->name('adminCoinRate');
        Route::get('adjust-bitgo-wallet/{id}', 'CoinController@adminAdjustBitgoWallet')->name('adminAdjustBitgoWallet');
        Route::post('save-new-coin', 'CoinController@adminSaveCoin')->name('adminSaveCoin');
        Route::post('save-coin-settings', 'CoinController@adminSaveCoinSetting')->name('adminSaveCoinSetting');
        Route::post('coin-save-process', 'CoinController@adminCoinSaveProcess')->name('adminCoinSaveProcess');
        Route::post('change-coin-status', 'CoinController@adminCoinStatus')->name('adminCoinStatus');
    });

    // Wallet management
    Route::group(['group' => 'personal'], function () {
        Route::get('wallet-list', 'WalletController@adminWalletList')->name('adminWalletList');
        Route::get('my-wallet-list', 'WalletController@myWalletList')->name('myWalletList');
    });
    Route::group(['group' => 'send_wallet'], function () {
        Route::get('send-wallet-balance', 'WalletController@adminSendWallet')->name('adminSendWallet');
    });
    Route::group(['group' => 'send_wallet'], function () {
        Route::get('send-coin-list', 'WalletController@adminWalletSendList')->name('adminWalletSendList');
    });
    Route::group(['group' => 'swap_coin_history'], function () {
        Route::get('swap-coin-history', 'WalletController@adminSwapCoinHistory')->name('adminSwapCoinHistory');
    });

    Route::group(['middleware'=>'check_demo','group' => 'send_wallet'], function() {
        Route::post('admin-send-balance-process', 'WalletController@adminSendBalanceProcess')->name('adminSendBalanceProcess');
        Route::get('admin-send-balance-delete-{id}', 'WalletController@adminSendBalanceDelete')->name('adminSendBalanceDelete');
    });

    // deposit withdrawal
    Route::group(['group' => 'transaction_all'], function () {
        Route::get('transaction-history', 'TransactionController@adminTransactionHistory')->name('adminTransactionHistory');
        Route::get('withdrawal-history', 'TransactionController@adminWithdrawalHistory')->name('adminWithdrawalHistory');
    });
    Route::group(['group' => 'transaction_withdrawal'], function () {
        Route::get('pending-withdrawal', 'TransactionController@adminPendingWithdrawal')->name('adminPendingWithdrawal');
        Route::get('rejected-withdrawal', 'TransactionController@adminRejectedWithdrawal')->name('adminRejectedWithdrawal');
        Route::get('active-withdrawal', 'TransactionController@adminActiveWithdrawal')->name('adminActiveWithdrawal');
        Route::get('reject-pending-withdrawal-{id}', 'TransactionController@adminRejectPendingWithdrawal')->name('adminRejectPendingWithdrawal');
        Route::get('accept-pending-deposit-{id}', 'TransactionController@adminPendingDepositAcceptProcess')->name('adminPendingDepositAcceptProcess');
    });
    Route::group(['group' => 'transaction_deposit'], function () {
        Route::get('pending-deposit', 'TransactionController@adminPendingDeposit')->name('adminPendingDeposit');
    });

    Route::group(['middleware'=>'check_demo','group' => 'transaction_deposit'], function() {
        Route::get('accept-pending-withdrawal-{id}', 'TransactionController@adminAcceptPendingWithdrawal')->name('adminAcceptPendingWithdrawal');
        Route::get('pending-withdrawal-accept-process', 'TransactionController@adminPendingWithdrawalAcceptProcess')->name('adminPendingWithdrawalAcceptProcess');
    });

    Route::group(['group' => 'check_deposit'], function () {
        Route::get('check-deposit','DepositController@adminCheckDeposit')->name('adminCheckDeposit');
        Route::get('submit-check-deposit', 'DepositController@submitCheckDeposit')->name('submitCheckDeposit');
    });
    // pending deposit report and action
    Route::group(['group' => 'pending'], function () {
        Route::get('pending-token-deposit-history', 'DepositController@adminPendingDepositHistory')->name('adminPendingDepositHistory');
        Route::get('pending-token-deposit-accept-{id}', 'DepositController@adminPendingDepositAccept')->name('adminPendingDepositAccept');
        Route::get('pending-token-deposit-reject-{id}', 'DepositController@adminPendingDepositReject')->name('adminPendingDepositReject');
    });
    Route::group(['group' => 'gas'], function () {
        Route::get('gas-send-history', 'DepositController@adminGasSendHistory')->name('adminGasSendHistory');
    });
    Route::group(['group' => 'token'], function () {
        Route::get('token-receive-history', 'DepositController@adminTokenReceiveHistory')->name('adminTokenReceiveHistory');
    });


    //FAQ
    Route::group(['group' => 'faq'], function () {
        Route::get('faq-list', 'SettingsController@adminFaqList')->name('adminFaqList');
        Route::get('faq-add', 'SettingsController@adminFaqAdd')->name('adminFaqAdd');
        Route::get('faq-type-add', 'SettingsController@adminFaqTypeAdd')->name('adminFaqTypeAdd');
        Route::get('faq-edit-{id}', 'SettingsController@adminFaqEdit')->name('adminFaqEdit');
        Route::get('faq-delete-{id}', 'SettingsController@adminFaqDelete')->name('adminFaqDelete');
        Route::get('faq-type-edit-{id}', 'SettingsController@adminFaqTypeEdit')->name('adminFaqTypeEdit');
        Route::get('faq-type-delete-{id}', 'SettingsController@adminFaqTypeDelete')->name('adminFaqTypeDelete');
    });
    Route::group(['middleware'=>'check_demo','group' => 'faq'], function() {
        Route::post('faq-type-save', 'SettingsController@adminFaqTypeSave')->name('adminFaqTypeSave');
        Route::post('faq-save', 'SettingsController@adminFaqSave')->name('adminFaqSave');
    });
    // admin setting

    Route::group(['group' => 'general'], function () {
        Route::get('general-settings', 'SettingsController@adminSettings')->name('adminSettings');
    });
    Route::group(['middleware' => 'check_demo','group' => 'general'], function () {
        Route::post('admin-save-common-setting', 'SettingsController@adminSettingsSaveCommon')->name('adminSettingsSaveCommon');
        Route::post('common-settings', 'SettingsController@adminCommonSettings')->name('adminCommonSettings');
        Route::post('recaptcha-settings', 'SettingsController@adminCapchaSettings')->name('adminCapchaSettings');
        Route::post('email-save-settings', 'SettingsController@adminSaveEmailSettings')->name('adminSaveEmailSettings');
        Route::post('sms-save-settings', 'SettingsController@adminSaveSmsSettings')->name('adminSaveSmsSettings');
        Route::post('referral-fees-settings', 'SettingsController@adminReferralFeesSettings')->name('adminReferralFeesSettings');
        Route::post('cron-save-settings', 'SettingsController@adminSaveCronSettings')->name('adminSaveCronSettings');
        Route::post('fiat-widthdraw-save-settings', 'SettingsController@adminSaveFiatWithdrawalSettings')->name('adminSaveFiatWithdrawalSettings');
    });


    Route::group(['group' => 'feature_settings'], function () {
        Route::get('admin-feature-settings', 'SettingsController@adminFeatureSettings')->name('adminFeatureSettings');
    });
    Route::group(['middleware' => 'check_demo', 'group' => 'feature_settings'], function () {
        Route::post('admin-cookie-settings-save', 'SettingsController@adminCookieSettingsSave')->name('adminCookieSettingsSave');
    });


    Route::group(['group' => 'api_settings'], function () {
        Route::get('api-settings', 'SettingsController@adminCoinApiSettings')->name('adminCoinApiSettings');
        // Network Fees
        Route::get('network-fees','CoinPaymentNetworkFee@list')->name('networkFees');
    });
    Route::group(['middleware' => 'check_demo', 'group' => 'api_settings'], function () {
        Route::post('save-payment-settings', 'SettingsController@adminSavePaymentSettings')->name('adminSavePaymentSettings');
        Route::post('save-bitgo-settings', 'SettingsController@adminSaveBitgoSettings')->name('adminSaveBitgoSettings');
        Route::post('admin-erc20-api-settings', 'SettingsController@adminSaveERC20ApiSettings')->name('adminSaveERC20ApiSettings');
        Route::post('admin-other-api-settings', 'SettingsController@adminSaveOtherApiSettings')->name('adminSaveOtherApiSettings');
        Route::post('admin-stripe-api-settings', 'SettingsController@adminSaveStripeApiSettings')->name('adminSaveStripeApiSettings');
        Route::get('network-fees-update','CoinPaymentNetworkFee@createOrUpdate')->name('networkFeesUpdate');
    });

    Route::post('order-settings', 'SettingsController@adminOrderSettings')->name('adminOrderSettings');
    Route::get('admin-chat-settings', 'SettingsController@adminChatSettings')->name('adminChatSettings');

    Route::group(['middleware'=>'check_demo'], function() {
        Route::post('withdrawal-settings', 'SettingsController@adminWithdrawalSettings')->name('adminWithdrawalSettings');
        Route::post('node-settings', 'SettingsController@adminNodeSettings')->name('adminNodeSettings');

    });
   // notification
    Route::group(['group' => 'notify'], function () {
        Route::get('send-notification', 'DashboardController@sendNotification')->name('sendNotification');
        Route::post('send-notification-process', 'DashboardController@sendNotificationProcess')->name('sendNotificationProcess');
    });
    Route::group(['group' => 'email'], function () {
        Route::get('send-email', 'DashboardController@sendEmail')->name('sendEmail');
        Route::get('clear-email', 'DashboardController@clearEmailRecord')->name('clearEmailRecord');
    });
    Route::group(['middleware'=>'check_demo','group' => 'email'], function() {
        Route::post('send-email-process', 'DashboardController@sendEmailProcess')->name('sendEmailProcess');
    });

    // custom page
    Route::group(['group' => 'custom_pages'], function () {
        Route::get('custom-page-slug-check', 'LandingController@customPageSlugCheck')->name('customPageSlugCheck');
        Route::get('custom-page-list', 'LandingController@adminCustomPageList')->name('adminCustomPageList');
        Route::get('custom-page-add', 'LandingController@adminCustomPageAdd')->name('adminCustomPageAdd');
        Route::get('custom-page-edit/{id}', 'LandingController@adminCustomPageEdit')->name('adminCustomPageEdit');
        Route::get('custom-page-order', 'LandingController@customPageOrder')->name('customPageOrder');
    });
    Route::group(['middleware'=>'check_demo','group' => 'custom_pages'], function() {
        Route::get('custom-page-delete/{id}', 'LandingController@adminCustomPageDelete')->name('adminCustomPageDelete');
        Route::post('custom-page-save', 'LandingController@adminCustomPageSave')->name('adminCustomPageSave');
    });

    // landing setting
    Route::group(['group' => 'landing'], function () {
        Route::get('landing-page-setting', 'LandingController@adminLandingSetting')->name('adminLandingSetting');
        Route::get('landing-page-download-link-{type}', 'LandingController@adminLandingApiLinkUpdateView')->name('adminLandingApiLinkUpdateView');
        Route::post('landing-api-link-setting-save', 'LandingController@adminLandingApiLinkSave')->name('adminLandingApiLinkSave');
        Route::post('landing-section-setting-save', 'LandingController@adminLandingSectionSettingsSave')->name('adminLandingSectionSettingsSave');
        Route::post('landing-pair-asset-setting-save', 'LandingController@adminLandingPairAssetSave')->name('adminLandingPairAssetSave');
    });
    Route::group(['middleware'=>'check_demo','group' => 'landing'], function() {
        Route::post('landing-page-setting-save', 'LandingController@adminLandingSettingSave')->name('adminLandingSettingSave');
    });

    Route::group(['group' => 'config'], function () {
        Route::get('admin-config', 'ConfigController@adminConfiguration')->name('adminConfiguration');
        Route::get('run-admin-command/{type}', 'ConfigController@adminRunCommand')->name('adminRunCommand');
    });

    // trade
    Route::group(['group' => 'coin_pair'], function(){
        Route::get('trade/coin-pairs', 'TradeSettingController@coinPairs')->name('coinPairs');
        Route::get('trade/coin-pairs-chart-update/{id}', 'TradeSettingController@coinPairsChartUpdate')->name('coinPairsChartUpdate');
        Route::post('trade/change-coin-pair-bot-status', 'TradeSettingController@changeCoinPairBotStatus')->name('changeCoinPairBotStatus');
        Route::get('trade/trade-fees-settings', 'TradeSettingController@tradeFeesSettings')->name('tradeFeesSettings');
        Route::post('trade/save-trade-fees-settings', 'TradeSettingController@tradeFeesSettingSave')->name('tradeFeesSettingSave');
        Route::post('trade/remove-trade-limit', 'TradeSettingController@removeTradeLimit')->name('removeTradeLimit');
    });
    Route::group(['middleware'=>'check_demo'], function() {
        Route::get('trade/coin-pairs-delete/{id}', 'TradeSettingController@coinPairsDelete')->name('coinPairsDelete');
        Route::post('trade/save-coin-pair', 'TradeSettingController@saveCoinPairSettings')->name('saveCoinPairSettings');
        Route::post('trade/change-coin-pair-status', 'TradeSettingController@changeCoinPairStatus')->name('changeCoinPairStatus');
    });


    // trade reports
    Route::group(['middleware'=>'check_demo','group' => 'buy_order'], function() {
        Route::get('all-buy-orders-history', 'ReportController@adminAllOrdersHistoryBuy')->name('adminAllOrdersHistoryBuy');
    });
    Route::group(['middleware' => 'check_demo', 'group' => 'sell_order'], function () {
        Route::get('all-sell-orders-history', 'ReportController@adminAllOrdersHistorySell')->name('adminAllOrdersHistorySell');
    });
    Route::group(['middleware' => 'check_demo', 'group' => 'stop_limit'], function () {
        Route::get('all-stop-limit-orders-history', 'ReportController@adminAllOrdersHistoryStopLimit')->name('adminAllOrdersHistoryStopLimit');
    });
    Route::group(['middleware' => 'check_demo', 'group' => 'transaction'], function () {
        Route::get('all-transaction-history', 'ReportController@adminAllTransactionHistory')->name('adminAllTransactionHistory');
    });

    // landing banner
    Route::group(['group' => 'banner'], function () {
        Route::get('landing-banner-list', 'BannerController@adminBannerList')->name('adminBannerList');
        Route::get('landing-banner-add', 'BannerController@adminBannerAdd')->name('adminBannerAdd');
        Route::get('landing-banner-edit-{id}', 'BannerController@adminBannerEdit')->name('adminBannerEdit');
    });

    Route::group(['middleware'=>'check_demo','group' => 'banner'], function() {
        Route::post('landing-banner-save', 'BannerController@adminBannerSave')->name('adminBannerSave');
        Route::get('landing-banner-delete-{id}', 'BannerController@adminBannerDelete')->name('adminBannerDelete');
    });


    // landing announcement
    Route::group(['group' => 'announcement'], function () {
        Route::get('landing-announcement-list', 'AnnouncementController@adminAnnouncementList')->name('adminAnnouncementList');
        Route::get('landing-announcement-add', 'AnnouncementController@adminAnnouncementAdd')->name('adminAnnouncementAdd');
        Route::get('landing-announcement-edit-{id}', 'AnnouncementController@adminAnnouncementEdit')->name('adminAnnouncementEdit');
    });
    Route::group(['middleware'=>'check_demo','group' => 'announcement'], function() {
        Route::post('landing-announcement-save', 'AnnouncementController@adminAnnouncementSave')->name('adminAnnouncementSave');
        Route::get('landing-announcement-delete-{id}', 'AnnouncementController@adminAnnouncementDelete')->name('adminAnnouncementDelete');
    });



    // landing feature
    Route::group(['group' => 'feature'], function () {
        Route::get('landing-feature-list', 'LandingController@adminFeatureList')->name('adminFeatureList');
        Route::get('landing-feature-add', 'LandingController@adminFeatureAdd')->name('adminFeatureAdd');
        Route::get('landing-feature-edit-{id}', 'LandingController@adminFeatureEdit')->name('adminFeatureEdit');
    });
    Route::group(['middleware'=>'check_demo','group' => 'feature'], function() {
        Route::post('landing-feature-save', 'LandingController@adminFeatureSave')->name('adminFeatureSave');
        Route::get('landing-feature-delete-{id}', 'LandingController@adminFeatureDelete')->name('adminFeatureDelete');
    });



    // landing social media
    Route::group(['group' => 'media'], function () {
        Route::get('landing-social-media-list', 'LandingController@adminSocialMediaList')->name('adminSocialMediaList');
        Route::get('landing-social-media-add', 'LandingController@adminSocialMediaAdd')->name('adminSocialMediaAdd');
        Route::get('landing-social-media-edit-{id}', 'LandingController@adminSocialMediaEdit')->name('adminSocialMediaEdit');
    });
    Route::group(['middleware'=>'check_demo','group' => 'media'], function() {
        Route::post('landing-social-media-save', 'LandingController@adminSocialMediaSave')->name('adminSocialMediaSave');
        Route::get('landing-social-media-delete-{id}', 'LandingController@adminSocialMediaDelete')->name('adminSocialMediaDelete');
    });
    // currency list
    Route::group(['group' => 'currency_list'], function () {
        Route::get('currency-list', 'CurrencyController@adminCurrencyList')->name('adminCurrencyList');
        Route::get('currency-add', 'CurrencyController@adminCurrencyAdd')->name('adminCurrencyAdd');
        Route::get('currency-edit-{id}', 'CurrencyController@adminCurrencyEdit')->name('adminCurrencyEdit');
        Route::get('fiat-currency-list', 'CurrencyController@adminFiatCurrencyList')->name('adminFiatCurrencyList');
    });

    Route::group(['middleware'=>'check_demo','group' => 'currency_list'], function() {
        Route::get('currency-rate-change', 'CurrencyController@adminCurrencyRate')->name('adminCurrencyRate');
        Route::post('currency-save-process', 'CurrencyController@adminCurrencyAddEdit')->name('adminCurrencyStore');
        Route::post('currency-status-change', 'CurrencyController@adminCurrencyStatus')->name('adminCurrencyStatus');
        Route::post('currency-all', 'CurrencyController@adminAllCurrency')->name('adminAllCurrency');
        Route::get('fiat-currency-delete-{id}', 'CurrencyController@adminFiatCurrencyDelete')->name('adminFiatCurrencyDelete');
        Route::post('fiat-currency-save-process', 'CurrencyController@adminFiatCurrencySaveProcess')->name('adminFiatCurrencySaveProcess');
        Route::post('withdrawal-currency-status-change', 'CurrencyController@adminWithdrawalCurrencyStatus')->name('adminWithdrawalCurrencyStatus');

    });

    // landing social media
    Route::group(['group' => 'lang_list'], function () {
        Route::get('lang-list', 'AdminLangController@adminLanguageList')->name('adminLanguageList');
        Route::get('lang-add', 'AdminLangController@adminLanguageAdd')->name('adminLanguageAdd');
        Route::post('lang-save', 'AdminLangController@adminLanguageSave')->name('adminLanguageSave');
        Route::get('lang-edit-{id}', 'AdminLangController@adminLanguageEdit')->name('adminLanguageEdit');
        Route::get('lang-delete-{id}', 'AdminLangController@adminLanguageDelete')->name('adminLanguageDelete');
        Route::post('lang-status-change', 'AdminLangController@adminLangStatus')->name('adminLangStatus');
    });

    //Bank settings
    Route::group(['group' => 'bank_list'], function () {
        Route::get('bank-list', 'BankController@bankList')->name('bankList');
        Route::get('bank-add', 'BankController@bankAdd')->name('bankAdd');
        Route::get('bank-edit-{id}', 'BankController@bankEdit')->name('bankEdit');
    });
    Route::group(['middleware'=>'check_demo','group' => 'bank_list'], function() {
        Route::post('bank-save', 'BankController@bankStore')->name('bankStore');
        Route::post('bank-status-change', 'BankController@bankStatusChange')->name('bankStatusChange');
        Route::get('bank-delete-{id}', 'BankController@bankDelete')->name('bankDelete');
    });

    //currency deposit Payment payment method
    Route::group(['group' => 'payment_method_list'], function () {
        Route::get('currency-payment-method','PaymentMethodController@currencyPaymentMethod')->name('currencyPaymentMethod');
        Route::get('currency-payment-method-add','PaymentMethodController@currencyPaymentMethodAdd')->name('currencyPaymentMethodAdd');
        Route::get('currency-payment-method-edit-{id}','PaymentMethodController@currencyPaymentMethodEdit')->name('currencyPaymentMethodEdit');
    });
    Route::group(['middleware'=>'check_demo','group' => 'payment_method_list'], function() {
        Route::post('currency-payment-method-store','PaymentMethodController@currencyPaymentMethodStore')->name('currencyPaymentMethodStore');
        Route::post('currency-payment-method-status','PaymentMethodController@currencyPaymentMethodStatus')->name('currencyPaymentMethodStatus');
        Route::get('currency-payment-method-delete-{id}','PaymentMethodController@currencyPaymentMethodDelete')->name('currencyPaymentMethodDelete');
    });

    // currency deposit
    Route::group(['group' => 'pending_deposite_list'], function () {
        Route::get('currency-deposit-list','CurrencyDepositController@currencyDepositList')->name('currencyDepositList');
        Route::get('currency-deposit-pending-list','CurrencyDepositController@currencyDepositPendingList')->name('currencyDepositPendingList');
        Route::get('currency-deposit-accept-list','CurrencyDepositController@currencyDepositAcceptList')->name('currencyDepositAcceptList');
        Route::get('currency-deposit-reject-list','CurrencyDepositController@currencyDepositRejectList')->name('currencyDepositRejectList');
        Route::get('currency-deposit-accept-{id}','CurrencyDepositController@currencyDepositAccept')->name('currencyDepositAccept');
        Route::post('currency-deposit-reject','CurrencyDepositController@currencyDepositReject')->name('currencyDepositReject');
    });


    // Fiat Withdraw
    Route::group(['group' => 'fiat_withdraw_list'], function () {
        Route::get('fiat-withdraw-list','FiatWithdrawController@fiatWithdrawList')->name('fiatWithdrawList');
        Route::post('fiat-withdraw-accept','FiatWithdrawController@fiatWithdrawAccept')->name('fiatWithdrawAccept');
        Route::post('fiat-withdraw-reject','FiatWithdrawController@fiatWithdrawReject')->name('fiatWithdrawReject');
        Route::get('fiat-withdraw-pending-list','FiatWithdrawController@fiatWithdrawPendingList')->name('fiatWithdrawPendingList');
        Route::get('fiat-withdraw-reject-list','FiatWithdrawController@fiatWithdrawRejectList')->name('fiatWithdrawRejectList');
        Route::get('fiat-withdraw-active-list','FiatWithdrawController@fiatWithdrawActiveList')->name('fiatWithdrawActiveList');
    });

    //country
    Route::group(['group' => 'country_list'], function () {
        Route::get('country-list','CountryController@countryList')->name('countryList');
        Route::post('country-status-change','CountryController@countryStatusChange')->name('countryStatusChange');
    });

    //kyc settings
    Route::group(['group' => 'kyc_settings'], function () {
        Route::get('kyc-list','KycController@kycList')->name('kycList');
        Route::post('kyc-status-change','KycController@kycStatusChange')->name('kycStatusChange');
        Route::get('kyc-update-image-{id}','KycController@kycUpdateImage')->name('kycUpdateImage');
    });
    Route::group(['middleware'=>'check_demo','group' => 'kyc_settings'], function() {
        Route::post('send_test_mail','SettingsController@testMail')->name('testmailsend');
        Route::post('kyc-withdrawal-setting','KycController@kycWithdrawalSetting')->name('kycWithdrawalSetting');
        Route::post('kyc-trade-setting','KycController@kycTradeSetting')->name('kycTradeSetting');
        Route::post('kyc-store-image','KycController@kycStoreImage')->name('kycStoreImage');
    });

    //Google analytics
    Route::group(['group' => 'google_analytics'], function () {
        Route::get('google-analytics-add','AnalyticsController@googleAnalyticsAdd')->name('googleAnalyticsAdd');
        Route::post('google-analytics-id-store','AnalyticsController@googleAnalyticsIDStore')->name('googleAnalyticsIDStore');
    });

    //SEO manager
    Route::group(['group' => 'seo_manager'], function () {
        Route::get('seo-manager-add','SeoManagerController@seoManagerAdd')->name('seoManagerAdd');
    });
    Route::group(['middleware'=>'check_demo','group' => 'seo_manager'], function() {
        Route::post('seo-manager-update','SeoManagerController@seoManagerUpdate')->name('seoManagerUpdate');
    });

    // Two Factor Setting
    Route::group(['group' => 'two_factor'], function () {
        Route::get("two-factor-settings","TwoFactorController@index")->name("twoFactor");
        Route::post("two-factor-settings","TwoFactorController@saveTwoFactorList")->name("SaveTwoFactor");
        Route::post("two-factor-data","TwoFactorController@saveTwoFactorData")->name("SaveTwoFactorData");
    });

    //Bitgo Webhook
    Route::post('bitgo-webhook-save', 'CoinController@webhookSave')->name('webhookSave');

    Route::group(['group' => 'theme_setting'], function () {
        Route::get('themes-settings', 'ThemeSettingsController@themesSettingsPage')->name('themesSettingsPage');
        Route::get('theme-settings','ThemeSettingsController@addEditThemeSettings')->name('addEditThemeSettings');
        Route::get('reset-theme-color-settings', 'ThemeSettingsController@resetThemeColorSettings')->name('resetThemeColorSettings');
    });
    Route::group(['middleware' => 'check_demo', 'group' => 'theme_setting'], function () {
        Route::post('theme-navebar-settings-save', 'ThemeSettingsController@themeNavebarSettingsSave')->name('themeNavebarSettingsSave');
        Route::post('theme-settings-store','ThemeSettingsController@addEditThemeSettingsStore')->name('addEditThemeSettingsStore');
        Route::post('themes-settings-save', 'ThemeSettingsController@themesSettingSave')->name('themesSettingSave');

    });

    //progress status
    Route::group(['group' => 'progress-status-list'], function () {
        Route::get('progress-status-list', 'ProgressStatusController@progressStatusList')->name('progressStatusList');
        Route::get('progress-status-add', 'ProgressStatusController@progressStatusAdd')->name('progressStatusAdd');
        Route::get('progress-status-edit/{id}', 'ProgressStatusController@progressStatusEdit')->name('progressStatusEdit');
    });
    Route::group(['group' => 'progress-status-settings'], function () {
        Route::get('progress-status-settings', 'ProgressStatusController@progressStatusSettings')->name('progressStatusSettings');
        Route::post('progress-status-settings-update', 'ProgressStatusController@progressStatusSettingsUpdate')->name('progressStatusSettingsUpdate');
    });

    Route::group(['middleware'=>'check_demo','group' => 'progress-status-list'], function() {
        Route::get('progress-status-delete/{id}', 'ProgressStatusController@progressStatusDelete')->name('progressStatusDelete');
        Route::post('progress-status-save', 'ProgressStatusController@progressStatusSave')->name('progressStatusSave');
    });

    Route::group(['group' => 'role'], function () {
        Route::get('admin-list', 'RoleManagmentController@adminList')->name('adminList');
        Route::post('admin', 'RoleManagmentController@addEditAdmin')->name('addEditAdmin');
        Route::get('admin-profile-{id}', 'RoleManagmentController@viewAdminProfile')->name('viewAdminProfile');
        Route::get('admin-edit-{id}', 'RoleManagmentController@editAdminProfile')->name('editAdminProfile');
        Route::get('admin-delete-{id}', 'RoleManagmentController@deleteAdminProfile')->name('deleteAdminProfile');

        Route::get('admin-role-list', 'RoleManagmentController@adminRoleList')->name('adminRoleList');
        Route::post('admin-role', 'RoleManagmentController@adminRoleSave')->name('adminRoleSave');
        Route::get('role-delete-{id}', 'RoleManagmentController@adminRoleDelete')->name('adminRoleDelete');

        Route::post('permission-route','RoleManagmentController@addPermissionRoute')->name('addPermissionRoute');
        Route::post('permission-route-delete-{id}','RoleManagmentController@addPermissionRouteDelete')->name('addPermissionRouteDelete');
        Route::get('permission-route-edit-{id}','RoleManagmentController@addPermissionRouteEdit')->name('addPermissionRouteEdit');
        Route::get('permission-route-reset','RoleManagmentController@addPermissionRouteReset')->name('addPermissionRouteReset');

        Route::get('admin-role-permission-group-list', 'RoleManagmentController@adminRolePermissionGroupList')->name('adminRolePermissionGroupList');
        Route::post('admin-role-permission-save', 'RoleManagmentController@adminRolePermissionSave')->name('adminRolePermissionSave');
    });

    Route::group(['group' => 'addons_settings'], function () {
        Route::get('addons-list','AddonsController@addonsLists')->name('addonsLists');
        Route::get('addons-settings','AddonsController@addonsSettings')->name('addonsSettings');
        Route::post('addons-settings-save','AddonsController@saveAddonsSettings')->name('saveAddonsSettings');
    });



});

Route::group(['middleware'=> ['auth', 'lang']], function () {
    Route::get('/send-sms-for-verification', 'user\ProfileController@sendSMS')->name('sendSMS');
    Route::get('test', 'TestController@index')->name('test');
    Route::group(['middleware'=>'check_demo'], function() {
        Route::post('/user-profile-update', 'user\ProfileController@userProfileUpdate')->name('userProfileUpdate');
        Route::post('/upload-profile-image', 'user\ProfileController@uploadProfileImage')->name('uploadProfileImage');
        Route::post('change-password-save', 'user\ProfileController@changePasswordSave')->name('changePasswordSave');
        Route::post('/phone-verify', 'user\ProfileController@phoneVerify')->name('phoneVerify');
    });
});
