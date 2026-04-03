@extends('layout.index')

@section('title','Activity')

@section('navbar')
    <div class="navbar-container flex items-center justify-between w-full gap-4 pe-6">
        <h1 class="text-lg md:text-3xl font-bold">Activity <span class="text-base text-gray-400">> Billing Queus</span></h1>
        <div class="date-place hidden md:inline-flex px-2 py-2 pe-4 bg-white rounded-full shadow items-center gap-3">
            <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-100"><i class="fas fa-calendar-days text-lg text-blue-400"></i></div>
            <span class="text-gray-600 font-medium">{{ date('D, d M Y') }}</span>
        </div>
    </div>
@endsection

@section('container')
    <div class="grid grid-cols-8 p-8 gap-5">
        <div class="col-span-8 md:col-span-2 bg-white rounded-base p-5 pt-10">
            <div class="w-full text-sm font-medium text-heading bg-neutral-primary-soft flex flex-wrap gap-3">
                <a href="{{ route('activity.index') }}" aria-current="true" class="text-lg block w-full px-4 py-5 text-white bg-brand-light rounded-lg cursor-pointer">
                    Billing Queus
                </a>
                
                <a href="{{ route('activity.history') }}" class="block w-full px-4 py-5 text-lg cursor-pointer hover:bg-brand-softer hover:text-fg-brand rounded-lg">
                    Order History
                </a>
                @can('admin')
                    <a href="{{ route('activity.report') }}" class="block w-full px-4 py-5 text-lg cursor-pointer hover:bg-brand-softer hover:text-fg-brand rounded-lg">
                    Report
                    </a>
                @endcan
            </div>

        </div>
        <div class="col-span-8 md:col-span-6 bg-white rounded-md p-5 min-h-[calc(100vh-100px)]">
            <div class="mb-4 border-b border-default">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="bill-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-base" id="all-tab" data-tabs-target="#all" type="button" role="tab" aria-controls="profile" aria-selected="false">All</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-base hover:text-fg-brand hover:border-brand" id="active-tab" data-tabs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="false">Active</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-base hover:text-fg-brand hover:border-brand" id="process-tab" data-tabs-target="#process" type="button" role="tab" aria-controls="process" aria-selected="false">Process</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-base hover:text-fg-brand hover:border-brand" id="payment-tab" data-tabs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">Payment</button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-base hover:text-fg-brand hover:border-brand" id="paid-tab" data-tabs-target="#paid" type="button" role="tab" aria-controls="paid" aria-selected="false">Paid</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <ul role="list" class="divide-y divide-default">
                        @foreach($transactions as $transaction)
                            @php
                                if($transaction->status == 'active') {
                                    $class_color = "bg-green-200 text-green-600";
                                } else if($transaction->status == 'process') {
                                    $class_color = "bg-brand-soft text-brand-light";
                                } else if($transaction->status == 'payment') {
                                    $class_color = "bg-yellow-200 text-yellow-600";
                                } else if($transaction->status == 'paid') {
                                    $class_color = "bg-red-200 text-red-600";
                                }
                            @endphp
                            <li class="pb-4 sm:pb-4"  data-uuid="{{ $transaction->uuid }}" data-status="{{ $transaction->status }}">
                                <div class="flex items-center gap-2 md:gap-5 flex-wrap">
                                    <div class="shrink-0">
                                        @if ($transaction->order_type == 'take_away')
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-warning-subtle">
                                                <svg class="w-7 h-7" version="1.1" id="_x34_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:none;" d="M239.059,88.606h-0.102v12.854h91.894c-13.453-37.827-49.51-65.029-91.894-65.029v52.111 L239.059,88.606z"></path> <path style="fill:none;" d="M147.063,101.46h91.894V88.606h-0.102v-0.128l0.102,0.064V36.431h0 C196.573,36.431,160.515,63.633,147.063,101.46z"></path> <g> <g> <g> <path style="fill:#F2E7D3;" d="M372.971,134.01v24.685c0,10.113-8.122,18.235-18.234,18.235 c-10.033,0-18.155-8.122-18.155-18.235V134.01c0-11.386-1.991-22.374-5.653-32.566c-1.672-4.699-3.663-9.316-6.131-13.695 c-0.08-0.08-0.08-0.159-0.08-0.239c-1.115-2.07-2.309-4.141-3.662-6.132c-2.628-4.141-5.654-8.122-8.918-11.785 c-1.593-1.911-3.265-3.662-5.096-5.334c-5.256-5.177-11.148-9.794-17.438-13.618c-0.08,0-0.08-0.08-0.08-0.08 c-2.15-1.273-4.3-2.469-6.45-3.503c-4.379-2.31-8.998-4.221-13.775-5.733c-2.389-0.795-4.858-1.513-7.326-2.07 c-2.468-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877c-0.478-0.08-0.956-0.159-1.433-0.159 c-2.23-0.157-4.539-0.239-6.848-0.239c-42.441,0-78.592,27.154-91.969,64.977c-3.663,10.193-5.653,21.18-5.653,32.566v24.685 c0,10.113-8.122,18.235-18.155,18.235c-10.112,0-18.234-8.122-18.234-18.235V134.01c0-11.227,1.354-22.135,3.981-32.566 C123.58,43.237,176.293,0,238.96,0c1.991,0,3.902,0.08,5.813,0.159c1.115,0,2.15,0.08,3.185,0.157 c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556c1.513,0.159,3.105,0.399,4.618,0.717 c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448c1.433,1.116,2.787,2.309,4.22,3.505 c1.593,1.353,3.106,2.786,4.698,4.219c1.115,0.956,2.229,2.07,3.264,3.186c2.628,2.549,5.096,5.255,7.326,8.042 c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378c9.635,13.299,16.722,28.507,20.862,44.91 C371.618,111.876,372.971,122.784,372.971,134.01z"></path> </g> <rect x="19.986" y="101.444" style="fill:#B9A078;" width="437.947" height="88.464"></rect> <path style="fill:#E1C9A1;" d="M477.919,215.947v270.015c0,14.331-11.625,26.038-26.038,26.038H26.038 c-0.478,0-1.035,0-1.513-0.082c-13.218-0.715-23.729-11.306-24.445-24.444C0,486.996,0,486.44,0,485.962V215.947 c0-14.413,11.625-26.038,26.038-26.038h425.844C466.294,189.908,477.919,201.534,477.919,215.947z"></path> <rect y="189.909" style="fill:#D7BD8D;" width="477.919" height="260.777"></rect> <polygon style="fill:#777064;" points="448.139,185.849 454.27,189.908 74.451,189.908 90.535,135.047 19.986,101.444 457.933,101.444 450.846,104.868 388.339,135.605 387.384,136.083 441.848,181.627 "></polygon> <g> <polygon style="fill:#56524D;" points="477.925,189.882 387.399,189.882 387.399,135.067 "></polygon> <polygon style="fill:#56524D;" points="90.535,135.047 90.535,189.908 0,189.908 19.986,177.805 "></polygon> </g> <g> <circle style="fill:#777064;" cx="123.144" cy="260.358" r="24.851"></circle> <circle style="fill:#777064;" cx="354.77" cy="260.358" r="24.851"></circle> </g> <g> <path style="fill:#F2E7D3;" d="M238.957,421.22c-73.901,0-134.023-60.122-134.023-134.023v-24.701 c0-10.057,8.153-18.21,18.21-18.21s18.21,8.153,18.21,18.21v24.701c0,53.819,43.784,97.603,97.603,97.603 s97.603-43.785,97.603-97.603v-24.701c0-10.057,8.153-18.21,18.21-18.21c10.057,0,18.21,8.153,18.21,18.21v24.701 C372.98,361.098,312.858,421.22,238.957,421.22z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.477 239.059,88.606 238.855,88.606 "></polygon> </g> <path style="opacity:0.07;fill:#040000;" d="M477.919,189.908v296.053c0,14.331-11.625,26.038-26.038,26.038H238.96V101.444 h91.889c-1.672-4.778-3.663-9.316-6.052-13.695c-0.08-0.08-0.08-0.159-0.08-0.239c-1.194-2.07-2.389-4.141-3.662-6.132 c-2.708-4.141-5.654-8.122-8.918-11.785c-1.672-1.831-3.345-3.662-5.096-5.334c-5.256-5.177-11.148-9.716-17.438-13.618 c-0.08,0-0.08-0.08-0.08-0.08c-2.15-1.194-4.22-2.387-6.45-3.503c-4.379-2.23-8.998-4.221-13.775-5.733 c-2.389-0.795-4.858-1.513-7.326-2.07c-2.389-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877 c-0.478-0.08-0.956-0.159-1.433-0.159c-2.23-0.157-4.539-0.239-6.848-0.239V0c1.991,0,3.902,0.08,5.813,0.159 c1.115,0,2.15,0.08,3.185,0.157c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556 c1.513,0.159,3.105,0.399,4.618,0.717c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448 c1.433,1.116,2.787,2.309,4.22,3.505c1.593,1.353,3.106,2.786,4.698,4.219c1.115,1.036,2.15,2.07,3.264,3.186 c2.548,2.626,4.937,5.255,7.326,8.042c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378 c9.476,13.379,16.562,28.587,20.703,44.91h89.102v76.283L477.919,189.908z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.478 238.855,88.606 238.957,88.606 238.957,88.542 "></polygon> <polygon style="fill:#777064;" points="238.957,88.542 238.957,88.606 239.059,88.606 "></polygon> </g> </g></svg>
                                            </div>
                                        @else
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-brand-medium">
                                                <svg class="w-7 h-7" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#2C6991;" d="M284.522,38.116h-56.465c-16.112,0-29.293,13.182-29.293,29.293v83.877h114.471V66.829 C313.235,50.971,300.38,38.116,284.522,38.116z"></path> <path style="fill:#528FB3;" d="M255.999,38.116h-27.943c-16.112,0-29.293,13.182-29.293,29.293v83.877h57.235V38.116z"></path> <path style="fill:#245475;" d="M461.206,155.372c-10.776,0-19.832,8.921-19.833,19.327H70.626c0-10.406-9.056-19.327-19.833-19.327 s-19.833,8.921-19.833,19.697v154.275c0,79.815,65.576,144.54,145.392,144.54h159.295c79.815,0,145.392-64.725,145.392-144.54 V175.069C481.038,164.293,471.982,155.372,461.206,155.372z"></path> <path style="fill:#2C6991;" d="M255.999,174.699H70.626c0-10.406-9.056-19.327-19.833-19.327s-19.833,8.921-19.833,19.697v154.275 c0,79.815,65.576,144.54,145.392,144.54h79.647V174.699H255.999z"></path> <path style="fill:#ABA8AB;" d="M475.553,162.024c-53.031-60.448-129.565-95.293-209.978-95.293h-19.149 c-80.414,0-156.948,34.845-209.978,95.293c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.977,10.112,11.364,17.774,11.364h409.771 c7.66,0,14.612-4.386,17.774-11.364C481.823,175.869,480.605,167.784,475.553,162.024z"></path> <path style="fill:#CCCCCC;" d="M255.999,66.732h-9.574c-80.414,0-156.948,34.845-209.978,95.293 c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.978,10.112,11.364,17.774,11.364h204.886V66.732H255.999z"></path> <path style="fill:#2C6991;" d="M492.488,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h472.976 c10.776,0,19.512-8.736,19.512-19.512S503.264,165.594,492.488,165.594z"></path> <path style="fill:#528FB3;" d="M255.999,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h236.487 V165.594z"></path> </g></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-heading truncate">{{$transaction->customer_name ?? 'Guest'}} <span class="status text-sm truncate {{ $class_color }} px-3 rounded-full">{{$transaction->status}}</span></p>
                                        <p class="text-sm text-body truncate">Order ID : #{{ $transaction->invoice_number }} - <span class="meja">{{$transaction->table && $transaction->table->name ? $transaction->table->name : "No Table"}}</span></p>
                                        <p class="text-sm text-body truncate">Date : {{date('d M Y, H:i:s', strtotime($transaction->created_at))}}</p>
                                    </div>
                                    <div class="inline-flex items-center space-x-1.5">    
                                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-brand-subtle text-brand rounded-full hover:bg-blue-400 hover:text-white cursor-pointer outline-0 inline-flex justify-center items-center see-transaction">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#1C274C" stroke-width="1.5"></path> </g></svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
                <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="active" role="tabpanel" aria-labelledby="active-tab">
                    <ul role="list" class="divide-y divide-default">
                        @php
                            $transactions_active = $transactions->filter(function($elem) {
                                return $elem->status == 'active';
                            });
                        @endphp
                        @foreach($transactions_active as $transaction)
                            @php
                                if($transaction->status == 'active') {
                                    $class_color = "bg-green-200 text-green-600";
                                } else if($transaction->status == 'process') {
                                    $class_color = "bg-brand-soft text-brand-light";
                                } else if($transaction->status == 'payment') {
                                    $class_color = "bg-yellow-200 text-yellow-600";
                                } else if($transaction->status == 'paid') {
                                    $class_color = "bg-red-200 text-red-600";
                                }
                            @endphp
                            <li class="pb-4 sm:pb-4"  data-uuid="{{ $transaction->uuid }}" data-status="{{ $transaction->status }}">
                                <div class="flex items-center gap-2 md:gap-5 flex-wrap">
                                    <div class="shrink-0">
                                        @if ($transaction->order_type == 'take_away')
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-warning-subtle">
                                                <svg class="w-7 h-7" version="1.1" id="_x34_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:none;" d="M239.059,88.606h-0.102v12.854h91.894c-13.453-37.827-49.51-65.029-91.894-65.029v52.111 L239.059,88.606z"></path> <path style="fill:none;" d="M147.063,101.46h91.894V88.606h-0.102v-0.128l0.102,0.064V36.431h0 C196.573,36.431,160.515,63.633,147.063,101.46z"></path> <g> <g> <g> <path style="fill:#F2E7D3;" d="M372.971,134.01v24.685c0,10.113-8.122,18.235-18.234,18.235 c-10.033,0-18.155-8.122-18.155-18.235V134.01c0-11.386-1.991-22.374-5.653-32.566c-1.672-4.699-3.663-9.316-6.131-13.695 c-0.08-0.08-0.08-0.159-0.08-0.239c-1.115-2.07-2.309-4.141-3.662-6.132c-2.628-4.141-5.654-8.122-8.918-11.785 c-1.593-1.911-3.265-3.662-5.096-5.334c-5.256-5.177-11.148-9.794-17.438-13.618c-0.08,0-0.08-0.08-0.08-0.08 c-2.15-1.273-4.3-2.469-6.45-3.503c-4.379-2.31-8.998-4.221-13.775-5.733c-2.389-0.795-4.858-1.513-7.326-2.07 c-2.468-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877c-0.478-0.08-0.956-0.159-1.433-0.159 c-2.23-0.157-4.539-0.239-6.848-0.239c-42.441,0-78.592,27.154-91.969,64.977c-3.663,10.193-5.653,21.18-5.653,32.566v24.685 c0,10.113-8.122,18.235-18.155,18.235c-10.112,0-18.234-8.122-18.234-18.235V134.01c0-11.227,1.354-22.135,3.981-32.566 C123.58,43.237,176.293,0,238.96,0c1.991,0,3.902,0.08,5.813,0.159c1.115,0,2.15,0.08,3.185,0.157 c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556c1.513,0.159,3.105,0.399,4.618,0.717 c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448c1.433,1.116,2.787,2.309,4.22,3.505 c1.593,1.353,3.106,2.786,4.698,4.219c1.115,0.956,2.229,2.07,3.264,3.186c2.628,2.549,5.096,5.255,7.326,8.042 c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378c9.635,13.299,16.722,28.507,20.862,44.91 C371.618,111.876,372.971,122.784,372.971,134.01z"></path> </g> <rect x="19.986" y="101.444" style="fill:#B9A078;" width="437.947" height="88.464"></rect> <path style="fill:#E1C9A1;" d="M477.919,215.947v270.015c0,14.331-11.625,26.038-26.038,26.038H26.038 c-0.478,0-1.035,0-1.513-0.082c-13.218-0.715-23.729-11.306-24.445-24.444C0,486.996,0,486.44,0,485.962V215.947 c0-14.413,11.625-26.038,26.038-26.038h425.844C466.294,189.908,477.919,201.534,477.919,215.947z"></path> <rect y="189.909" style="fill:#D7BD8D;" width="477.919" height="260.777"></rect> <polygon style="fill:#777064;" points="448.139,185.849 454.27,189.908 74.451,189.908 90.535,135.047 19.986,101.444 457.933,101.444 450.846,104.868 388.339,135.605 387.384,136.083 441.848,181.627 "></polygon> <g> <polygon style="fill:#56524D;" points="477.925,189.882 387.399,189.882 387.399,135.067 "></polygon> <polygon style="fill:#56524D;" points="90.535,135.047 90.535,189.908 0,189.908 19.986,177.805 "></polygon> </g> <g> <circle style="fill:#777064;" cx="123.144" cy="260.358" r="24.851"></circle> <circle style="fill:#777064;" cx="354.77" cy="260.358" r="24.851"></circle> </g> <g> <path style="fill:#F2E7D3;" d="M238.957,421.22c-73.901,0-134.023-60.122-134.023-134.023v-24.701 c0-10.057,8.153-18.21,18.21-18.21s18.21,8.153,18.21,18.21v24.701c0,53.819,43.784,97.603,97.603,97.603 s97.603-43.785,97.603-97.603v-24.701c0-10.057,8.153-18.21,18.21-18.21c10.057,0,18.21,8.153,18.21,18.21v24.701 C372.98,361.098,312.858,421.22,238.957,421.22z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.477 239.059,88.606 238.855,88.606 "></polygon> </g> <path style="opacity:0.07;fill:#040000;" d="M477.919,189.908v296.053c0,14.331-11.625,26.038-26.038,26.038H238.96V101.444 h91.889c-1.672-4.778-3.663-9.316-6.052-13.695c-0.08-0.08-0.08-0.159-0.08-0.239c-1.194-2.07-2.389-4.141-3.662-6.132 c-2.708-4.141-5.654-8.122-8.918-11.785c-1.672-1.831-3.345-3.662-5.096-5.334c-5.256-5.177-11.148-9.716-17.438-13.618 c-0.08,0-0.08-0.08-0.08-0.08c-2.15-1.194-4.22-2.387-6.45-3.503c-4.379-2.23-8.998-4.221-13.775-5.733 c-2.389-0.795-4.858-1.513-7.326-2.07c-2.389-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877 c-0.478-0.08-0.956-0.159-1.433-0.159c-2.23-0.157-4.539-0.239-6.848-0.239V0c1.991,0,3.902,0.08,5.813,0.159 c1.115,0,2.15,0.08,3.185,0.157c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556 c1.513,0.159,3.105,0.399,4.618,0.717c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448 c1.433,1.116,2.787,2.309,4.22,3.505c1.593,1.353,3.106,2.786,4.698,4.219c1.115,1.036,2.15,2.07,3.264,3.186 c2.548,2.626,4.937,5.255,7.326,8.042c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378 c9.476,13.379,16.562,28.587,20.703,44.91h89.102v76.283L477.919,189.908z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.478 238.855,88.606 238.957,88.606 238.957,88.542 "></polygon> <polygon style="fill:#777064;" points="238.957,88.542 238.957,88.606 239.059,88.606 "></polygon> </g> </g></svg>
                                            </div>
                                        @else
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-brand-medium">
                                                <svg class="w-7 h-7" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#2C6991;" d="M284.522,38.116h-56.465c-16.112,0-29.293,13.182-29.293,29.293v83.877h114.471V66.829 C313.235,50.971,300.38,38.116,284.522,38.116z"></path> <path style="fill:#528FB3;" d="M255.999,38.116h-27.943c-16.112,0-29.293,13.182-29.293,29.293v83.877h57.235V38.116z"></path> <path style="fill:#245475;" d="M461.206,155.372c-10.776,0-19.832,8.921-19.833,19.327H70.626c0-10.406-9.056-19.327-19.833-19.327 s-19.833,8.921-19.833,19.697v154.275c0,79.815,65.576,144.54,145.392,144.54h159.295c79.815,0,145.392-64.725,145.392-144.54 V175.069C481.038,164.293,471.982,155.372,461.206,155.372z"></path> <path style="fill:#2C6991;" d="M255.999,174.699H70.626c0-10.406-9.056-19.327-19.833-19.327s-19.833,8.921-19.833,19.697v154.275 c0,79.815,65.576,144.54,145.392,144.54h79.647V174.699H255.999z"></path> <path style="fill:#ABA8AB;" d="M475.553,162.024c-53.031-60.448-129.565-95.293-209.978-95.293h-19.149 c-80.414,0-156.948,34.845-209.978,95.293c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.977,10.112,11.364,17.774,11.364h409.771 c7.66,0,14.612-4.386,17.774-11.364C481.823,175.869,480.605,167.784,475.553,162.024z"></path> <path style="fill:#CCCCCC;" d="M255.999,66.732h-9.574c-80.414,0-156.948,34.845-209.978,95.293 c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.978,10.112,11.364,17.774,11.364h204.886V66.732H255.999z"></path> <path style="fill:#2C6991;" d="M492.488,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h472.976 c10.776,0,19.512-8.736,19.512-19.512S503.264,165.594,492.488,165.594z"></path> <path style="fill:#528FB3;" d="M255.999,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h236.487 V165.594z"></path> </g></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-heading truncate">{{$transaction->customer_name ?? 'Guest'}} <span class="status text-sm truncate {{ $class_color }} px-3 rounded-full">{{$transaction->status}}</span></p>
                                        <p class="text-sm text-body truncate">Order ID : #{{ $transaction->invoice_number }} - <span class="meja">{{$transaction->table && $transaction->table->name ? $transaction->table->name : "No Table"}}</span></p>
                                        <p class="text-sm text-body truncate">Date : {{date('d M Y, H:i:s', strtotime($transaction->created_at))}}</p>
                                    </div>
                                    <div class="inline-flex items-center space-x-1.5">    
                                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-brand-subtle text-brand rounded-full hover:bg-blue-400 hover:text-white cursor-pointer outline-0 inline-flex justify-center items-center see-transaction">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#1C274C" stroke-width="1.5"></path> </g></svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
                <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="process" role="tabpanel" aria-labelledby="process-tab">
                    <ul role="list" class="divide-y divide-default">
                        @php
                            $transactions_active = $transactions->filter(function($elem) {
                                return $elem->status == 'process';
                            });
                        @endphp
                        @foreach($transactions_active as $transaction)
                            @php
                                if($transaction->status == 'active') {
                                    $class_color = "bg-green-200 text-green-600";
                                } else if($transaction->status == 'process') {
                                    $class_color = "bg-brand-soft text-brand-light";
                                } else if($transaction->status == 'payment') {
                                    $class_color = "bg-yellow-200 text-yellow-600";
                                } else if($transaction->status == 'paid') {
                                    $class_color = "bg-red-200 text-red-600";
                                }
                            @endphp
                            <li class="pb-4 sm:pb-4"  data-uuid="{{ $transaction->uuid }}" data-status="{{ $transaction->status }}">
                                <div class="flex items-center gap-2 md:gap-5 flex-wrap">
                                    <div class="shrink-0">
                                        @if ($transaction->order_type == 'take_away')
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-warning-subtle">
                                                <svg class="w-7 h-7" version="1.1" id="_x34_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:none;" d="M239.059,88.606h-0.102v12.854h91.894c-13.453-37.827-49.51-65.029-91.894-65.029v52.111 L239.059,88.606z"></path> <path style="fill:none;" d="M147.063,101.46h91.894V88.606h-0.102v-0.128l0.102,0.064V36.431h0 C196.573,36.431,160.515,63.633,147.063,101.46z"></path> <g> <g> <g> <path style="fill:#F2E7D3;" d="M372.971,134.01v24.685c0,10.113-8.122,18.235-18.234,18.235 c-10.033,0-18.155-8.122-18.155-18.235V134.01c0-11.386-1.991-22.374-5.653-32.566c-1.672-4.699-3.663-9.316-6.131-13.695 c-0.08-0.08-0.08-0.159-0.08-0.239c-1.115-2.07-2.309-4.141-3.662-6.132c-2.628-4.141-5.654-8.122-8.918-11.785 c-1.593-1.911-3.265-3.662-5.096-5.334c-5.256-5.177-11.148-9.794-17.438-13.618c-0.08,0-0.08-0.08-0.08-0.08 c-2.15-1.273-4.3-2.469-6.45-3.503c-4.379-2.31-8.998-4.221-13.775-5.733c-2.389-0.795-4.858-1.513-7.326-2.07 c-2.468-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877c-0.478-0.08-0.956-0.159-1.433-0.159 c-2.23-0.157-4.539-0.239-6.848-0.239c-42.441,0-78.592,27.154-91.969,64.977c-3.663,10.193-5.653,21.18-5.653,32.566v24.685 c0,10.113-8.122,18.235-18.155,18.235c-10.112,0-18.234-8.122-18.234-18.235V134.01c0-11.227,1.354-22.135,3.981-32.566 C123.58,43.237,176.293,0,238.96,0c1.991,0,3.902,0.08,5.813,0.159c1.115,0,2.15,0.08,3.185,0.157 c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556c1.513,0.159,3.105,0.399,4.618,0.717 c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448c1.433,1.116,2.787,2.309,4.22,3.505 c1.593,1.353,3.106,2.786,4.698,4.219c1.115,0.956,2.229,2.07,3.264,3.186c2.628,2.549,5.096,5.255,7.326,8.042 c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378c9.635,13.299,16.722,28.507,20.862,44.91 C371.618,111.876,372.971,122.784,372.971,134.01z"></path> </g> <rect x="19.986" y="101.444" style="fill:#B9A078;" width="437.947" height="88.464"></rect> <path style="fill:#E1C9A1;" d="M477.919,215.947v270.015c0,14.331-11.625,26.038-26.038,26.038H26.038 c-0.478,0-1.035,0-1.513-0.082c-13.218-0.715-23.729-11.306-24.445-24.444C0,486.996,0,486.44,0,485.962V215.947 c0-14.413,11.625-26.038,26.038-26.038h425.844C466.294,189.908,477.919,201.534,477.919,215.947z"></path> <rect y="189.909" style="fill:#D7BD8D;" width="477.919" height="260.777"></rect> <polygon style="fill:#777064;" points="448.139,185.849 454.27,189.908 74.451,189.908 90.535,135.047 19.986,101.444 457.933,101.444 450.846,104.868 388.339,135.605 387.384,136.083 441.848,181.627 "></polygon> <g> <polygon style="fill:#56524D;" points="477.925,189.882 387.399,189.882 387.399,135.067 "></polygon> <polygon style="fill:#56524D;" points="90.535,135.047 90.535,189.908 0,189.908 19.986,177.805 "></polygon> </g> <g> <circle style="fill:#777064;" cx="123.144" cy="260.358" r="24.851"></circle> <circle style="fill:#777064;" cx="354.77" cy="260.358" r="24.851"></circle> </g> <g> <path style="fill:#F2E7D3;" d="M238.957,421.22c-73.901,0-134.023-60.122-134.023-134.023v-24.701 c0-10.057,8.153-18.21,18.21-18.21s18.21,8.153,18.21,18.21v24.701c0,53.819,43.784,97.603,97.603,97.603 s97.603-43.785,97.603-97.603v-24.701c0-10.057,8.153-18.21,18.21-18.21c10.057,0,18.21,8.153,18.21,18.21v24.701 C372.98,361.098,312.858,421.22,238.957,421.22z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.477 239.059,88.606 238.855,88.606 "></polygon> </g> <path style="opacity:0.07;fill:#040000;" d="M477.919,189.908v296.053c0,14.331-11.625,26.038-26.038,26.038H238.96V101.444 h91.889c-1.672-4.778-3.663-9.316-6.052-13.695c-0.08-0.08-0.08-0.159-0.08-0.239c-1.194-2.07-2.389-4.141-3.662-6.132 c-2.708-4.141-5.654-8.122-8.918-11.785c-1.672-1.831-3.345-3.662-5.096-5.334c-5.256-5.177-11.148-9.716-17.438-13.618 c-0.08,0-0.08-0.08-0.08-0.08c-2.15-1.194-4.22-2.387-6.45-3.503c-4.379-2.23-8.998-4.221-13.775-5.733 c-2.389-0.795-4.858-1.513-7.326-2.07c-2.389-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877 c-0.478-0.08-0.956-0.159-1.433-0.159c-2.23-0.157-4.539-0.239-6.848-0.239V0c1.991,0,3.902,0.08,5.813,0.159 c1.115,0,2.15,0.08,3.185,0.157c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556 c1.513,0.159,3.105,0.399,4.618,0.717c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448 c1.433,1.116,2.787,2.309,4.22,3.505c1.593,1.353,3.106,2.786,4.698,4.219c1.115,1.036,2.15,2.07,3.264,3.186 c2.548,2.626,4.937,5.255,7.326,8.042c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378 c9.476,13.379,16.562,28.587,20.703,44.91h89.102v76.283L477.919,189.908z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.478 238.855,88.606 238.957,88.606 238.957,88.542 "></polygon> <polygon style="fill:#777064;" points="238.957,88.542 238.957,88.606 239.059,88.606 "></polygon> </g> </g></svg>
                                            </div>
                                        @else
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-brand-medium">
                                                <svg class="w-7 h-7" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#2C6991;" d="M284.522,38.116h-56.465c-16.112,0-29.293,13.182-29.293,29.293v83.877h114.471V66.829 C313.235,50.971,300.38,38.116,284.522,38.116z"></path> <path style="fill:#528FB3;" d="M255.999,38.116h-27.943c-16.112,0-29.293,13.182-29.293,29.293v83.877h57.235V38.116z"></path> <path style="fill:#245475;" d="M461.206,155.372c-10.776,0-19.832,8.921-19.833,19.327H70.626c0-10.406-9.056-19.327-19.833-19.327 s-19.833,8.921-19.833,19.697v154.275c0,79.815,65.576,144.54,145.392,144.54h159.295c79.815,0,145.392-64.725,145.392-144.54 V175.069C481.038,164.293,471.982,155.372,461.206,155.372z"></path> <path style="fill:#2C6991;" d="M255.999,174.699H70.626c0-10.406-9.056-19.327-19.833-19.327s-19.833,8.921-19.833,19.697v154.275 c0,79.815,65.576,144.54,145.392,144.54h79.647V174.699H255.999z"></path> <path style="fill:#ABA8AB;" d="M475.553,162.024c-53.031-60.448-129.565-95.293-209.978-95.293h-19.149 c-80.414,0-156.948,34.845-209.978,95.293c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.977,10.112,11.364,17.774,11.364h409.771 c7.66,0,14.612-4.386,17.774-11.364C481.823,175.869,480.605,167.784,475.553,162.024z"></path> <path style="fill:#CCCCCC;" d="M255.999,66.732h-9.574c-80.414,0-156.948,34.845-209.978,95.293 c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.978,10.112,11.364,17.774,11.364h204.886V66.732H255.999z"></path> <path style="fill:#2C6991;" d="M492.488,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h472.976 c10.776,0,19.512-8.736,19.512-19.512S503.264,165.594,492.488,165.594z"></path> <path style="fill:#528FB3;" d="M255.999,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h236.487 V165.594z"></path> </g></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-heading truncate">{{$transaction->customer_name ?? 'Guest'}} <span class="status text-sm truncate {{ $class_color }} px-3 rounded-full">{{$transaction->status}}</span></p>
                                        <p class="text-sm text-body truncate">Order ID : #{{ $transaction->invoice_number }} - <span class="meja">{{$transaction->table && $transaction->table->name ? $transaction->table->name : "No Table"}}</span></p>
                                        <p class="text-sm text-body truncate">Date : {{date('d M Y, H:i:s', strtotime($transaction->created_at))}}</p>
                                    </div>
                                    <div class="inline-flex items-center space-x-1.5">    
                                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-brand-subtle text-brand rounded-full hover:bg-blue-400 hover:text-white cursor-pointer outline-0 inline-flex justify-center items-center see-transaction">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#1C274C" stroke-width="1.5"></path> </g></svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
                <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <ul role="list" class="divide-y divide-default">
                        @php
                            $transactions_active = $transactions->filter(function($elem) {
                                return $elem->status == 'payment';
                            });
                        @endphp
                        @foreach($transactions_active as $transaction)
                            @php
                                if($transaction->status == 'active') {
                                    $class_color = "bg-green-200 text-green-600";
                                } else if($transaction->status == 'process') {
                                    $class_color = "bg-brand-soft text-brand-light";
                                } else if($transaction->status == 'payment') {
                                    $class_color = "bg-yellow-200 text-yellow-600";
                                } else if($transaction->status == 'paid') {
                                    $class_color = "bg-red-200 text-red-600";
                                }
                            @endphp
                            <li class="pb-4 sm:pb-4"  data-uuid="{{ $transaction->uuid }}" data-status="{{ $transaction->status }}">
                                <div class="flex items-center gap-2 md:gap-5 flex-wrap">
                                    <div class="shrink-0">
                                        @if ($transaction->order_type == 'take_away')
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-warning-subtle">
                                                <svg class="w-7 h-7" version="1.1" id="_x34_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:none;" d="M239.059,88.606h-0.102v12.854h91.894c-13.453-37.827-49.51-65.029-91.894-65.029v52.111 L239.059,88.606z"></path> <path style="fill:none;" d="M147.063,101.46h91.894V88.606h-0.102v-0.128l0.102,0.064V36.431h0 C196.573,36.431,160.515,63.633,147.063,101.46z"></path> <g> <g> <g> <path style="fill:#F2E7D3;" d="M372.971,134.01v24.685c0,10.113-8.122,18.235-18.234,18.235 c-10.033,0-18.155-8.122-18.155-18.235V134.01c0-11.386-1.991-22.374-5.653-32.566c-1.672-4.699-3.663-9.316-6.131-13.695 c-0.08-0.08-0.08-0.159-0.08-0.239c-1.115-2.07-2.309-4.141-3.662-6.132c-2.628-4.141-5.654-8.122-8.918-11.785 c-1.593-1.911-3.265-3.662-5.096-5.334c-5.256-5.177-11.148-9.794-17.438-13.618c-0.08,0-0.08-0.08-0.08-0.08 c-2.15-1.273-4.3-2.469-6.45-3.503c-4.379-2.31-8.998-4.221-13.775-5.733c-2.389-0.795-4.858-1.513-7.326-2.07 c-2.468-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877c-0.478-0.08-0.956-0.159-1.433-0.159 c-2.23-0.157-4.539-0.239-6.848-0.239c-42.441,0-78.592,27.154-91.969,64.977c-3.663,10.193-5.653,21.18-5.653,32.566v24.685 c0,10.113-8.122,18.235-18.155,18.235c-10.112,0-18.234-8.122-18.234-18.235V134.01c0-11.227,1.354-22.135,3.981-32.566 C123.58,43.237,176.293,0,238.96,0c1.991,0,3.902,0.08,5.813,0.159c1.115,0,2.15,0.08,3.185,0.157 c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556c1.513,0.159,3.105,0.399,4.618,0.717 c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448c1.433,1.116,2.787,2.309,4.22,3.505 c1.593,1.353,3.106,2.786,4.698,4.219c1.115,0.956,2.229,2.07,3.264,3.186c2.628,2.549,5.096,5.255,7.326,8.042 c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378c9.635,13.299,16.722,28.507,20.862,44.91 C371.618,111.876,372.971,122.784,372.971,134.01z"></path> </g> <rect x="19.986" y="101.444" style="fill:#B9A078;" width="437.947" height="88.464"></rect> <path style="fill:#E1C9A1;" d="M477.919,215.947v270.015c0,14.331-11.625,26.038-26.038,26.038H26.038 c-0.478,0-1.035,0-1.513-0.082c-13.218-0.715-23.729-11.306-24.445-24.444C0,486.996,0,486.44,0,485.962V215.947 c0-14.413,11.625-26.038,26.038-26.038h425.844C466.294,189.908,477.919,201.534,477.919,215.947z"></path> <rect y="189.909" style="fill:#D7BD8D;" width="477.919" height="260.777"></rect> <polygon style="fill:#777064;" points="448.139,185.849 454.27,189.908 74.451,189.908 90.535,135.047 19.986,101.444 457.933,101.444 450.846,104.868 388.339,135.605 387.384,136.083 441.848,181.627 "></polygon> <g> <polygon style="fill:#56524D;" points="477.925,189.882 387.399,189.882 387.399,135.067 "></polygon> <polygon style="fill:#56524D;" points="90.535,135.047 90.535,189.908 0,189.908 19.986,177.805 "></polygon> </g> <g> <circle style="fill:#777064;" cx="123.144" cy="260.358" r="24.851"></circle> <circle style="fill:#777064;" cx="354.77" cy="260.358" r="24.851"></circle> </g> <g> <path style="fill:#F2E7D3;" d="M238.957,421.22c-73.901,0-134.023-60.122-134.023-134.023v-24.701 c0-10.057,8.153-18.21,18.21-18.21s18.21,8.153,18.21,18.21v24.701c0,53.819,43.784,97.603,97.603,97.603 s97.603-43.785,97.603-97.603v-24.701c0-10.057,8.153-18.21,18.21-18.21c10.057,0,18.21,8.153,18.21,18.21v24.701 C372.98,361.098,312.858,421.22,238.957,421.22z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.477 239.059,88.606 238.855,88.606 "></polygon> </g> <path style="opacity:0.07;fill:#040000;" d="M477.919,189.908v296.053c0,14.331-11.625,26.038-26.038,26.038H238.96V101.444 h91.889c-1.672-4.778-3.663-9.316-6.052-13.695c-0.08-0.08-0.08-0.159-0.08-0.239c-1.194-2.07-2.389-4.141-3.662-6.132 c-2.708-4.141-5.654-8.122-8.918-11.785c-1.672-1.831-3.345-3.662-5.096-5.334c-5.256-5.177-11.148-9.716-17.438-13.618 c-0.08,0-0.08-0.08-0.08-0.08c-2.15-1.194-4.22-2.387-6.45-3.503c-4.379-2.23-8.998-4.221-13.775-5.733 c-2.389-0.795-4.858-1.513-7.326-2.07c-2.389-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877 c-0.478-0.08-0.956-0.159-1.433-0.159c-2.23-0.157-4.539-0.239-6.848-0.239V0c1.991,0,3.902,0.08,5.813,0.159 c1.115,0,2.15,0.08,3.185,0.157c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556 c1.513,0.159,3.105,0.399,4.618,0.717c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448 c1.433,1.116,2.787,2.309,4.22,3.505c1.593,1.353,3.106,2.786,4.698,4.219c1.115,1.036,2.15,2.07,3.264,3.186 c2.548,2.626,4.937,5.255,7.326,8.042c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378 c9.476,13.379,16.562,28.587,20.703,44.91h89.102v76.283L477.919,189.908z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.478 238.855,88.606 238.957,88.606 238.957,88.542 "></polygon> <polygon style="fill:#777064;" points="238.957,88.542 238.957,88.606 239.059,88.606 "></polygon> </g> </g></svg>
                                            </div>
                                        @else
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-brand-medium">
                                                <svg class="w-7 h-7" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#2C6991;" d="M284.522,38.116h-56.465c-16.112,0-29.293,13.182-29.293,29.293v83.877h114.471V66.829 C313.235,50.971,300.38,38.116,284.522,38.116z"></path> <path style="fill:#528FB3;" d="M255.999,38.116h-27.943c-16.112,0-29.293,13.182-29.293,29.293v83.877h57.235V38.116z"></path> <path style="fill:#245475;" d="M461.206,155.372c-10.776,0-19.832,8.921-19.833,19.327H70.626c0-10.406-9.056-19.327-19.833-19.327 s-19.833,8.921-19.833,19.697v154.275c0,79.815,65.576,144.54,145.392,144.54h159.295c79.815,0,145.392-64.725,145.392-144.54 V175.069C481.038,164.293,471.982,155.372,461.206,155.372z"></path> <path style="fill:#2C6991;" d="M255.999,174.699H70.626c0-10.406-9.056-19.327-19.833-19.327s-19.833,8.921-19.833,19.697v154.275 c0,79.815,65.576,144.54,145.392,144.54h79.647V174.699H255.999z"></path> <path style="fill:#ABA8AB;" d="M475.553,162.024c-53.031-60.448-129.565-95.293-209.978-95.293h-19.149 c-80.414,0-156.948,34.845-209.978,95.293c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.977,10.112,11.364,17.774,11.364h409.771 c7.66,0,14.612-4.386,17.774-11.364C481.823,175.869,480.605,167.784,475.553,162.024z"></path> <path style="fill:#CCCCCC;" d="M255.999,66.732h-9.574c-80.414,0-156.948,34.845-209.978,95.293 c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.978,10.112,11.364,17.774,11.364h204.886V66.732H255.999z"></path> <path style="fill:#2C6991;" d="M492.488,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h472.976 c10.776,0,19.512-8.736,19.512-19.512S503.264,165.594,492.488,165.594z"></path> <path style="fill:#528FB3;" d="M255.999,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h236.487 V165.594z"></path> </g></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-heading truncate">{{$transaction->customer_name ?? 'Guest'}} <span class="status text-sm truncate {{ $class_color }} px-3 rounded-full">{{$transaction->status}}</span></p>
                                        <p class="text-sm text-body truncate">Order ID : #{{ $transaction->invoice_number }} - <span class="meja">{{$transaction->table && $transaction->table->name ? $transaction->table->name : "No Table"}}</span></p>
                                        <p class="text-sm text-body truncate">Date : {{date('d M Y, H:i:s', strtotime($transaction->created_at))}}</p>
                                    </div>
                                    <div class="inline-flex items-center space-x-1.5">    
                                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-brand-subtle text-brand rounded-full hover:bg-blue-400 hover:text-white cursor-pointer outline-0 inline-flex justify-center items-center see-transaction">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#1C274C" stroke-width="1.5"></path> </g></svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
                <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                   <ul role="list" class="divide-y divide-default">
                        @php
                            $transactions_active = $transactions->filter(function($elem) {
                                return $elem->status == 'paid';
                            });
                        @endphp
                        @foreach($transactions_active as $transaction)
                            @php
                                if($transaction->status == 'active') {
                                    $class_color = "bg-green-200 text-green-600";
                                } else if($transaction->status == 'process') {
                                    $class_color = "bg-brand-soft text-brand-light";
                                } else if($transaction->status == 'payment') {
                                    $class_color = "bg-yellow-200 text-yellow-600";
                                } else if($transaction->status == 'paid') {
                                    $class_color = "bg-red-200 text-red-600";
                                }
                            @endphp
                            <li class="pb-4 sm:pb-4"  data-uuid="{{ $transaction->uuid }}" data-status="{{ $transaction->status }}">
                                <div class="flex items-center gap-2 md:gap-5 flex-wrap">
                                    <div class="shrink-0">
                                        @if ($transaction->order_type == 'take_away')
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-warning-subtle">
                                                <svg class="w-7 h-7" version="1.1" id="_x34_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:none;" d="M239.059,88.606h-0.102v12.854h91.894c-13.453-37.827-49.51-65.029-91.894-65.029v52.111 L239.059,88.606z"></path> <path style="fill:none;" d="M147.063,101.46h91.894V88.606h-0.102v-0.128l0.102,0.064V36.431h0 C196.573,36.431,160.515,63.633,147.063,101.46z"></path> <g> <g> <g> <path style="fill:#F2E7D3;" d="M372.971,134.01v24.685c0,10.113-8.122,18.235-18.234,18.235 c-10.033,0-18.155-8.122-18.155-18.235V134.01c0-11.386-1.991-22.374-5.653-32.566c-1.672-4.699-3.663-9.316-6.131-13.695 c-0.08-0.08-0.08-0.159-0.08-0.239c-1.115-2.07-2.309-4.141-3.662-6.132c-2.628-4.141-5.654-8.122-8.918-11.785 c-1.593-1.911-3.265-3.662-5.096-5.334c-5.256-5.177-11.148-9.794-17.438-13.618c-0.08,0-0.08-0.08-0.08-0.08 c-2.15-1.273-4.3-2.469-6.45-3.503c-4.379-2.31-8.998-4.221-13.775-5.733c-2.389-0.795-4.858-1.513-7.326-2.07 c-2.468-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877c-0.478-0.08-0.956-0.159-1.433-0.159 c-2.23-0.157-4.539-0.239-6.848-0.239c-42.441,0-78.592,27.154-91.969,64.977c-3.663,10.193-5.653,21.18-5.653,32.566v24.685 c0,10.113-8.122,18.235-18.155,18.235c-10.112,0-18.234-8.122-18.234-18.235V134.01c0-11.227,1.354-22.135,3.981-32.566 C123.58,43.237,176.293,0,238.96,0c1.991,0,3.902,0.08,5.813,0.159c1.115,0,2.15,0.08,3.185,0.157 c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556c1.513,0.159,3.105,0.399,4.618,0.717 c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448c1.433,1.116,2.787,2.309,4.22,3.505 c1.593,1.353,3.106,2.786,4.698,4.219c1.115,0.956,2.229,2.07,3.264,3.186c2.628,2.549,5.096,5.255,7.326,8.042 c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378c9.635,13.299,16.722,28.507,20.862,44.91 C371.618,111.876,372.971,122.784,372.971,134.01z"></path> </g> <rect x="19.986" y="101.444" style="fill:#B9A078;" width="437.947" height="88.464"></rect> <path style="fill:#E1C9A1;" d="M477.919,215.947v270.015c0,14.331-11.625,26.038-26.038,26.038H26.038 c-0.478,0-1.035,0-1.513-0.082c-13.218-0.715-23.729-11.306-24.445-24.444C0,486.996,0,486.44,0,485.962V215.947 c0-14.413,11.625-26.038,26.038-26.038h425.844C466.294,189.908,477.919,201.534,477.919,215.947z"></path> <rect y="189.909" style="fill:#D7BD8D;" width="477.919" height="260.777"></rect> <polygon style="fill:#777064;" points="448.139,185.849 454.27,189.908 74.451,189.908 90.535,135.047 19.986,101.444 457.933,101.444 450.846,104.868 388.339,135.605 387.384,136.083 441.848,181.627 "></polygon> <g> <polygon style="fill:#56524D;" points="477.925,189.882 387.399,189.882 387.399,135.067 "></polygon> <polygon style="fill:#56524D;" points="90.535,135.047 90.535,189.908 0,189.908 19.986,177.805 "></polygon> </g> <g> <circle style="fill:#777064;" cx="123.144" cy="260.358" r="24.851"></circle> <circle style="fill:#777064;" cx="354.77" cy="260.358" r="24.851"></circle> </g> <g> <path style="fill:#F2E7D3;" d="M238.957,421.22c-73.901,0-134.023-60.122-134.023-134.023v-24.701 c0-10.057,8.153-18.21,18.21-18.21s18.21,8.153,18.21,18.21v24.701c0,53.819,43.784,97.603,97.603,97.603 s97.603-43.785,97.603-97.603v-24.701c0-10.057,8.153-18.21,18.21-18.21c10.057,0,18.21,8.153,18.21,18.21v24.701 C372.98,361.098,312.858,421.22,238.957,421.22z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.477 239.059,88.606 238.855,88.606 "></polygon> </g> <path style="opacity:0.07;fill:#040000;" d="M477.919,189.908v296.053c0,14.331-11.625,26.038-26.038,26.038H238.96V101.444 h91.889c-1.672-4.778-3.663-9.316-6.052-13.695c-0.08-0.08-0.08-0.159-0.08-0.239c-1.194-2.07-2.389-4.141-3.662-6.132 c-2.708-4.141-5.654-8.122-8.918-11.785c-1.672-1.831-3.345-3.662-5.096-5.334c-5.256-5.177-11.148-9.716-17.438-13.618 c-0.08,0-0.08-0.08-0.08-0.08c-2.15-1.194-4.22-2.387-6.45-3.503c-4.379-2.23-8.998-4.221-13.775-5.733 c-2.389-0.795-4.858-1.513-7.326-2.07c-2.389-0.638-4.937-1.116-7.485-1.512c-2.389-0.398-4.777-0.717-7.246-0.877 c-0.478-0.08-0.956-0.159-1.433-0.159c-2.23-0.157-4.539-0.239-6.848-0.239V0c1.991,0,3.902,0.08,5.813,0.159 c1.115,0,2.15,0.08,3.185,0.157c1.593,0.082,3.106,0.241,4.698,0.4c1.593,0.157,3.106,0.317,4.698,0.556 c1.513,0.159,3.105,0.399,4.618,0.717c18.633,3.264,35.912,10.352,51.121,20.465c3.026,2.068,5.972,4.219,8.839,6.448 c1.433,1.116,2.787,2.309,4.22,3.505c1.593,1.353,3.106,2.786,4.698,4.219c1.115,1.036,2.15,2.07,3.264,3.186 c2.548,2.626,4.937,5.255,7.326,8.042c1.114,1.433,2.309,2.865,3.424,4.3c1.115,1.433,2.15,2.865,3.264,4.378 c9.476,13.379,16.562,28.587,20.703,44.91h89.102v76.283L477.919,189.908z"></path> </g> <polygon style="fill:#777064;" points="238.855,88.478 238.855,88.606 238.957,88.606 238.957,88.542 "></polygon> <polygon style="fill:#777064;" points="238.957,88.542 238.957,88.606 239.059,88.606 "></polygon> </g> </g></svg>
                                            </div>
                                        @else
                                            <div class="w-13 h-13 rounded-full flex justify-center items-center bg-brand-medium">
                                                <svg class="w-7 h-7" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#2C6991;" d="M284.522,38.116h-56.465c-16.112,0-29.293,13.182-29.293,29.293v83.877h114.471V66.829 C313.235,50.971,300.38,38.116,284.522,38.116z"></path> <path style="fill:#528FB3;" d="M255.999,38.116h-27.943c-16.112,0-29.293,13.182-29.293,29.293v83.877h57.235V38.116z"></path> <path style="fill:#245475;" d="M461.206,155.372c-10.776,0-19.832,8.921-19.833,19.327H70.626c0-10.406-9.056-19.327-19.833-19.327 s-19.833,8.921-19.833,19.697v154.275c0,79.815,65.576,144.54,145.392,144.54h159.295c79.815,0,145.392-64.725,145.392-144.54 V175.069C481.038,164.293,471.982,155.372,461.206,155.372z"></path> <path style="fill:#2C6991;" d="M255.999,174.699H70.626c0-10.406-9.056-19.327-19.833-19.327s-19.833,8.921-19.833,19.697v154.275 c0,79.815,65.576,144.54,145.392,144.54h79.647V174.699H255.999z"></path> <path style="fill:#ABA8AB;" d="M475.553,162.024c-53.031-60.448-129.565-95.293-209.978-95.293h-19.149 c-80.414,0-156.948,34.845-209.978,95.293c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.977,10.112,11.364,17.774,11.364h409.771 c7.66,0,14.612-4.386,17.774-11.364C481.823,175.869,480.605,167.784,475.553,162.024z"></path> <path style="fill:#CCCCCC;" d="M255.999,66.732h-9.574c-80.414,0-156.948,34.845-209.978,95.293 c-5.052,5.76-6.267,13.844-3.106,20.822c3.161,6.978,10.112,11.364,17.774,11.364h204.886V66.732H255.999z"></path> <path style="fill:#2C6991;" d="M492.488,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h472.976 c10.776,0,19.512-8.736,19.512-19.512S503.264,165.594,492.488,165.594z"></path> <path style="fill:#528FB3;" d="M255.999,165.594H19.512C8.736,165.594,0,174.33,0,185.106s8.736,19.512,19.512,19.512h236.487 V165.594z"></path> </g></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-heading truncate">{{$transaction->customer_name ?? 'Guest'}} <span class="status text-sm truncate {{ $class_color }} px-3 rounded-full">{{$transaction->status}}</span></p>
                                        <p class="text-sm text-body truncate">Order ID : #{{ $transaction->invoice_number }} - <span class="meja">{{$transaction->table && $transaction->table->name ? $transaction->table->name : "No Table"}}</span></p>
                                        <p class="text-sm text-body truncate">Date : {{date('d M Y, H:i:s', strtotime($transaction->created_at))}}</p>
                                    </div>
                                    <div class="inline-flex items-center space-x-1.5">    
                                        <button type="button" class="text-sm w-9 h-9 ms-auto bg-brand-subtle text-brand rounded-full hover:bg-blue-400 hover:text-white cursor-pointer outline-0 inline-flex justify-center items-center see-transaction">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 4.45962C9.91153 4.16968 10.9104 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C3.75612 8.07914 4.32973 7.43025 5 6.82137" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="#1C274C" stroke-width="1.5"></path> </g></svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>
        <div id="modal-see-transaction" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full z-99">
            <div class="relative p-4 w-full max-w-xl max-h-[90%]">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-3 rounded-t text-start sm:text-center">
                        <h3 class="text-lg font-semibold text-dark-soft w-full">
                            Transaction Detail
                        </h3>
                        <div class="button-place flex gap-1">
                            <button type="button" class="text-sm w-9 h-9 ms-auto bg-success-subtle text-success rounded-full hover:bg-green-500 cursor-pointer outline-0 inline-flex justify-center items-center print-transaction-button">
                               <svg class="w-5 h-5" viewBox="0 -2 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000" transform="matrix(1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.064"></g><g id="SVGRepo_iconCarrier"> <title>print</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke-width="0.00032" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-100.000000, -205.000000)" fill="#000000"> <path d="M130,226 C130,227.104 129.104,228 128,228 L125.858,228 C125.413,226.278 123.862,225 122,225 L110,225 C108.138,225 106.587,226.278 106.142,228 L104,228 C102.896,228 102,227.104 102,226 L102,224 C102,222.896 102.896,222 104,222 L128,222 C129.104,222 130,222.896 130,224 L130,226 L130,226 Z M122,231 L110,231 C108.896,231 108,230.104 108,229 C108,227.896 108.896,227 110,227 L122,227 C123.104,227 124,227.896 124,229 C124,230.104 123.104,231 122,231 L122,231 Z M108,209 C108,207.896 108.896,207 110,207 L122,207 C123.104,207 124,207.896 124,209 L124,220 L108,220 L108,209 L108,209 Z M128,220 L126,220 L126,209 C126,206.791 124.209,205 122,205 L110,205 C107.791,205 106,206.791 106,209 L106,220 L104,220 C101.791,220 100,221.791 100,224 L100,226 C100,228.209 101.791,230 104,230 L106.142,230 C106.587,231.723 108.138,233 110,233 L122,233 C123.862,233 125.413,231.723 125.858,230 L128,230 C130.209,230 132,228.209 132,226 L132,224 C132,221.791 130.209,220 128,220 L128,220 Z" id="print" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                            </button>
                            <button type="button" class="text-sm w-9 h-9 ms-auto bg-brand-subtle text-brand rounded-full hover:bg-blue-400 cursor-pointer outline-0 inline-flex justify-center items-center delete-transaction-button">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.5001 6H3.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M18.8332 8.5L18.3732 15.3991C18.1962 18.054 18.1077 19.3815 17.2427 20.1907C16.3777 21 15.0473 21 12.3865 21H11.6132C8.95235 21 7.62195 21 6.75694 20.1907C5.89194 19.3815 5.80344 18.054 5.62644 15.3991L5.1665 8.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6" stroke="#1C274C" stroke-width="1.5"></path> </g></svg>
                            </button>
                            <button type="button" class="text-sm w-9 h-9 ms-auto bg-danger-subtle text-danger rounded-full hover:bg-red-300 cursor-pointer outline-0 inline-flex justify-center items-center tutup-modal-order">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                    </div>
                    <!-- Modal body -->
                    <div>
                        <div class="p-4 w-full">
                            <input type="hidden" name="uuid_transaction_detail" id="uuid_transaction_detail" />
                            <ul class="transaction-detail-list w-full h-[400px] overflow-y-auto">

                            </ul>
                            <div class="order-total-place w-full border-t border-gray-200 flex flex-wrap items-start">
                            <div class="flex justify-between items-center p-3 w-full">
                                <p class="text-gray-500 font-semibold">Subtotal</p>
                                <p class="text-lg font-bold transaction-detail-total-price">Rp 0</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script type="module">
        // options with default values
        const options = {
            placement: "center",
            backdrop: "dynamic",
            backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40",
            closable: true,
        };
        const modal = new Modal(document.getElementById('modal-see-transaction'),options);
        var ini;
        $('.see-transaction').on('click',function() {
            $('.transaction-detail-list').html('');
            var uuid = $(this).closest('li').data('uuid');
            var url = "{{ route('transaction.show',':id') }}";
            url = url.replace(':id',uuid);
            ini = this;
            loading();
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    if(data.success == true) {
                        var transaction = data.transaction;
                        $('#uuid_transaction_detail').val(transaction.uuid);

                        var product = data.product;

                        if(transaction.order_item.length > 0) {
                            var orderList = "";
                            var orderTotal = 0;
                            transaction.order_item.forEach(elem => {
                                var productItem = product.filter(prod => {
                                    return prod.uuid == elem.product_id;
                                })[0];
                                if(productItem != null) {
                                    if(productItem.picture != null && productItem.picture != "") {
                                        var image = "{{ asset('storage/products/:picture') }}";
                                        image = image.replace(':picture',productItem.picture);
                                    } else {
                                        var image = "{{ Vite::asset('resources/img/no_image_available.png') }}";
                                    }
                                    
                                    orderList += `
                                        <li class="flex relative w-full mb-2 border-b-2 border-dashed border-gray-300 p-3" data-uuid="${elem.uuid}">
                                            <div class="product-image h-20 w-20">
                                                <img class="h-20 w-20 object-cover rounded-lg" src="${image}">
                                            </div>
                                            <div class="product-detail ms-2">
                                                <p class="text-base text-gray-700">${productItem.name}</p>
                                                <p class="text-sm text-gray-500">Rp. ${addCommas(elem.subtotal)},-</p>
                                                <p class="text-sm text-gray-500 product-note">${elem.note ? elem.note : '-'}</p>
                                            </div>
                                            <div class="flex absolute bottom-1 right-1">
                                                ${elem.qty}x
                                            </div>
                                        </li>
                                    `;
                                    orderTotal += elem.subtotal;
                                } 
                                $('.transaction-detail-list').html(orderList);
                                $('.transaction-detail-total-price').html('Rp ' + addCommas(orderTotal));
                            }); 
                        }
                        modal.toggle();
                        removeLoading();

                        $('.tutup-modal-order').on('click',function() {
                            modal.hide();
                        });
                    }
                },error: function(data) {

                }
            });
        });
         //Print Check Order
        $('#modal-see-transaction').on('click','.print-transaction-button',function() {
            loading();
            var transactionId = $('#uuid_transaction_detail').val();
            var status = $(ini).closest('li').data('status');
            
            if(status == 'payment') {
                var url = "{{ route('transaction.print.check',':id') }}";
            } else if(status == 'paid') {
                var url = "{{ route('transaction.print.payment',':id') }}";
            } else {
                var url = "{{ route('transaction.print.check.noprice',':id') }}";
            }
            url = url.replace(':id',transactionId);
            $.ajax({
                method: 'GET',
                url: url,
                success: function(data) {
                    if(data.success == true) {
                        removeLoading();
                        oAlert('green','Success',data.message);
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                }
            });
        });
        $('#modal-see-transaction').on('click','.delete-transaction-button',function() {
            var transactionId = $('#uuid_transaction_detail').val();
            cConfirm("Warning","Are you sure want to delete this transaction?",function() {
                loading();
                var url = "{{ route('transaction.delete',':id') }}";
                url = url.replace(':id',transactionId);
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        location.reload();
                    },error: function(data) {
                        console.log(data.responseJSON.message); 
                    }
                });
            });
        })
    </script>

@endsection