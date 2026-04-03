@extends('layout.index')
@section('title','Settings')

@section('navbar')
    <div class="navbar-container flex items-center justify-between w-full gap-4 pe-6">
        <h1 class="text-lg md:text-3xl font-bold">SETTINGS</h1>
        <div class="date-place hidden md:inline-flex px-2 py-2 pe-4 bg-white rounded-full shadow items-center gap-3">
            <div class="menu-icon rounded-full h-12 w-12 flex items-center justify-center bg-gray-100"><i class="fas fa-calendar-days text-lg text-blue-400"></i></div>
            <span class="text-gray-600 font-medium">{{ date('D, d M Y') }}</span>
        </div>
    </div>
@endsection

@section('container')
    <div class="container-place w-full p-6 flex gap-2 flex-wrap flex-col">
        <div class="p-4 bg-white rounded-lg grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-3">
                <p class="text-lg font-bold">Setting Restaurant</p>
                <p class="text-sm">Restaurant Configuration</p>
            </div>
            @if(session('success_restaurant'))
            <div class="col-span-1 md:col-span-2 flex items-start sm:items-center p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft" role="alert">
                <i class="me-2 mt-0.5 sm:mt-0 fas fa-check"></i>
                <p><span class="font-medium me-1">Sukses!</span> {{session('success_restaurant')}}</p>
            </div>
            @endif
            <div class="col-span-1">
                @php
                    $settingrestaurant = $settings->first(function($item) {
                        return $item->jenis == 'restaurant_settings';
                    });
                    $settingrestaurantlogo = $settings->first(function($item) {
                        return $item->jenis == 'restaurant_logo';
                    });

                    if($settingrestaurant && $settingrestaurant->nilai) {
                        $settingResArray = unserialize($settingrestaurant->nilai);
                    } else {
                        $settingResArray = array();
                    }
                @endphp
                <form method="POST" action="{{ route('settings.restaurant.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group flex-col w-full">
                        <label for="restaurant_name">Restaurant Name</label>
                        <input type="text" name="restaurant_name" id="restaurant_name" placeholder="Input Restaurant Name" class="w-full px-5 py-3 rounded focus:outline-none  @error('restaurant_name') focus:border-danger-subtle bg-danger-soft focus:bg-danger-medium placeholder-danger-strong border-danger @else focus:border-brand-subtle bg-neutral-primary-soft focus:bg-brand-softer placeholder-gray-500 border border-default @enderror" value="{{ old('restaurant_name',$settingResArray && $settingResArray['name'] ? $settingResArray['name'] : '') }}" />
                        @error('restaurant_name')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group flex-col w-full">
                        <label for="restaurant_location">Restaurant Location</label>
                        <input type="text" name="restaurant_location" id="restaurant_location" placeholder="Input Restaurant Location" class="w-full px-5 py-3 rounded focus:outline-none  @error('restaurant_location') focus:border-danger-subtle bg-danger-soft focus:bg-danger-medium placeholder-danger-strong border-danger @else focus:border-brand-subtle bg-neutral-primary-soft focus:bg-brand-softer placeholder-gray-500 border border-default @enderror" value="{{ old('restaurant_location',$settingResArray && $settingResArray['location'] ? $settingResArray['location'] : '') }}" />
                        @error('restaurant_location')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group flex-col w-full">
                        <input type="hidden" value="0" name="is_changed" id="is_changed" />
                        <label for="picture" class="text-sm font-medium text-gray-700 mb-1 block">Restaurant Logo</label>
                        <div class="flex items-center justify-center w-full uploaded-place {{$settingrestaurantlogo && $settingrestaurantlogo->nilai ? 'hidden' : ''}}">
                            <label for="picture" class="flex flex-col items-center justify-center w-full h-64 bg-neutral-secondary-medium border border-dashed border-default-strong rounded-base cursor-pointer hover:bg-neutral-tertiary-medium">
                                <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2"/></svg>
                                    <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs">PNG, JPG or GIF (MAX : 2MB )</p>
                                </div>
                                <input id="picture" name="picture" type="file" class="hidden" />
                            </label>
                        </div> 
                        <div class="preview-place flex border border-gray-200 rounded-lg w-full sm:w-100 relative {{$settingrestaurantlogo && $settingrestaurantlogo->nilai ? '' : 'hidden'}} ">
                            <button type="button" class="absolute flex justify-center top-1 right-2 text-3xl delete-image cursor-pointer w-10 h-10 bg-neutral-primary hover:bg-brand-light hover:text-neutral-primary shadow-lg rounded-full">
                                &times;
                            </button>
                            <div class="image-place w-full sm:w-100 h-50">
                                <img src="{{ $settingrestaurantlogo && $settingrestaurantlogo->nilai ? asset('storage/'.$settingrestaurantlogo->nilai) : '' }}" class="w-full h-50 object-contain" id="image-preview" alt="Preview Image Uploaded" />
                            </div>
                        </div>
                        @error('picture')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-brand text-white py-2 px-4 rounded hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-opacity-50 mt-3">
                        Update Restaurant
                    </button>
                </form>
            </div>
        </div>
        <div class="p-4 bg-white rounded-lg grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1 md:col-span-2">
                <p class="text-lg font-bold">Setting Table</p>
                <p class="text-sm">Add, Edit and Delete Table that is available in the store</p>
            </div>
            @if(session('success_table'))
                <div class="col-span-1 md:col-span-2 flex items-start sm:items-center p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft" role="alert">
                    <i class="me-2 mt-0.5 sm:mt-0 fas fa-check"></i>
                    <p><span class="font-medium me-1">Sukses!</span> {{session('success_table')}}</p>
                </div>
            @endif
            <div class="col-span-1 flex flex-wrap gap-2">
                <p class="w-full text-base pb-2 border-b border-b-gray-200">Add Tables Form</p>
                <form action="{{ route('settings.table.create') }}" method="POST">
                    @csrf
                    <div class="form-group relative w-full">
                        <label for="table_name" class="text-sm font-medium text-gray-700 mb-1 block">Table Name</label>
                        <input type="text" name="table_name" id="table_name" placeholder="Masukkan Nama Produk" class="w-full px-5 py-3 rounded focus:outline-none  @error('table_name') focus:border-danger-subtle bg-danger-soft focus:bg-danger-medium placeholder-danger-strong border-danger @else focus:border-brand-subtle bg-neutral-primary-soft focus:bg-brand-softer placeholder-gray-500 border border-default @enderror" value="{{ old('table_name') }}">
                        @error('table_name')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="Form group grid grid-cols-5 sm:grid-cols-6 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-12 gap-2">
                        <div class="col-span-5 sm:col-span-6 md:col-span-6 lg:col-span-8 xl:col-span-12">
                            <p class="text-sm font-medium text-gray-700 mb-1 block">Table Color</p>
                        </div>
                        {{-- Color list --}}
                        <div class="col-span-1">
                            <input type="radio" id="table_color_red_500" name="table_color" value="bg-red-500" class="hidden peer" @if(old('table_color') == 'bg-red-500') checked @endif>
                            <label for="table_color_red_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-red-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_red_300" name="table_color" value="bg-red-300" class="hidden peer" @if(old('table_color') == 'bg-red-300') checked @endif>
                            <label for="table_color_red_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-red-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_red_100" name="table_color" value="bg-red-100" class="hidden peer" @if(old('table_color') == 'bg-red-100') checked @endif>
                            <label for="table_color_red_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-red-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_blue_500" name="table_color" value="bg-blue-500" class="hidden peer" @if(old('table_color') == 'bg-blue-500') checked @endif>
                            <label for="table_color_blue_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-blue-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_blue_300" name="table_color" value="bg-blue-300" class="hidden peer" @if(old('table_color') == 'bg-blue-300') checked @endif>
                            <label for="table_color_blue_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-blue-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_blue_100" name="table_color" value="bg-blue-100" class="hidden peer" @if(old('table_color') == 'bg-blue-100') checked @endif>
                            <label for="table_color_blue_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-blue-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_green_500" name="table_color" value="bg-green-500" class="hidden peer" @if(old('table_color') == 'bg-green-500') checked @endif>
                            <label for="table_color_green_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-green-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_green_300" name="table_color" value="bg-green-300" class="hidden peer" @if(old('table_color') == 'bg-green-300') checked @endif>
                            <label for="table_color_green_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-green-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_green_100" name="table_color" value="bg-green-100" class="hidden peer" @if(old('table_color') == 'bg-green-100') checked @endif>
                            <label for="table_color_green_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-green-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_yellow_500" name="table_color" value="bg-yellow-500" class="hidden peer" @if(old('table_color') == 'bg-yellow-500') checked @endif>
                            <label for="table_color_yellow_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-yellow-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_yellow_300" name="table_color" value="bg-yellow-300" class="hidden peer" @if(old('table_color') == 'bg-yellow-300') checked @endif>
                            <label for="table_color_yellow_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-yellow-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_yellow_100" name="table_color" value="bg-yellow-100" class="hidden peer" @if(old('table_color') == 'bg-yellow-100') checked @endif>
                            <label for="table_color_yellow_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-yellow-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_lime_500" name="table_color" value="bg-lime-500" class="hidden peer" @if(old('table_color') == 'bg-lime-500') checked @endif>
                            <label for="table_color_lime_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-lime-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_lime_300" name="table_color" value="bg-lime-300" class="hidden peer" @if(old('table_color') == 'bg-lime-300') checked @endif>
                            <label for="table_color_lime_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-lime-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_lime_100" name="table_color" value="bg-lime-100" class="hidden peer" @if(old('table_color') == 'bg-lime-100') checked @endif>
                            <label for="table_color_lime_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-lime-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_indigo_500" name="table_color" value="bg-indigo-500" class="hidden peer" @if(old('table_color') == 'bg-indigo-500') checked @endif>
                            <label for="table_color_indigo_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-indigo-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_indigo_300" name="table_color" value="bg-indigo-300" class="hidden peer" @if(old('table_color') == 'bg-indigo-300') checked @endif>
                            <label for="table_color_indigo_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-indigo-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_indigo_100" name="table_color" value="bg-indigo-100" class="hidden peer" @if(old('table_color') == 'bg-indigo-100') checked @endif>
                            <label for="table_color_indigo_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-indigo-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_violet_500" name="table_color" value="bg-violet-500" class="hidden peer" @if(old('table_color') == 'bg-violet-500') checked @endif>
                            <label for="table_color_violet_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-violet-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_violet_300" name="table_color" value="bg-violet-300" class="hidden peer" @if(old('table_color') == 'bg-violet-300') checked @endif>
                            <label for="table_color_violet_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-violet-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_violet_100" name="table_color" value="bg-violet-100" class="hidden peer" @if(old('table_color') == 'bg-violet-100') checked @endif>
                            <label for="table_color_violet_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-violet-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_sky_500" name="table_color" value="bg-sky-500" class="hidden peer" @if(old('table_color') == 'bg-sky-500') checked @endif>
                            <label for="table_color_sky_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-sky-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_sky_300" name="table_color" value="bg-sky-300" class="hidden peer" @if(old('table_color') == 'bg-sky-300') checked @endif>
                            <label for="table_color_sky_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-sky-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_sky_100" name="table_color" value="bg-sky-100" class="hidden peer" @if(old('table_color') == 'bg-sky-100') checked @endif>
                            <label for="table_color_sky_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-sky-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_pink_500" name="table_color" value="bg-pink-500" class="hidden peer" @if(old('table_color') == 'bg-pink-500') checked @endif>
                            <label for="table_color_pink_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-pink-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_pink_300" name="table_color" value="bg-pink-300" class="hidden peer" @if(old('table_color') == 'bg-pink-300') checked @endif>
                            <label for="table_color_pink_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-pink-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_pink_100" name="table_color" value="bg-pink-100" class="hidden peer" @if(old('table_color') == 'bg-pink-100') checked @endif>
                            <label for="table_color_pink_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-pink-100"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_amber_500" name="table_color" value="bg-amber-500" class="hidden peer" @if(old('table_color') == 'bg-amber-500') checked @endif>
                            <label for="table_color_amber_500" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-amber-500"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_amber_300" name="table_color" value="bg-amber-300" class="hidden peer" @if(old('table_color') == 'bg-amber-300') checked @endif>
                            <label for="table_color_amber_300" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-amber-300"></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-span-1">
                            <input type="radio" id="table_color_amber_100" name="table_color" value="bg-amber-100" class="hidden peer" @if(old('table_color') == 'bg-amber-100') checked @endif>
                            <label for="table_color_amber_100" class="inline-flex items-center justify-between w-full p-3 text-body bg-neutral-primary-soft border border-default rounded-base cursor-pointer peer-checked:hover:bg-brand-softer peer-checked:border-brand-subtle peer-checked:bg-brand-softer hover:bg-neutral-secondary-medium peer-checked:text-fg-brand-strong">                           
                                <div class="flex justify-center w-full">
                                    <div class="w-5 h-5 rounded-full bg-amber-100"></div>
                                </div>
                            </label>
                        </div>
                        @error('table_color')
                            <div class="col-span-3 sm:col-span-4 md:col-span-4 lg:col-span-8 xl:col-span-12">
                                <p class="text-danger">{{$message}}</p>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group button-place w-full mt-2">
                        <button type="submit" class="w-full bg-brand-light hover:bg-brand-strong text-white font-medium py-2 px-4 cursor-pointer rounded-base w-full sm:w-auto"><i class="fas fa-save"></i> Add Tables</button>
                    </div>
                </form>
            </div>
            <div class="col-span-1">
                <p class="tables-list-title text-base font-medium text-gray-700">Tables List</p>
                <p class="table-description text-sm font-medium text-gray-500 mb-4">Drag to rearrange the table</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-2 auto-rows-min" id="sortable-table">
                    @foreach ($tables as $table)
                        <div class="table-list col-span-1 border border-gray-200 rounded-lg p-3 flex flex-wrap relative cursor-move" data-uuid="{{ $table->uuid }}" data-name="{{ $table->name }}" data-color="{{$table->color}}">
                            <div class="icon-place flex items-center justify-center mb-3 w-8 h-8 rounded-full {{ $table->color }}">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>table</title> <path d="M18.76,6l2,4H3.24l2-4H18.76M20,4H4L1,10v2H3v7H5V16H19v3h2V12h2V10L20,4ZM5,14V12H19v2Z"></path> <rect width="24" height="24" fill="none"></rect> </g></svg>
                            </div>
                            <div class="table-detail-place w-full">
                                <p class="table-name text-lg font-bold text-gray-700 mb-3">{{ $table->name }}</p>
                                
                            </div>
                            <button class="px-2 py-1 rounded-full text-gray-700 cursor-pointer absolute top-2 right-2 delete-table">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    @endforeach
                    
                </div>
                <button type="button" class="w-full bg-brand-light hover:bg-brand-strong text-white font-medium py-2 px-4 cursor-pointer rounded-base w-full sm:w-auto mt-3 sort-table"><i class="fas fa-sort"></i> Sort Table</button>
            </div>
            
            
        </div>
        <div class="p-4 bg-white rounded-lg grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-3">
                <p class="text-lg font-bold">Setting Payment</p>
                <p class="text-sm">Payments Configuration on the system</p>
            </div>
            @if(session('success_tax'))
            <div class="col-span-1 md:col-span-2 flex items-start sm:items-center p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft" role="alert">
                <i class="me-2 mt-0.5 sm:mt-0 fas fa-check"></i>
                <p><span class="font-medium me-1">Sukses!</span> {{session('success_tax')}}</p>
            </div>
            @endif
            <div class="col-span-1">
                @php
                    $settingtax = $settings->first(function($item) {
                        return $item->jenis == 'payment_tax';
                    });
                @endphp
                <form method="POST" action="{{ route('settings.payment.tax.update') }}">
                    @csrf
                    <p class="text-base mb-1">Payment Tax (% Percentage)</p>
                    <input type="number" name="tax" class="w-full px-5 py-3 rounded focus:outline-none  @error('tax') focus:border-danger-subtle bg-danger-soft focus:bg-danger-medium placeholder-danger-strong border-danger @else focus:border-brand-subtle bg-neutral-primary-soft focus:bg-brand-softer placeholder-gray-500 border border-default @enderror" value="{{ old('tax',$settingtax ? $settingtax->nilai : "") }}" id="payment_tax" placeholder="Input tax percentage">
                    @error('tax')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="w-full bg-brand-light hover:bg-brand-strong text-white font-medium py-2 px-4 cursor-pointer rounded-base w-full sm:w-auto mt-2"><i class="fas fa-save"></i> Update Tax</button>
                    
                </form>
            </div>
        </div>
        

        {{-- Modal Place --}}
        
    </div>
    <script type="module">
        //Table Configuration
        var el = document.getElementById('sortable-table');
        Sortable.create(el,{
            animation: 150,
        });
        $('.sort-table').click(function() {
            loading();
            var url = "{{route('settings.table.sort')}}";
            var urutan_array = [];
            var i = 1;
            $('.table-list').each(function() {
                urutan_array.push({
                    "sort": i,
                    "uuid" : $(this).data('uuid'),
                    "color" : $(this).data('color'),
                    "name" : $(this).data('name'),
                });
                i++;
            });
            
            $.ajax({
                type: "post",
                url: url,
                headers: {
                    "X-CSRF-TOKEN": "{{csrf_token()}}"
                },
                data: {
                    "urutan" : urutan_array
                },
                success: function(data) {
                    if(data.success === true) {
                        removeLoading();
                        oAlert("green","Success",data.message);
                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors.message);
                }
            })
        });
        $('.delete-table').click(function() {
            var uuid = $(this).closest('.table-list').data('uuid');
            var url = "{{route('settings.table.delete',':id')}}";
            url = url.replace(':id',uuid);

            cConfirm("Warning","Confirm to delete the table",function() {
                loading();
                $.ajax({
                    type: "DELETE",
                    url : url,
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    success: function(data) {
                        if(data.success === true) {
                            removeLoading(),
                            cAlert("green","Success","Successfully Deleted Tables",true);
                        }
                    },
                    error: function(data) {
                        console.log(data.responseJSON.message);
                    }
                })
            })
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#picture').change(function() {
            var file = this.files[0];
            var filename = file.name;
            var filesize = file.size;
            const maxSizeInBytes = 2097152;
            var ext = file.name.split('.').pop().toLowerCase();
            var allow_ext = ['jpg','jpeg','png'];

            if($.inArray(ext,allow_ext) == -1) {
                oAlert("red","Warning","File Must Be JPG, JPEG and PNG");
                return false;
            }
            if(filesize > maxSizeInBytes) {
                oAlert("red","Warning","File size must below 2MB");
                return false;
            }


            readURL(this);

            $(this).closest('.uploaded-place').addClass('hidden');
            $('.preview-place').removeClass('hidden');
        });

        $('.preview-place').on('click','.delete-image',function(){
            $('#is_changed').val('1');
            $('#image-preview').attr('src','');
            $('#picture').val("");
            $('#picture').closest('.uploaded-place').removeClass('hidden');
            $('.preview-place').addClass('hidden');
        });
    </script>
@endsection