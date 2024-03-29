<div class="sidebar">
    <!-- logo -->
    <div class="logo">
        <a href="{{route('adminDashboard')}}">
            <img src="{{ image("logo.png") }}" class="img-fluid" alt="">
{{--            <img src="{{show_image(Auth::user()->id,'logo')}}" class="img-fluid" alt="">--}}
        </a>
    </div><!-- /logo -->

    <!-- sidebar menu -->
    <div class="sidebar-menu">
        <nav>
            <ul id="metismenu">


{!! mainMenuRenderer('adminDashboard',__('Dashboard'),$menu ?? '','dashboard','dashboard.svg') !!}

{!! subMenuRenderer(__('User Management'),$menu ?? '', 'users','user.svg',[
    ['route' => 'adminUsers', 'title' => __('User'),'tab' => $sub_menu ?? '', 'tab_compare' => 'user', 'route_param' => NULL ],
    ['route' => 'adminUserIdVerificationPending', 'title' => __('Kyc Verification'),'tab' => $sub_menu ?? '', 'tab_compare' => 'pending_id', 'route_param' => NULL ],
]) !!}

{{-- {!! subMenuRenderer(__('Coin'),$menu ?? '', 'coin','coin.svg',[
    ['route' => 'adminCoinList', 'title' => __('Coin List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'coin_list', 'route_param' => NULL ],
    ['route' => 'coinPairs', 'title' => __('Coin Pairs'),'tab' => $sub_menu ?? '', 'tab_compare' => 'coin_pair', 'route_param' => NULL ],
]) !!} --}}

{!! subMenuRenderer(__('Admin and Role'),$menu ?? '', 'role','coin.svg',[
    ['route' => 'adminList', 'title' => __('Admin'),'tab' => $sub_menu ?? '', 'tab_compare' => 'admin_list', 'route_param' => NULL ],
    ['route' => 'adminRoleList', 'title' => __('Role'),'tab' => $sub_menu ?? '', 'tab_compare' => 'admin_role_list', 'route_param' => NULL ],
]) !!}

{!! subMenuRenderer(__('User Wallet'),$menu ?? '', 'wallet','wallet.svg',[
    ['route' => 'adminWalletList', 'title' => __('Wallet List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'personal', 'route_param' => NULL ]
    {{-- ['route' => 'adminSendWallet', 'title' => __('Send Wallet Coin'),'tab' => $sub_menu ?? '', 'tab_compare' => 'send_wallet', 'route_param' => NULL ],
    ['route' => 'adminWalletSendList', 'title' => __('Send Coin History'),'tab' => $sub_menu ?? '', 'tab_compare' => 'send_coin_list', 'route_param' => NULL ],
    ['route' => 'adminSwapCoinHistory', 'title' => __('Swap Coin History'),'tab' => $sub_menu ?? '', 'tab_compare' => 'swap_coin_history', 'route_param' => NULL ] --}}
]) !!}

{{-- {!! subMenuRenderer(__('Deposit/Withdrawal'),$menu ?? '', 'transaction','Transaction-1.svg',[
    ['route' => 'adminTransactionHistory', 'title' => __('All Transaction'),'tab' => $sub_menu ?? '', 'tab_compare' => 'transaction_all', 'route_param' => NULL ],
    ['route' => 'adminPendingWithdrawal', 'title' => __('Pending Withdrawal'),'tab' => $sub_menu ?? '', 'tab_compare' => 'transaction_withdrawal', 'route_param' => NULL ],
    ['route' => 'adminPendingDeposit', 'title' => __('Pending Deposit'),'tab' => $sub_menu ?? '', 'tab_compare' => 'transaction_deposit', 'route_param' => NULL ],
    ['route' => 'adminCheckDeposit', 'title' => __('Check Deposit'),'tab' => $sub_menu ?? '', 'tab_compare' => 'check_deposit', 'route_param' => NULL ],
]) !!} --}}

{!! subMenuRenderer(__('Addons'),$menu ?? '', 'addons','Transaction-1.svg',[
    ['route' => 'addonsLists', 'title' => __('Addons Lists'),'tab' => $sub_menu ?? '', 'tab_compare' => 'addons_list', 'route_param' => NULL ],
    ['route' => 'addonsSettings', 'title' => __('Addons Settings'),'tab' => $sub_menu ?? '', 'tab_compare' => 'addons_settings', 'route_param' => NULL ],
]) !!}

{!! mainMenuRenderer('adminProfile',__('Profile'),$menu ?? '','profile','profile.svg') !!}

{!! subMenuRenderer(__('Trade Reports'),$menu ?? '', 'trade','trade-report.svg',[
    ['route' => 'adminAllOrdersHistoryBuy', 'title' => __('Buy Order History'),'tab' => $sub_menu ?? '', 'tab_compare' => 'buy_order', 'route_param' => NULL ],
    ['route' => 'adminAllOrdersHistorySell', 'title' => __('Sell Order History'),'tab' => $sub_menu ?? '', 'tab_compare' => 'sell_order', 'route_param' => NULL ],
    ['route' => 'adminAllOrdersHistoryStopLimit', 'title' => __('Stop Limit Order History'),'tab' => $sub_menu ?? '', 'tab_compare' => 'stop_limit', 'route_param' => NULL ],
    ['route' => 'adminAllTransactionHistory', 'title' => __('Transaction History'),'tab' => $sub_menu ?? '', 'tab_compare' => 'transaction', 'route_param' => NULL ],
]) !!}

{!! subMenuRenderer(__('Fiat Deposit'),$menu ?? '', 'currency_deposit','coin.svg',[
    ['route' => 'currencyDepositList', 'title' => __('Pending Request'),'tab' => $sub_menu ?? '', 'tab_compare' => 'pending_deposite_list', 'route_param' => NULL ],
    ['route' => 'bankList', 'title' => __('Bank List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'bank_list', 'route_param' => NULL ],
    ['route' => 'currencyPaymentMethod', 'title' => __('Payment Method'),'tab' => $sub_menu ?? '', 'tab_compare' => 'payment_method_list', 'route_param' => NULL ],
]) !!}

{!! subMenuRenderer(__('Fiat Withdraw'),$menu ?? '', 'fiat_withdraw','coin.svg',[
    ['route' => 'fiatWithdrawList', 'title' => __('Pending Request'),'tab' => $sub_menu ?? '', 'tab_compare' => 'fiat_withdraw_list', 'route_param' => NULL ],
    ['route' => 'adminFiatCurrencyList', 'title' => __('Withdrawal Currency'),'tab' => $sub_menu ?? '', 'tab_compare' => 'currency_list', 'route_param' => NULL ],
]) !!}

{{-- {!! subMenuRenderer(__('Admin Token'),$menu ?? '', 'deposit','deposit.svg',[
    ['route' => 'adminPendingDepositHistory', 'title' => __('Pending Token Report'),'tab' => $sub_menu ?? '', 'tab_compare' => 'pending', 'route_param' => NULL ],
    ['route' => 'adminGasSendHistory', 'title' => __('Gas Sent Report'),'tab' => $sub_menu ?? '', 'tab_compare' => 'gas', 'route_param' => NULL ],
    ['route' => 'adminTokenReceiveHistory', 'title' => __('Token Received Report'),'tab' => $sub_menu ?? '', 'tab_compare' => 'token', 'route_param' => NULL ],
]) !!} --}}

                {{--TODO:: Turn off Setting Option--}}
{!! subMenuRenderer(__('Settings'),$menu ?? '', 'setting','settings.svg',[
    ['route' => 'adminSettings', 'title' => __('General'),'tab' => $sub_menu ?? '', 'tab_compare' => 'general', 'route_param' => NULL ],
    ['route' => 'adminFeatureSettings', 'title' => __('Features'),'tab' => $sub_menu ?? '', 'tab_compare' => 'feature_settings', 'route_param' => NULL ],
    ['route' => 'themesSettingsPage', 'title' => __('Theme Setting'),'tab' => $sub_menu ?? '', 'tab_compare' => 'theme_setting', 'route_param' => NULL ],
    ['route' => 'adminCoinApiSettings', 'title' => __('Api'),'tab' => $sub_menu ?? '', 'tab_compare' => 'api_settings', 'route_param' => NULL ],
    ['route' => 'kycList', 'title' => __('KYC Settings'),'tab' => $sub_menu ?? '', 'tab_compare' => 'kyc_settings', 'route_param' => NULL ],
    ['route' => 'googleAnalyticsAdd', 'title' => __('Google Analytics'),'tab' => $sub_menu ?? '', 'tab_compare' => 'google_analytics', 'route_param' => NULL ],
    ['route' => 'adminLanguageList', 'title' => __('Language List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'lang_list', 'route_param' => NULL ],
    ['route' => 'countryList', 'title' => __('Country List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'country_list', 'route_param' => NULL ],
    ['route' => 'twoFactor', 'title' => __('Two Factor Settings'),'tab' => $sub_menu ?? '', 'tab_compare' => 'two_factor', 'route_param' => NULL ],
    ['route' => 'adminCurrencyList', 'title' => __('Fiat Currency'),'tab' => $sub_menu ?? '', 'tab_compare' => 'currency_list', 'route_param' => NULL ],
    ['route' => 'tradeFeesSettings', 'title' => __('Trade Fees'),'tab' => $sub_menu ?? '', 'tab_compare' => 'trade_fees_settings', 'route_param' => NULL ],
    ['route' => 'seoManagerAdd', 'title' => __('SEO Manager'),'tab' => $sub_menu ?? '', 'tab_compare' => 'seo_manager', 'route_param' => NULL ],
    ['route' => 'adminConfiguration', 'title' => __('Configuration'),'tab' => $sub_menu ?? '', 'tab_compare' => 'config', 'route_param' => NULL ],
]) !!}

                {{--TODO:: Turn off Landing Setting Option--}}
{!! subMenuRenderer(__('Landing Settings'),$menu ?? '', 'landing_setting','landing-settings.svg',[
//    ['route' => 'adminLandingSetting', 'title' => __('Landing Page'),'tab' => $sub_menu ?? '', 'tab_compare' => 'landing', 'route_param' => NULL ],
    ['route' => 'adminCustomPageList', 'title' => __('Custom Pages'),'tab' => $sub_menu ?? '', 'tab_compare' => 'custom_pages', 'route_param' => NULL ],
//    ['route' => 'adminBannerList', 'title' => __('Banner'),'tab' => $sub_menu ?? '', 'tab_compare' => 'banner', 'route_param' => NULL ],
//    ['route' => 'adminFeatureList', 'title' => __('Feature'),'tab' => $sub_menu ?? '', 'tab_compare' => 'feature', 'route_param' => NULL ],
//    ['route' => 'adminSocialMediaList', 'title' => __('Social Media'),'tab' => $sub_menu ?? '', 'tab_compare' => 'media', 'route_param' => NULL ],
//    ['route' => 'adminAnnouncementList', 'title' => __('Announcement'),'tab' => $sub_menu ?? '', 'tab_compare' => 'announcement', 'route_param' => NULL ],
]) !!}


{!! subMenuRenderer(__('Notification'),$menu ?? '', 'notification','Notification.svg',[
    ['route' => 'sendNotification', 'title' => __('Notification'),'tab' => $sub_menu ?? '', 'tab_compare' => 'notify', 'route_param' => NULL ],
    ['route' => 'sendEmail', 'title' => __('Bulk Email'),'tab' => $sub_menu ?? '', 'tab_compare' => 'email', 'route_param' => NULL ],
]) !!}

{!! mainMenuRenderer('adminFaqList',__('FAQs'),$menu ?? '','faq','FAQ.svg') !!}

{!! subMenuRenderer(__('Progress Status'),$menu ?? '', 'progress-status','progress-status.svg',[
    ['route' => 'progressStatusList', 'title' => __('Progress Status List'),'tab' => $sub_menu ?? '', 'tab_compare' => 'progress-status-list', 'route_param' => NULL ],
    ['route' => 'progressStatusSettings', 'title' => __('Progress Status Settings'),'tab' => $sub_menu ?? '', 'tab_compare' => 'progress-status-settings', 'route_param' => NULL ],
]) !!}

{{--{!! mainMenuRenderer('adminLogs',__('Logs'),$menu ?? '','log','logs.svg') !!}--}}


            </ul>
        </nav>
    </div><!-- /sidebar menu -->

</div>
