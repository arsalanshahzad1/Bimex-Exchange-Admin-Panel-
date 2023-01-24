{{--OLD DATA--}}
<div class="top-bar">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-1 col-md-2 col-3 top-bar-logo top-bar-logo-hide">
                <div class="logo">
                    <a href="{{route('adminDashboard')}}"><img src="{{ image("logo.jpeg") }}"
                                                               class="img-fluid logo-large" alt=""></a>
                    <a href="{{route('adminDashboard')}}"><img src="{{ image("logo.jpeg")  }}"
                                                               class="img-fluid logo-small" alt=""></a>
                </div>
            </div>
            <div class="col-xl-2 col-md-2 col-3">
                <div class="d-flex ">
                    <div class="menu-bars">
                        <img src="{{asset('assets/admin/images/sidebar-icons/menu.svg')}}" class="img-fluid" alt="">
                    </div>
                    <h4 class="mt-1 ml-2">Dashboard</h4>
                </div>
            </div>

            <div class="col-xl-9 col-md-8 col-6">
                <div class="top-bar-right">
                    <ul>
                        <li class="nav-item">
                            <div class="input-group search-area me-3">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="input-group-text"><a href="javascript:void(0)">
									<svg class="me-3 mb-1 user-search" width="15" height="15" viewBox="0 0 18 18"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
										<path
                                            d="M8.625 16.3125C4.3875 16.3125 0.9375 12.8625 0.9375 8.625C0.9375 4.3875 4.3875 0.9375 8.625 0.9375C12.8625 0.9375 16.3125 4.3875 16.3125 8.625C16.3125 12.8625 12.8625 16.3125 8.625 16.3125ZM8.625 2.0625C5.0025 2.0625 2.0625 5.01 2.0625 8.625C2.0625 12.24 5.0025 15.1875 8.625 15.1875C12.2475 15.1875 15.1875 12.24 15.1875 8.625C15.1875 5.01 12.2475 2.0625 8.625 2.0625Z"
                                            fill="#2696FD"></path>
										<path
                                            d="M16.5001 17.0626C16.3576 17.0626 16.2151 17.0101 16.1026 16.8976L14.6026 15.3976C14.3851 15.1801 14.3851 14.8201 14.6026 14.6026C14.8201 14.3851 15.1801 14.3851 15.3976 14.6026L16.8976 16.1026C17.1151 16.3201 17.1151 16.6801 16.8976 16.8976C16.7851 17.0101 16.6426 17.0626 16.5001 17.0626Z"
                                            fill="var(--primary)"></path>
									</svg>
									</a></span>
                            </div>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link " href="javascript:void(0);" data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                    <path
                                        d="m9.075 22.2-.4-3.25q-.3-.125-.538-.275-.237-.15-.487-.325l-3.025 1.3-2.95-5.075 2.625-2v-1.15l-2.625-2 2.95-5.05 3.05 1.275q.225-.175.475-.325.25-.15.525-.25l.4-3.275h5.85l.4 3.275q.3.1.538.25.237.15.487.325l3.025-1.275 2.95 5.05-2.65 2q.025.15.025.287v.575q0 .138-.05.288l2.65 2-2.95 5.075-3.025-1.3q-.225.175-.475.325-.25.15-.525.275l-.4 3.25Zm2.95-6.7q1.45 0 2.475-1.025Q15.525 13.45 15.525 12q0-1.45-1.025-2.475Q13.475 8.5 12.025 8.5q-1.45 0-2.475 1.025Q8.525 10.55 8.525 12q0 1.45 1.025 2.475 1.025 1.025 2.475 1.025Zm0-2q-.625 0-1.062-.438-.438-.437-.438-1.062t.438-1.062q.437-.438 1.062-.438t1.063.438q.437.437.437 1.062t-.437 1.062q-.438.438-1.063.438ZM12 12Zm-.925 7.925H12.9l.35-2.625q.8-.2 1.475-.6.675-.4 1.225-.975l2.475 1.025.9-1.575-2.15-1.625q.125-.35.188-.75.062-.4.062-.8t-.062-.8q-.063-.4-.188-.75l2.15-1.625-.9-1.575L15.95 8.3q-.55-.6-1.225-1t-1.475-.6l-.325-2.625h-1.85L10.75 6.7q-.8.2-1.475.6-.675.4-1.25.975L5.575 7.25l-.9 1.575 2.125 1.6q-.125.375-.187.763-.063.387-.063.812 0 .4.063.787.062.388.187.788l-2.125 1.6.9 1.575 2.45-1.025q.575.575 1.25.975t1.475.6Z"/>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div id="DZ_W_TimeLine02" class="widget-timeline dz-scroll style-1  p-3 height370">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge primary"></div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>10 minutes ago</span>
                                                <h6 class="mb-0">Youtube, a video-sharing website, goes live <strong
                                                        class="text-primary">$500</strong>.</h6>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge info">
                                            </div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>20 minutes ago</span>
                                                <h6 class="mb-0">New order placed <strong
                                                        class="text-info">#XF-2356.</strong></h6>
                                                <p class="mb-0">Quisque a consequat ante Sit amet magna at
                                                    volutapt...</p>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge danger">
                                            </div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>30 minutes ago</span>
                                                <h6 class="mb-0">john just buy your product <strong
                                                        class="text-warning">Sell $250</strong></h6>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge success">
                                            </div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>15 minutes ago</span>
                                                <h6 class="mb-0">StumbleUpon is acquired by eBay. </h6>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge warning">
                                            </div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>20 minutes ago</span>
                                                <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge dark">
                                            </div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>20 minutes ago</span>
                                                <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link bell-icon " href="javascript:void(0);" role="button"
                               data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                    <path d="M3.65 19.175V16.9h2.075v-6.775q0-2.15 1.288-3.838Q8.3 4.6 10.35 4.075V3.4q0-.675.488-1.15.487-.475 1.162-.475.675 0 1.163.475.487.475.487 1.15v.675q2.075.525 3.35 2.2 1.275 1.675 1.275 3.85V16.9h2.075v2.275ZM12 11.5Zm0 10.7q-.85 0-1.462-.6-.613-.6-.613-1.45h4.15q0 .85-.612 1.45-.613.6-1.463.6Zm-4-5.3h8v-6.775q0-1.65-1.175-2.825Q13.65 6.125 12 6.125q-1.65 0-2.825 1.175Q8 8.475 8 10.125Z"/>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end of-visible">
                                <div class="dropdown-header">
                                    <h4 class="title mb-0">Notification</h4>
                                    <a href="javascript:void(0);" class="d-none"><i class="flaticon-381-settings-6"></i></a>
                                </div>
                                <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3" style="height:380px;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2">
                                                    <img alt="image" width="50" src="images/avatar/1.jpg">
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-info">
                                                    KG
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Resport created successfully</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-success">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2">
                                                    <img alt="image" width="50" src="images/avatar/1.jpg">
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-danger">
                                                    KG
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Resport created successfully</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-primary">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <a class="all-notification" href="javascript:void(0);">See all notifications <i
                                        class="ti-arrow-end"></i></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link bell-link" href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                    <path d="M4.075 20.2q-.95 0-1.613-.662-.662-.663-.662-1.613V6.075q0-.95.662-1.613.663-.662 1.613-.662h15.85q.95 0 1.613.662.662.663.662 1.613v11.85q0 .95-.662 1.613-.663.662-1.613.662ZM12 13.25l-7.925-5v9.675h15.85V8.25Zm0-2.175 7.925-5H4.075ZM4.075 8.25V6.075 17.925Z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <div class="btn-group profile-dropdown">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <span class="cp-user-avater">
                                        <span class="cp-user-img">
                                            <img src="{{show_image(Auth::user()->id,'user')}}" class="img-fluid" alt="">
                                        </span>
                                        <span
                                            class="name">{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <span class="big-user-thumb">
                                        <img src="{{show_image(Auth::user()->id,'user')}}" class="img-fluid" alt="">
                                    </span>
                                    <div class="user-name">
                                        <p>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</p>
                                    </div>
                                    <button class="dropdown-item" type="button"><a href="{{route('adminProfile')}}"><i
                                                class="fa fa-user-circle-o"></i> {{__('Profile')}}</a></button>
                                    <button class="dropdown-item" type="button"><a href="{{route('myWalletList')}}"><i
                                                class="fa fa-money"></i> {{__('My Wallet List')}}</a></button>
                                    <button class="dropdown-item" type="button"><a href="{{route('logOut')}}"><i
                                                class="fa fa-sign-out"></i> {{__('Logout')}}</a></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
