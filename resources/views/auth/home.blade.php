@extends('layout.index')
@section('title','Point Of Sale')

@section('navbar')
    <div class="navbar-container flex items-center justify-between w-100% md:w-[calc(100%-450px)] lg:w-[calc(100%-550px)] gap-4">
        <div class="date-place inline-flex px-2 py-2 pe-4 bg-white rounded-full shadow items-center gap-3">
            <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-100"><i class="fas fa-calendar-days text-lg text-blue-400"></i></div>
            <span class="text-gray-600 font-medium">{{ date('D, d M Y') }}</span>
        </div>
    
    </div>
@endsection

@section('container')
    <div class="product-container w-full md:w-[calc(100%-350px)] lg:w-[calc(100%-450px)] p-3 relative">
        @if(session('success'))
            <div class="flex items-start sm:items-center p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft" role="alert">
                <i class="me-2 mt-0.5 sm:mt-0 fas fa-check"></i>
                <p><span class="font-medium me-1">Sukses!</span> {{session('success')}}</p>
            </div>
        @endif
        
        <div class="categories-list max-w-full overflow-x-auto" id="categories-list">
            <ul class="inline-flex gap-3 mb-5">
                <li class="group w-40">
                        <input type="radio" id="categories-all-item" name="category_filter" value="all-item" class="hidden peer category_filter" checked>
                        <label for="categories-all-item" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong ">                           
                            <div class="flex flex-wrap gap-2">
                                <div class="icon-place w-10 h-10 rounded-full bg-brand-subtle mb-1 flex items-center justify-center">
                                    <i class="fas fa-apple-whole text-body text-lg"></i>
                                </div>
                                <div class="text-place w-full">
                                    <p class="text-lg">All Items</p>
                                    <p class="">{{ $products->count() }} Items</p>
                                </div>
                            </div>
                        </label>
                    </li>
                @foreach ($categories as $category)
                    <li class="group w-40">
                        <input type="radio" id="categories-{{ $category->uuid }}" name="category_filter" value="{{ $category->uuid }}" class="hidden peer category_filter">
                        <label for="categories-{{ $category->uuid }}" class="inline-flex items-center justify-between w-full text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                            <div class="flex flex-wrap gap-2 relative p-3">
                                <div class="icon-place w-10 h-10 rounded-full bg-brand-subtle mb-1 flex items-center justify-center">
                                    <i class="fas {{ $category->icon }} text-body text-lg"></i>
                                </div>
                                <div class="text-place w-full">
                                    <p class="text-lg">{{$category->nama}}</p>
                                    <p class="">{{ $category->products()->count() }} Items</p>
                                </div>
                            </div>
                        </label>
                    </li>
                @endforeach
               
            </ul>
        </div>
        <div class="search-place w-full mb-5 relative">
            <div class="absolute inset-y-2 end-0 flex justify-center items-center w-10 h-10 bg-gray-200 rounded-full me-2 pointer-events-none">
                <svg class="w-5 h-5" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>search</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-256.000000, -1139.000000)" fill="#000000"> <path d="M269.46,1163.45 C263.17,1163.45 258.071,1158.44 258.071,1152.25 C258.071,1146.06 263.17,1141.04 269.46,1141.04 C275.75,1141.04 280.85,1146.06 280.85,1152.25 C280.85,1158.44 275.75,1163.45 269.46,1163.45 L269.46,1163.45 Z M287.688,1169.25 L279.429,1161.12 C281.591,1158.77 282.92,1155.67 282.92,1152.25 C282.92,1144.93 276.894,1139 269.46,1139 C262.026,1139 256,1144.93 256,1152.25 C256,1159.56 262.026,1165.49 269.46,1165.49 C272.672,1165.49 275.618,1164.38 277.932,1162.53 L286.224,1170.69 C286.629,1171.09 287.284,1171.09 287.688,1170.69 C288.093,1170.3 288.093,1169.65 287.688,1169.25 L287.688,1169.25 Z" id="search" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
            </div>
            <input type="text" class="bg-neutral-primary focus:bg-brand-softer w-full px-5 py-4 rounded-full border-0 outline-0 placeholder-gray-500" name="search" id="searchInput" placeholder="Search Something Delicious On Your Mind">
        </div>
        <div class="product-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-2 pb-32 md:pb-0">
            @foreach ($products as $product)
                <div class="col-span-1 {{ $product->is_active == 1 ? 'bg-white' : 'bg-slate-200' }} rounded-lg p-3 flex flex-wrap gap-3 cursor-pointer product-item" data-uuid="{{ $product->uuid }}" data-category="{{ $product->category_id }}">
                    <div class="img-place w-full h-30 rounded-base overflow-hidden">
                        <img src="{{ $product->picture == "" ? Vite::asset('resources/img/no_image_available.png') : asset('storage/products/'.$product->picture) }}" class="w-full h-full object-cover object-center" />
                    </div>
                    <div class="product-detail w-full">
                        <p class="name-product text-base mb-2">{{Str::limit($product->name,20,'...')}}</p>
                        <div class="product-price-detail flex gap-2 w-full justify-between items-center">
                            @php
                                $splitcolor = explode('-',$product->category->color);
                                $color = $splitcolor[1];
                            @endphp
                            <p class="categories-product {{ $product->category->color }} text-{{ $color }}-800 px-3 py-1 rounded-full text-[10px]">{{$product->category->nama}}</p>
                            <p class="price-product text-xl">Rp.{{ number_format($product->price,0,',') }},-</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div  class="order-list p-3 bg-white fixed bottom-0 left-0 w-full md:w-[calc(100%-350px)] lg:w-[calc(100%-450px)]">
            <div id="order-list" class="max-w-full overflow-x-auto" >
                <ul class="inline-flex gap-3" id="order">
                    <li class="order-item" id="order-item-button">
                        <button class="bg-neutral-50 border-2 text-gray-700 border-dashed border-gray-400 hover:bg-neutral-100 h-20 rounded-lg w-60 cursor-pointer add-order-button">Add Order</button>
                    </li>
                    @foreach ($transactions as $transaction)
                        <li class="order-item customer border border-gray-400 w-55 h-20 bg-primary border-primary hover:bg-brand-softer cursor-pointer rounded-lg p-3 relative" data-uuid="{{ $transaction->uuid }}">
                            <p class="order-name text-lg text-neutral-700 mb-2">{{$transaction->customer_name != null ? $transaction->customer_name : 'Guest'}}</p>
                            <div class="flex order-subdetail justify-between">
                                <p class="table-detail text-sm text-neutral-400"><span class="table-detail-place">{{ $transaction->table_id != null && $transaction->table ? $transaction->table->name : "Unset Table" }}</span> - <span class="order-type-detail">{{$transaction->order_type != null ? $transaction->order_type : ""}}</span></p>
                                <p class="time-detail text-sm text-neutral-400">{{date('H:i',strtotime($transaction->created_at))}}</p>
                            </div>
                            @php
                                if($transaction->status == 'active') {
                                    $class_color = "bg-green-200 text-green-600";
                                } else if($transaction->status == 'process') {
                                    $class_color = "bg-brand-soft text-brand-light";
                                } else if($transaction->status == 'payment') {
                                    $class_color = "bg-yellow-200 text-yellow-600";
                                }
                            @endphp
                            <p class="order-status {{ $class_color }} px-2 py-1 rounded-full text-xs absolute top-4 right-2">{{$transaction->status}}</p>
                        </li>
                    @endforeach
                    
                </ul>
            </div>
            
        </div>
        

        {{-- Modal Place --}}
        <div id="modal-preview-products" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-start w-full md:inset-0 h-full max-h-full z-99">
            <div class="relative p-4 w-full max-w-xl max-h-[90%]">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-3 rounded-t text-start sm:text-center">
                        <h3 class="text-lg font-semibold text-dark-soft w-full">
                            Detail Products
                        </h3>
                        <div class="button-place flex gap-1">
                            
                            <button type="button" class="text-sm w-9 h-9 ms-auto bg-danger-subtle text-danger rounded-full hover:bg-red-300 cursor-pointer outline-0 inline-flex justify-center items-center tutup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                    </div>
                    <!-- Modal body -->
                    <div>
                        <input type="hidden" name="uuid_product" id="uuid_product" />
                        <div class="picture-place flex align-center justify-center p-4 md:p-4 space-y-4">
                            <div class="w-full h-70 rounded-lg">
                                <img src="" class="picture_product w-full h-70 object-cover object-center rounded-lg" />
                            </div>
                        </div>
                        <div class="text-place w-full flex flex-wrap gap-2 p-4">
                            <p class="category-product px-3 py-1 rounded-full text-[10px]"></p>
                            <h5 class="product-name text-2xl w-full font-semibold text-dark-soft"></h5>
                            <p class="product-description text-dark-soft"></p> 
                            <p class="product-price text-brand-light font-bold text-2xl w-full"></p>   
                            <textarea id="descriptionOrder" class="description-order w-full border-0 bg-gray-50 placeholder-gray-400 bg-neutral outline-0 rounded-base focus:outline-brand focus:bg-brand-subtle" placeholder="Masukkan Catatan"></textarea>
                        </div>
                        <label for="quantity-input" class="block mb-2.5 ps-4 text-sm font-medium text-heading">Quantity:</label>
                        <div class="relative flex items-center w-full shadow-xs rounded-base ps-4 pe-4 pb-4">
                            <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium leading-5 rounded-s-base text-sm px-3 focus:outline-none h-10">
                                <svg class="w-4 h-4 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/></svg>
                            </button>
                            <input type="text" id="quantity-input" data-input-counter aria-describedby="helper-text-explanation" class="border-x-0 h-10 text-center w-full bg-neutral-secondary-medium border-default-medium py-2.5 placeholder-gray-400 focus:outline-0" placeholder="Qty" value="1" required />
                            <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium leading-5 rounded-e-base text-sm px-3 focus:outline-none h-10">
                                <svg class="w-4 h-4 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                            </button>
                        </div>
                        <button class="place-order-button bg-brand rounded-bl-lg rounded-br-lg text-neutral-50 hover:bg-brand-strong cursor-pointer w-full py-3">
                            Add To Cart <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <div id="modal-edit-transaction" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full z-99">
            <div class="relative p-4 w-full max-w-xl max-h-[90%]">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-3 rounded-t text-start sm:text-center">
                        <h3 class="text-lg font-semibold text-dark-soft w-full">
                            Transaction Detail
                        </h3>
                        <div class="button-place flex gap-1">
                            
                            <button type="button" class="text-sm w-9 h-9 ms-auto bg-danger-subtle text-danger rounded-full hover:bg-red-300 cursor-pointer outline-0 inline-flex justify-center items-center tutup-modal-transaction">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                    </div>
                    <!-- Modal body -->
                    <div>
                        <div class="grid grid-cols-1 p-4 w-full">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" class="w-full border border-gray-300 bg-gray-50 placeholder-gray-400 bg-neutral outline-0 rounded-base focus:outline-brand focus:bg-brand-subtle" placeholder="Write Down Customer Name" />
                            <div class="flex flex-wrap w-full gap-1 mt-2">
                                <button class="bg-brand w-full sm:w-auto text-white rounded-base px-4 py-2 mt-2 hover:bg-brand-strong cursor-pointer save-name-button">Save Name</button>
                                <button class="bg-danger w-full sm:w-auto text-white rounded-base px-4 py-2 mt-2 hover:bg-danger-strong cursor-pointer delete-transaction-button">Delete Transaction</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="modal-edit-order" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full z-99">
            <div class="relative p-4 w-full max-w-xl max-h-[90%]">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-3 md:p-3 rounded-t text-start sm:text-center">
                        <h3 class="text-lg font-semibold text-dark-soft w-full">
                            Order Detail
                        </h3>
                        <div class="button-place flex gap-1">
                            
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
                        <div class="grid grid-cols-1 p-4 w-full">
                            <input type="hidden" name="uuid_order" id="uuid_order" />
                            <label for="order_description">Order Notes</label>
                            <textarea name="order_description" id="order_description" class="w-full border border-gray-300 bg-gray-50 placeholder-gray-400 bg-neutral outline-0 rounded-base focus:outline-brand focus:bg-brand-subtle" placeholder="Write Down Order Notes"></textarea>
                            <div class="flex flex-wrap w-full gap-1 mt-2">
                                <button class="bg-brand w-full sm:w-auto text-white rounded-base px-4 py-2 mt-2 hover:bg-brand-strong cursor-pointer save-note-button">Save Notes</button>
                                <button class="bg-danger w-full sm:w-auto text-white rounded-base px-4 py-2 mt-2 hover:bg-danger-strong cursor-pointer delete-order-button">Delete Order</button>
                            </div>
                        </div>
                    </div>

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
                            <button type="button" class="text-sm w-9 h-9 ms-auto bg-warning-subtle text-warning rounded-full hover:bg-orange-300 cursor-pointer outline-0 inline-flex justify-center items-center edit-transaction-button">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M13.0207 5.82839L15.8491 2.99996L20.7988 7.94971L17.9704 10.7781M13.0207 5.82839L3.41405 15.435C3.22652 15.6225 3.12116 15.8769 3.12116 16.1421V20.6776H7.65669C7.92191 20.6776 8.17626 20.5723 8.3638 20.3847L17.9704 10.7781M13.0207 5.82839L17.9704 10.7781" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
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
                            <div class="process-to-payment w-full mt-2">
                                <button class="bg-brand text-neutral-50 hover:bg-brand-strong cursor-pointer w-full py-3 px-3 rounded-lg process-to-payment-button">Process To Payment</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="button-to-open-order">
        <button class="bg-brand text-neutral-50 hover:bg-brand-strong cursor-pointer w-16 h-16 rounded-tl-full rounded-bl-full fixed bottom-30 right-0 md:hidden flex justify-center items-center open-order-button open-close-order">
            <i class="fas fa-shopping-cart text-xl"></i>
        </button>
    </div>
    {{-- Order Place --}}
    
    <div class="order-container fixed top-0 right-0 w-[0px] md:w-[350px] lg:w-[450px] h-full bg-white shadow-lg md:block">
        <div class="order-form hidden">
            <input type="hidden" id="transaction-id" name="transaction-id" value="" />
            <div class="customer-name-place text-center px-2 py-4 w-full shadow-md relative">
                <p class="text-gray-500 m-0 text-lg font-semibold order-form-name">Guest</p>
                <p class="text-gray-400 text-base order-form-id">Order ID #001</p>
                <button id="edit_transaction_detail" class="absolute top-4 right-4 bg-gray-50 hover:bg-blue-500 group rounded-full p-3 cursor-pointer"><i class="fa-solid fa-pencil text-xl text-gray-500 group-hover:text-white"></i></button>
            </div>
            <div class="customer-detail-place p-2 w-full flex gap-3 shadow">
                <select type="select" id="meja" class="js-example-basic-single w-full bg-gray-50 rounded-full ps-6 pe-2 py-2 border border-gray-200 focus:border-blue-500 focus:ring-0 select2 text-sm" >
                    <option value="" disabled selected>Select Table</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->uuid }}">{{ $table->name }}</option>
                    @endforeach
                </select>
                <select type="select" id="orderType" class="js-example-basic-single w-full bg-gray-50 rounded-full ps-6 pe-2 py-2 border border-gray-200 focus:border-blue-500 focus:ring-0 select2 text-sm" >
                    <option value="" disabled selected>Select Type</option>
                    <option value="take_away">Take Away</option>
                    <option value="dine_in">Dine In</option>
                </select>
                
            </div>
            <div class="product-item-detail p-2 w-full h-[calc(100vh-180px)] max-h-full overflow-y-scroll">
                <ul class="product-item-list w-full">
                    
                </ul>
            </div>
            <div class="order-total-place w-full border-t border-gray-200 h-[140px] flex flex-wrap items-start">
                <div class="flex justify-between items-center p-3 w-full">
                    <p class="text-gray-500 font-semibold">Subtotal</p>
                    <p class="text-lg font-bold order-total-price">Rp 0</p>
                </div>
                <div class="flex w-full">
                    <button class="submit-order self-end bg-brand text-neutral-50 hover:bg-brand-strong cursor-pointer w-full py-3">Submit Order</button>
                </div>
            </div>
        </div>
        <div class="standby-form flex justify-center items-center">
            <img src="{{ Vite::asset('resources/img/start-order.png') }}" class="w-full h-auto" />
        </div>
    </div>
    <div id="printreceiptcheck" class="hidden">
        <!-- Content to be printed -->
        <h1 style="text-align: center; margin:0;padding:0" class="print-receipt">CHECK</h1>
        <h1 style="text-align: center; margin:0;padding:0" class="print-receipt" id="receipt-meja"></h1>
        <p style="text-align: center; margin:0;padding:0" class="print-receipt">=======================</p>
        <p style="margin:0;padding:0;font-size:10px" class="print-receipt">Date : <span id="receipt-date">{{ date('Y-m-d H:i:s') }}</span></p>
        <p style="text-align: center; margin:0;padding:0" class="print-receipt">--------------------------------------</p>
        <p style="margin:0;padding:0;font-size:10px" class="print-receipt">Invoice Number : <span id="receipt-invoice-number">INV0908993838</span></p>
        <p style="margin:0;padding:0;font-size:10px" class="print-receipt">Customer Name : <span id="receipt-customer-name">John Doe</span></p>
        <p style="margin:0;padding:0;font-size:10px" class="print-receipt">Order Type : <span id="receipt-order-type">Take Away</span></p>
        <p style="text-align: center; margin:0;padding:0" class="print-receipt">=======================</p>
        <div id="receipt-items">

        </div>
        <p style="page-break-after: auto !important"></p>

    </div>
    <script type="module">
        const osInstance = OverlayScrollbars(document.querySelector('#categories-list'), {});
        const osInstanc = OverlayScrollbars(document.querySelector('#order-list'), {});
        const osInstances = OverlayScrollbars(document.querySelector('.product-item-detail'), {});

        const $targetEl = document.getElementById("modal-preview-products");
        const $targetEditTransaction = document.getElementById("modal-edit-transaction");
        const $targetEditOrder = document.getElementById("modal-edit-order");
        // options with default values
        const options = {
            placement: "center",
            backdrop: "dynamic",
            backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40",
            closable: true,
        };
        const modal = new Modal($targetEl,options);
        const modal2 = new Modal($targetEditTransaction,options);
        const modal3 = new Modal($targetEditOrder,options);
        const modal4 = new Modal(document.getElementById('modal-see-transaction'),options);
        
        //Tutup buka Samping Orderan untuk layar kecil
        $('.open-close-order').on('click',function() {
            if($(this).hasClass('right-0')) {
                $(this).removeClass('right-0').addClass('right-[350px]');
                $('.order-container').addClass('w-[350px]').removeClass('w-[0px]');
            } else {
                $(this).removeClass('right-[350px]').addClass('right-0');
                $('.order-container').addClass('w-[0px]').removeClass('w-[350px]');
            }
        });

        // tombol buka modul
        $('.product-item').on('click',function(){

            //removeAllModalPreviousData
            $('.picture_product').attr('src','');
            $(".category-product").removeClass (function (index, className) {
                return (className.match (/(^|\s)bg-\S+/g) || []).join(' ');
            });
            $('.product-name').text('');
            $('.product-description').text('');
            $('.product-price').text('');
            $('#uuid_product').val('');
            $('#descriptionOrder').val('');
            $('#quantity-input').val(1);

            var uuid = $(this).data('uuid');
            var url = "{{ route('products.show',':id') }}";
            url = url.replace(':id',uuid);

            loading();
            $.ajax({
                type: "GET",
                url : url,
                success: function(data) {
                    
                    if(data.success === true) {
                        var product = data.product;
                        if(product.picture != "") {
                        var picture = "{{ asset('storage/products/:picture') }}";
                        picture = picture.replace(':picture',product.picture);
                        } else {
                            var picture = "{{ Vite::asset('resources/img/no_image_available.png') }}";
                        }
                        $('.picture_product').attr('src',picture);
                        
                        // Categories-setting
                        var categoriesName = product.category.nama;
                        var categoriesColor = product.category.color;
                        $('.category-product').text(categoriesName);
                        $('.category-product').addClass(categoriesColor);

                        //Detail Products
                        $('.product-name').text(product.name);
                        $('.product-description').text(product.description);
                        var price = "Rp."+addCommas(product.price)+",-";
                        $('.product-price').text(price);
                        $('#uuid_product').val(product.uuid);
                        
                        

                        //open Modal
                        removeLoading();
                        
                        modal.toggle();

                        $('.tutup-modal').on('click',function() {
                            modal.hide();
                        });
                    }
                }
            });
        });
        // tombol tambah list barang
        $('.place-order-button').on('click',function() {
            var idOrder = $('#transaction-id').val();
            var qty = $('#quantity-input').val();

            if(idOrder == "") {
                oAlert("orange","Warning","There is no active transaction");
            } else if (qty == "" || qty == 0) {
                oAlert("orange","Warning","Jumlah Barang tidak boleh kosong");
            } else {
                loading();
                var url = "{{ route('transaction.order.create',':id') }}";
                url = url.replace(':id',idOrder);
                var dataItem = $('#uuid_product').val();
                var deskripsiOrder = $('#descriptionOrder').val();
                $.ajax({
                    type: "POST",
                    url : url,
                    data : {'idProduct' : dataItem,'description' : deskripsiOrder,
                    'qty' : qty},
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success : function(data) {
                        removeLoading();
                        var orderItem = data.orderItem;
                        var productItem = data.product;
                        
                        if(productItem != null) {
                            if(productItem.picture != null && productItem.picture != "") {
                                var image = "{{ asset('storage/products/:picture') }}";
                                image = image.replace(':picture',productItem.picture);
                            } else {
                                var image = "{{ Vite::asset('resources/img/no_image_available.png') }}";
                            }
                            
                            var orderList = `
                                <li class="flex relative w-full mb-2 border-b-2 border-dashed border-gray-300 p-3" data-uuid="${orderItem.uuid}">
                                    <div class="product-image h-20 w-20">
                                        <img class="h-20 w-20 object-cover rounded-lg" src="${image}">
                                    </div>
                                    <div class="product-detail ms-2">
                                        <p class="text-base text-gray-700">${productItem.name}</p>
                                        <p class="text-sm text-gray-500">Rp. ${addCommas(orderItem.subtotal)},-</p>
                                        <p class="text-sm text-gray-500 product-note">${orderItem.note ? orderItem.note : '-'}</p>
                                        <button class="rounded-full bg-gray-100 p-1 text-gray-700 cursor-pointer text-sm hover:bg-brand-light hover:text-white edit-product-order"><i class="fas fa-pencil"></i></button>
                                    </div>
                                    <div class="flex items-center absolute bottom-1 right-1">
                                        <button type="button" id="decrement-button" data-input-counter-decrement="counter-input-${orderItem.uuid}" class="decrement-qty flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                            <svg class="w-3 h-3 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/></svg>
                                        </button>
                                        <input type="text" id="counter-input-${orderItem.uuid}" data-input-counter class="input-qty shrink-0 text-heading border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" value="${orderItem.qty}"/>

                                        <button type="button" id="increment-button-${orderItem.uuid}" data-input-counter-increment="counter-input" class="increment-qty flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                            <svg class="w-3 h-3 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                                        </button>
                                    </div>
                                </li>
                            `;
                        }
                        var newTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,'')) + parseInt(orderItem.subtotal);
                        $('.order-total-price').text("Rp. "+addCommas(newTotal)+",-"); 
                        $('.product-item-list').append(orderList);
                        modal.hide();
                    },
                    error: function(data) {
                        console.log(data.responseJSON.message);
                    }
                })
            }
        });
        // tombol filter per categori
        $('.category_filter').on('click',function() {
            var uuid = $(this).val();

            if(uuid == 'all-item') {
                $('.product-item').removeClass('hidden');
            } else {
                $('.product-item').filter(function(){
                    return $(this).data('category') != uuid    
                }).addClass('hidden');
                $('.product-item').filter(function(){
                    return $(this).data('category') == uuid    
                }).removeClass('hidden');
            }
        });
        // tombol mencari
        $('#searchInput').on('keyup',function() {
            var value = this.value.toLowerCase().trim();
            var selected_filter = $('input[name="category_filter"]:checked').val();
            if(selected_filter == 'all-item') {
                $(".product-item").removeClass('hidden').filter(function() {
                    return $(this).find('.name-product').text().toLowerCase().trim().indexOf(value) == -1;
                }).addClass('hidden');
            } else {
                $(".product-item[data-category='"+selected_filter+"']").removeClass('hidden').filter(function() {
                    return $(this).find('.name-product').text().toLowerCase().trim().indexOf(value) == -1;
                }).addClass('hidden');
            }
            // console.log('a');
        });
        // Tombol tambah order
        $('.add-order-button').on('click',function() {
            loading();
            $.ajax({
                type: "POST",
                url: "{{ route('transaction.create') }}",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    $('.order-form').removeClass('hidden');
                    $('.standby-form').addClass('hidden');
                    var transaction = data.transaction;
                    var name = transaction.customer_name ? transaction.customer_name : "Guest";
                    var table = transaction.table && transaction.table.name ? transaction.table.name : "Unset Table";
                    var orderType = transaction.order_type ? transaction.order_type : "";
                    var time = moment(transaction.created_at).format('HH:mm');
                    var status = transaction.status;
                    $('#transaction-id').val(transaction.uuid);
                    $('.order-form-id').text("Order ID #"+transaction.invoice_number);
                    $('#meja').val("");
                    $('#orderType').val("");
                    $('.product-item-list').html('');
                    var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
                    var newTotal = 0;
                    $('.order-total-price').text("Rp. "+addCommas(newTotal));
                    $('#order .customer').removeClass('bg-brand-soft');
                    var orderListItem = `
                        <li class="order-item customer border border-gray-400 w-55 h-20 bg-brand-soft hover:bg-brand-softer cursor-pointer rounded-lg p-3 relative" data-uuid="${data.transaction.uuid}">
                            <p class="order-name text-lg text-neutral-700 mb-2">${name}</p>
                            <div class="flex order-subdetail justify-between">
                                <p class="table-detail text-sm text-neutral-400"><span class="table-detail-place">${table}</span> - <span class="order-type-detail">${orderType}</span></p>
                                <p class="time-detail text-sm text-neutral-400">${time}</p>
                            </div>
                            <p class="order-status bg-green-200 text-green-600 px-2 py-1 rounded-full text-xs absolute top-4 right-2">${status}</p>
                        </li>
                    `;
                    $('#order-item-button').after(orderListItem);
                    removeLoading();

                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                }

            });
        });
        // tombol melihat kembali order lama
        $('#order').on('click','.customer',function() {
            $('#meja').val("");
            $('#orderType').val("");
            $('.product-item-list').html('');
            $('#order .customer').removeClass('bg-brand-soft');
            $(this).addClass('bg-brand-soft');
            var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
            var newTotal = 0;
            $('.order-total-price').text("Rp. "+addCommas(newTotal));
            $('#uuid_transaction_detail').val('');


            var uuid = $(this).data('uuid');
            var url = "{{ route('transaction.show',':id') }}";
            url = url.replace(':id',uuid);
            loading();
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    if(data.success == true) {
                        if(data.transaction.status == 'process') {
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
                            modal4.toggle();
                            removeLoading();

                            $('.tutup-modal-order').on('click',function() {
                                modal4.hide();
                            });
                        } else if(data.transaction.status == "payment") {
                            var newRoute = "{{ route('transaction.payment',':id') }}";
                            newRoute = newRoute.replace(':id',data.transaction.uuid);
                            window.location.href = newRoute;
                        } else {
                            var transaction = data.transaction;
                            $('#transaction-id').val(transaction.uuid);
                            $('.order-form-name').text(transaction.customer_name ? transaction.customer_name : "Guest" );
                            $('#meja').val(transaction.table ? transaction.table.uuid : "");
                            $('#orderType').val(transaction.order_type ? transaction.order_type : "");
                            $('.order-form-id').text("Order ID #"+transaction.invoice_number);
                            $('.order-form').removeClass('hidden');
                            $('.standby-form').addClass('hidden');
                            
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
                                                    <button class="rounded-full bg-gray-100 p-1 text-gray-700 cursor-pointer text-sm hover:bg-brand-light hover:text-white edit-product-order"><i class="fas fa-pencil"></i></button>
                                                </div>
                                                <div class="flex items-center absolute bottom-1 right-1">
                                                    <button type="button" id="decrement-button" data-input-counter-decrement="counter-input-${elem.uuid}" class="decrement-qty flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                        <svg class="w-3 h-3 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/></svg>
                                                    </button>
                                                    <input type="text" id="counter-input-${elem.uuid}" data-input-counter class="input-qty shrink-0 text-heading border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" value="${elem.qty}"/>

                                                    <button type="button" id="increment-button-${elem.uuid}" data-input-counter-increment="counter-input" class="increment-qty flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                        <svg class="w-3 h-3 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                                                    </button>
                                                </div>
                                            </li>
                                        `;
                                        orderTotal += elem.subtotal;
                                    } 
                                    $('.product-item-list').html(orderList);
                                    $('.order-total-price').html('Rp ' + addCommas(orderTotal));
                                }); 
                            }
                            removeLoading();
                        }
                        
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                } 
            });
        });
        //Print Check Order
        $('#modal-see-transaction').on('click','.print-transaction-button',function() {
            loading();
            var transactionId = $('#uuid_transaction_detail').val();
            var url = "{{ route('transaction.print.check.noprice',':id') }}";
            url = url.replace(':id',transactionId);
            $.ajax({
                method: 'GET',
                url: url,
                success: function(data) {
                    if(data.success == true) {
                        var transaction = data.transaction;
                        console.log(transaction);
                        $('#receipt-meja').text(transaction.table && transaction.table.name ? transaction.table.name : '');
                        $('#receipt-invoice-number').text(transaction.invoice_number);
                        $('#receipt-customer-name').text(transaction.customer_name || 'Guest');
                        $('#receipt-order-type').text(transaction.order_type ? transaction.order_type.replace('_',' ').toUpperCase() : '');
                        $('#receipt-date').text(transaction.created_at || '{{ date('Y-m-d H:i:s') }}');
                        $('#receipt-items').empty();
                        var product = data.transaction.order_item;
                        var productList = "";
                        if(transaction.order_item.length > 0) {
                            transaction.order_item.forEach(elem => {
                                var item = `
                                    <p style="margin:0;padding:0;font-size:10px" class="print-receipt">${elem.product_name || ''}</p>
                                    <div style="margin:0; margin-top: -10px; padding: 0; font-size: 10px; display: flex; justify-content: space-between;" class="print-receipt">
                                        <p class="item-note" style="font-style: italic">Note: ${elem.note ? elem.note : '-'}</p>
                                        <p class="item-qty">${elem.qty}x</p>
                                    </div>
                                `;
                                productList += item;
                            });
                            $('#receipt-items').html(productList);
                        }

                        removeLoading();
                        var divContents = $("#printreceiptcheck").html();
                        var printWindow = window.open('', '', 'height=400,width=384');
                        printWindow.document.write('<html><head><title>DIV Contents</title>');
                        printWindow.document.write('</head><body >');
                        printWindow.document.write(divContents);
                        printWindow.document.write('</body></html>');
                        printWindow.print();
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                }
            });
        });
        $('#modal-see-transaction').on('click','.edit-transaction-button',function() {
            modal4.hide();
            var transactionId = $('#uuid_transaction_detail').val();
            var url = "{{ route('transaction.update',':id') }}";
            url = url.replace(':id',transactionId);
            loading();
            $.ajax({
                method: 'POST',
                url: url,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    var transaction = data.transaction;
                    $('#transaction-id').val(transaction.uuid);
                    $('.order-form-name').text(transaction.customer_name ? transaction.customer_name : "Guest" );
                    $('#meja').val(transaction.table ? transaction.table.uuid : "");
                    $('#orderType').val(transaction.order_type ? transaction.order_type : "");
                    $('.order-form-id').text("Order ID #"+transaction.invoice_number);
                    $('.order-form').removeClass('hidden');
                    $('.standby-form').addClass('hidden');
                    
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
                                            <button class="rounded-full bg-gray-100 p-1 text-gray-700 cursor-pointer text-sm hover:bg-brand-light hover:text-white edit-product-order"><i class="fas fa-pencil"></i></button>
                                        </div>
                                        <div class="flex items-center absolute bottom-1 right-1">
                                            <button type="button" id="decrement-button" data-input-counter-decrement="counter-input-${elem.uuid}" class="decrement-qty flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                <svg class="w-3 h-3 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/></svg>
                                            </button>
                                            <input type="text" id="counter-input-${elem.uuid}" data-input-counter class="input-qty shrink-0 text-heading border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" value="${elem.qty}"/>

                                            <button type="button" id="increment-button-${elem.uuid}" data-input-counter-increment="counter-input" class="increment-qty flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary rounded-full text-sm focus:outline-none h-6 w-6">
                                                <svg class="w-3 h-3 text-heading" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                                            </button>
                                        </div>
                                    </li>
                                `;
                                orderTotal += elem.subtotal;
                            } 
                            $('.product-item-list').html(orderList);
                            $('.order-total-price').html('Rp ' + addCommas(orderTotal));
                        }); 
                    }
                    removeLoading();
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
                        removeLoading();
                        $('#transaction-id').val("");
                        $('#uuid_transaction_detail').val("");
                        $('.order-form').addClass('hidden');
                        $('.standby-form').removeClass('hidden');
                        $('.order-item.customer[data-uuid='+transactionId+']').remove();
                        modal4.hide();
                    },error: function(data) {
                        console.log(data.responseJSON.message); 
                    }
                });
            });
        })
                        
        //Kurangin jumlah order
        $('.product-item-list').on('click','.decrement-qty',function() {
            var inputval = $(this).closest('li').find('.input-qty').val();
            var idProduct = $(this).closest('li').data('uuid');
            var ini = this;
            loading();
            var url = "{{ route('transaction.order.decrement',':id') }}";
            url = url.replace(':id',idProduct);
            $.ajax({
                type:"POST",
                url: url,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    removeLoading();
                    var orderItem = data.orderItem;
                    if(orderItem == null) {
                        $(ini).closest('li').remove();
                        var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
                        var newTotal = currentTotal - parseInt(data.product.price);
                        $('.order-total-price').text("Rp. "+addCommas(newTotal));
                    } else {
                        if(orderItem.qty >= 1) {
                            $(ini).closest('li').find('.input-qty').val(orderItem.qty);
                            $(ini).closest('li').find('.product-detail p:nth-child(2)').text("Rp. "+addCommas(orderItem.subtotal)+",-");
                            var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
                            var newTotal = currentTotal - parseInt(data.product.price);
                            $('.order-total-price').text("Rp. "+addCommas(newTotal));
                        }
                    }
                },
            })
            
            // if(inputval >= 1) {
            //     $(this).closest('li').find('.input-qty').val(parseInt(inputval) - 1);
            // }
        });
        //Tambahkan jumlah Order
        $('.product-item-list').on('click','.increment-qty',function() {
            var inputval = $(this).closest('li').find('.input-qty').val();
            var idProduct = $(this).closest('li').data('uuid');
            var ini = this;
            loading();
            var url = "{{ route('transaction.order.increment',':id') }}";
            url = url.replace(':id',idProduct);
            $.ajax({
                type:"POST",
                url: url,
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    removeLoading();
                    var orderItem = data.orderItem;
                    $(ini).closest('li').find('.input-qty').val(orderItem.qty);
                    $(ini).closest('li').find('.product-detail p:nth-child(2)').text("Rp. "+addCommas(orderItem.subtotal)+",-");
                    var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
                    var newTotal = currentTotal + parseInt(data.product.price);
                    $('.order-total-price').text("Rp. "+addCommas(newTotal));
                },
            })
        });
        //Ganti Jumlah Order Manual
        var oldVal = 0;
        $('.product-item-list').on('focus','.input-qty',function() {
            oldVal = $(this).val();
        });
        $('.product-item-list').on('change','.input-qty',function() {
            var inputval = $(this).val();
            var idProduct = $(this).closest('li').data('uuid');
            var ini = this;
            if(inputval >= 1) {
                loading();
                var url = "{{ route('transaction.order.changeQty',':id') }}";
                url = url.replace(':id',idProduct);
                $.ajax({
                    type:"POST",
                    url: url,
                    data: {'qty' : inputval},
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        removeLoading();
                        var orderItem = data.orderItem;
                        $(ini).closest('li').find('.input-qty').val(orderItem.qty);
                        $(ini).closest('li').find('.product-detail p:nth-child(2)').text("Rp. "+addCommas(orderItem.subtotal)+",-");
                        
                        // Update Total
                        var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
                        var newTotal = currentTotal + (parseInt(orderItem.subtotal) - parseInt(data.oldSubtotal));
                        $('.order-total-price').text("Rp. "+addCommas(newTotal));
                    },
                })
            } else {
                oAlert("orange","Warning","Quantity must be at least 1");
                $(this).val(oldVal);
            }
        });
        //Edit Note Order
        $('.product-item-list').on('click','.edit-product-order',function() {
            $('#uuid_order').val('');
            var orderId = $(this).closest('li').data('uuid');
            var url = "{{ route('transaction.order.getNote',':id') }}";
            var ini = this;
            url = url.replace(':id',orderId);
            loading();
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    $('#uuid_order').val(orderId);
                    var note = data.note ? data.note : "";
                    $('#order_description').val(note);
                    modal3.toggle();
                    removeLoading();
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                }
            });

            $('.tutup-modal-order').on('click',function() {
                modal3.hide();
            });
        });
        $('.save-note-button').on('click',function() {
            var note = $('#order_description').val();
            var orderID = $('#uuid_order').val();
            loading();
            var url = "{{ route('transaction.order.changeNote',':id') }}";
            url = url.replace(':id',$('#uuid_order').val());
            $.ajax({
                type: "POST",
                url: url,
                data: {'note' : note},
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    $('li[data-uuid="'+orderID+'"]').find('.product-note').text(note ? note : '-').promise().then(function() {
                        modal3.hide();
                        removeLoading();
                    });
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                }
            })
        });
        //Hapus Orderan
        $('.delete-order-button').on('click',function() {
            var orderID = $('#uuid_order').val();
            cConfirm("Warning","Are you sure want to delete this order?",function() {
                loading();
                var url = "{{ route('transaction.order.delete',':id') }}";
                url = url.replace(':id',orderID);
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        var currentTotal = parseInt($('.order-total-price').text().replace(/[^0-9]/g,''));
                        var newTotal = currentTotal - parseInt(data.subtotal);
                        $('.order-total-price').text("Rp. "+addCommas(newTotal));
                        $('li[data-uuid="'+orderID+'"]').remove();
                        modal3.hide();
                        removeLoading();
                    },
                    error: function(data) {
                        console.log(data.responseJSON.message);
                    }
                })
            });
        });
        //Ganti No Meja
        $('.customer-detail-place').on('change','#meja',function() {
            var idTable = $(this).val();
            var idTransaction = $('#transaction-id').val();
            loading();
            var url = "{{ route('transaction.order.changeTable',':id') }}";
            url = url.replace(':id',idTransaction);
            $.ajax({
                type: "POST",
                url: url,
                data: {'table_id' : idTable},
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    removeLoading();
                    var tableName = data.orderItem.table ? data.orderItem.table.name : "Unset Table";
                    $('.order-item.customer[data-uuid='+idTransaction+']').find('.table-detail-place').text(tableName);
                },error: function(data) {
                    console.log(data.responseJSON.message);
                }
            })
        });
        //Ganti Tipe Order
        $('.customer-detail-place').on('change','#orderType',function() {
            var order = $(this).val();
            var idTransaction = $('#transaction-id').val();
            loading();
            var url = "{{ route('transaction.order.changeOrderType',':id') }}";
            url = url.replace(':id',idTransaction);
            $.ajax({
                type: "POST",
                url: url,
                data: {'order' : order},
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    removeLoading();
                    $('.order-item.customer[data-uuid='+idTransaction+']').find('.order-type-detail').text(order);
                },error: function(data) {
                    console.log(data.responseJSON.message);
                }
            })
        });
        //edit Detail Transaksi
        $('#edit_transaction_detail').on('click',function() {
            var id = $('#transaction-id').val();
            var url = "{{ route('transaction.show',':id') }}";
            url = url.replace(':id',id);
            loading();
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    removeLoading();
                    if(data.success == true) {
                        var transaction = data.transaction;
                        $('#customer_name').val(transaction.customer_name);
                        $('#transaction-detail-name-place').val(transaction.customer_name);
                        modal2.toggle();
                    }
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                }
            });

            $('.save-name-button').on('click',function() {
                var name = $('#customer_name').val();
                var idTransaction = $('#transaction-id').val();
                loading();
                var url = "{{ route('transaction.order.changeName',':id') }}";
                url = url.replace(':id',idTransaction);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'name' : name},
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        removeLoading();
                        $('.order-form-name').text(name ? name : "Guest");
                        $('.order-item.customer[data-uuid='+idTransaction+']').find('.order-name').text(name ? name : "Guest");
                        modal2.hide();
                    },error: function(data) {
                        console.log(data.responseJSON.message);
                    }
                });
            });

            $('.delete-transaction-button').on('click',function() {
                var idTransaction = $('#transaction-id').val();
                cConfirm("Warning","Are you sure want to delete this transaction?",function() {
                    loading();
                    var url = "{{ route('transaction.delete',':id') }}";
                    url = url.replace(':id',idTransaction);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        success: function(data) {
                            removeLoading();
                            $('#transaction-id').val("");
                            $('.order-form').addClass('hidden');
                            $('.standby-form').removeClass('hidden');
                            $('.order-item.customer[data-uuid='+idTransaction+']').remove();
                            modal2.hide();
                        },error: function(data) {
                            console.log(data.responseJSON.message); 
                        }
                    });
                });
            });
            
            $('.tutup-modal-transaction').on('click',function() {
                modal2.hide();
            });
        });
        //Submit Orderan
        $('.submit-order').on('click',function() {
            var idTransaction = $('#transaction-id').val();
            cConfirm("Confirmation","Are you sure want to submit this order?",function() {
                loading();
                var url = "{{ route('transaction.submit',':id') }}";
                url = url.replace(':id',idTransaction);
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        if(data.success == true) {   
                            removeLoading();
                            $('.order-item.customer[data-uuid='+idTransaction+']').find('.order-status').text("Process").removeClass('bg-green-200 text-green-600').addClass('bg-brand-soft text-brand-light');
                            $('.order-item.customer[data-uuid='+idTransaction+']').removeClass('bg-brand-soft');
                            $('#transaction-id').val("");
                            $('.order-form').addClass('hidden');
                            $('.standby-form').removeClass('hidden');
                        } else {
                            removeLoading();
                            oAlert("red","Error",data.message);
                        }
                    },
                    error: function(data) {
                        console.log(data.responseJSON.message); 
                    }
                });
            });
        });

        //Selesaikan Orderan dan Proses ke pembayaran
        $('.process-to-payment-button').on('click',function() {
            var uuid = $('#uuid_transaction_detail').val();

            cConfirm("Confirmation","Are you sure to process this transaction to payment ?",function() {
                loading();
                var url = "{{ route('transaction.payment.proceed',':id') }}";
                url = url.replace(':id',uuid);
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(data) {
                        if(data.success == true) {
                            var newRoute = "{{ route('transaction.payment',':id') }}";
                            newRoute = newRoute.replace(':id',data.transaction.uuid);
                            window.location.href = newRoute;
                            removeLoading();
                        }
                    },
                    error: function(data) {
                        console.log(data.responseJSON.message);
                    }
                });
            })
        });
    </script>
@endsection