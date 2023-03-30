<div class="chatbox" id="chat_list_main">
    <div class="chatbox-close"></div>
    <div class="custom-tab-1">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="chat" role="tabpanel">
                <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
                    <div class="card-header chat-list-header text-center">
                        <a href="javascript:void(0);" class="open-user-list">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                <path d="M11 19v-6H5v-2h6V5h2v6h6v2h-6v6Z" />
                            </svg>
                        </a>
                        <div>
                            <h6 class="mb-1">Chat List</h6>
                            <p class="mb-0">Show All</p>
                        </div>
                        <a href="javascript:void(0);" class="close-chat-box">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                <path
                                    d="M6 14q-.825 0-1.412-.588Q4 12.825 4 12t.588-1.413Q5.175 10 6 10t1.412.587Q8 11.175 8 12q0 .825-.588 1.412Q6.825 14 6 14Zm6 0q-.825 0-1.412-.588Q10 12.825 10 12t.588-1.413Q11.175 10 12 10t1.413.587Q14 11.175 14 12q0 .825-.587 1.412Q12.825 14 12 14Zm6 0q-.825 0-1.413-.588Q16 12.825 16 12t.587-1.413Q17.175 10 18 10q.825 0 1.413.587Q20 11.175 20 12q0 .825-.587 1.412Q18.825 14 18 14Z" />
                            </svg> --}}
                            <svg height="12" width="12"
                                xmlns="http://www.w3.org/2000/svg">
                                <line x1="1" y1="11" 
                                    x2="11" y2="1" 
                                    stroke="white" 
                                    stroke-width="2"/>
                                <line x1="1" y1="1" 
                                    x2="11" y2="11" 
                                    stroke="white" 
                                    stroke-width="2"/>
                            </svg>
                        </a>
                    </div>
                    <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">
                        <ul class="contacts" id="user_chat_list">
                            {{-- <li class="name-first-letter">A</li> --}}
                           
                        </ul>
                        <div class="data-loader">
                            Loading...
                        </div>
                    </div>
                </div>
            </div>
            <!--     CHAT SCREEN       -->
            <div class="tab-pane fade active show" id="chat" role="tabpanel">

            </div>
        </div>
    </div>
</div>
