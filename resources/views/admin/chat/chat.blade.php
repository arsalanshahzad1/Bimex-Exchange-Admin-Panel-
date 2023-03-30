<div class="chatbox" id="chat_main">
    <div class="chatbox-close"></div>
    <div class="custom-tab-1">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="chat" role="tabpanel">
                <div class="card chat dz-chat-history-box">
                    <div class="card-header chat-list-header text-center">
                        <a href="javascript:void(0);" class="back-chat-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20">
                                <path d="m8 18-8-8 8-8 1.417 1.417L2.833 10l6.584 6.583Z" />
                            </svg> </a>
                        <div>
                            <h6 class="mb-1">Chat with <span class="chat-user-name">No Name</span></h6>
                            {{-- <p class="mb-0 text-success">Online</p> --}}
                        </div>
                        <div></div>
                        {{-- <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"
                                class="">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                    <path
                                        d="M6 14q-.825 0-1.412-.588Q4 12.825 4 12t.588-1.413Q5.175 10 6 10t1.412.587Q8 11.175 8 12q0 .825-.588 1.412Q6.825 14 6 14Zm6 0q-.825 0-1.412-.588Q10 12.825 10 12t.588-1.413Q11.175 10 12 10t1.413.587Q14 11.175 14 12q0 .825-.587 1.412Q12.825 14 12 14Zm6 0q-.825 0-1.413-.588Q16 12.825 16 12t.587-1.413Q17.175 10 18 10q.825 0 1.413.587Q20 11.175 20 12q0 .825-.587 1.412Q18.825 14 18 14Z" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                <li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i> View
                                    profile</li>
                                <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to
                                    btn-close friends</li>
                                <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to group
                                </li>
                                <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body3">
                        <div class="message-list" id="single_chat_messages">
                            
                        </div>
                        <div class="data-loader">
                            Loading...
                        </div>
                    </div>
                    <div class="card-footer type_msg">
                        <form action="{{ url('admin/chat') }}" method="post" class="send-chat-form">
                            @csrf
                            <input type="hidden" name="friendship_id" class="friendship_id">
                            <input type="hidden" name="user_id" value="" class="user_id">
                            <div class="input-group">
                                <textarea class="form-control custom-scroll message-body" required name="body" placeholder="Type your message..."></textarea>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary send-btn send-message-btn"><i
                                            class="fa fa-location-arrow"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
