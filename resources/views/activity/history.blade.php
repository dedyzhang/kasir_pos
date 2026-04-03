@extends('layout.index')

@section('title','Activity')

@section('navbar')
    <div class="navbar-container flex items-center justify-between w-full gap-4 pe-6">
        <h1 class="text-lg md:text-3xl font-bold">Activity <span class="text-base text-gray-400">> Order History</span></h1>
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
                <a href="{{ route('activity.index') }}" aria-current="true" class="block w-full px-4 py-5 text-lg cursor-pointer hover:bg-brand-softer hover:text-fg-brand rounded-lg ">
                    Billing Queus
                </a>
                
                <a href="{{ route('activity.history') }}" class="text-lg block w-full px-4 py-5 text-white bg-brand-light rounded-lg cursor-pointer">
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
            <div class="date-place inline-flex flex-wrap items-center gap-0 sm:gap-3 mb-6 sm:mb-3">
                <label>Date</label>
                <input type="date" name="start-date" id="start-date" class="px-2 py-1.5 w-full sm:w-50 bg-neutral-primary rounded-full border border-brand-medium" value="" />
                <label>-</label>
                <input type="date" name="end-date" id="end-date" class="px-2 py-1.5 w-full sm:w-50 bg-neutral-primary rounded-full border border-brand-medium" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="wrapper-table" class="w-full">
                <table id="dataTables" class="w-full">
                    <thead class="bg-brand-softer text-sm text-gray-600 border-b border-default h-20">
                        <tr>
                            <th class="text-left p-3 rounded-tl-lg">#</th>
                            <th class="text-left p-3">Date & Time</th>
                            <th class="text-left p-3">Name</th>
                            <th class="text-left p-3">Order Status</th>
                            <th class="text-left p-3 rounded-tr-lg">Total Payment</th>
                            <th class="text-left p-3 rounded-tr-lg">Orders</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="border border-default odd:bg-neutral-primary even:bg-neutral-secondary text-sm" data-uuid="{{ $transaction->uuid }}">
                                <td class="p-3">#{{ $transaction->invoice_number }} </td>
                                <td class="p-3">{{ $transaction->paid_at}}</td>
                                <td class="p-3">{{ $transaction->customer_name ?? 'Guest'}}</td>
                                <td class="p-3">{{ $transaction->status}}</td>
                                <td class="p-3">Rp. {{ number_format($transaction->total,0,',','.')}}</td>
                                <td class="p-3 text-blue-700"><a href="#" class="detail-transaction" data-uuid="{{ $transaction->uuid }}">Details</a></td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                        
                </table>
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
                            <div class="flex justify-between items-center p-2 pt-1 pb-1 w-full">
                                <p class="text-gray-500 text-sm truncate">SubTotal</p>
                                <p class="text-sm transaction-detail-subtotal">Rp 0</p>
                            </div>
                            <div class="flex justify-between items-center p-2 pt-1 pb-1 w-full">
                                <p class="text-gray-500 text-sm truncate">Pajak</p>
                                <p class="text-sm transaction-detail-pajak">Rp 0</p>
                            </div>
                            <div class="flex justify-between items-center p-2 pt-1 pb-1 w-full">
                                <p class="text-gray-500 text-sm truncate">Diskon</p>
                                <p class="text-sm transaction-detail-diskon">Rp 0</p>
                            </div>
                            <div class="flex justify-between items-center p-2 pt-1 pb-1 w-full">
                                <p class="text-gray-500 font-semibold">Total</p>
                                <p class="text-lg font-bold transaction-detail-total">Rp 0</p>
                            </div>
                            
                            <div class="flex justify-between items-center p-2 pt-1 pb-1 w-full">
                                <p class="text-gray-500 text-md">Paid <span class="paid_method"></span></p>
                                <p class="text-md transaction-detail-paid">Rp 0</p>
                            </div>
                            <div class="flex justify-between items-center p-2 pt-1 pb-1 w-full">
                                <p class="text-gray-500 text-md">Change</p>
                                <p class="text-md transaction-detail-changed">Rp 0</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script type="module">
        let minDate, maxDate;
        // options with default values
        const options = {
            placement: "center",
            backdrop: "dynamic",
            backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40",
            closable: true,
        };
        const modal = new Modal(document.getElementById('modal-see-transaction'),options);
 
        $('#start-date').on('change',function() {
            // Custom filtering function which will search data in column four between two values
            DataTable.ext.search.push(function (settings, data, dataIndex) {
                let min = moment($('#start-date').val()).toDate();
                let max = moment($('#end-date').val()).add(24, 'hours').toDate() ;
                let date = moment(data[1]).toDate();
            
                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            });
             // Refilter the table
            document.querySelectorAll('#start-date, #end-date').forEach((el) => {
                el.addEventListener('change', () => table.draw());
                // console.log(maxDate);
            });
        });
        let table = new DataTable('#dataTables',{
            columns: [{ width: '10%' },{ width: '15%' },{ width: '15%' },{ width: '10%' },{ width: '25%' },{ width: '25%' }],
        });
        
       

        $('#dataTables').on('click','.detail-transaction',function(e) {
            e.preventDefault();
            var uuid = $(this).data('uuid');
            var url = "{{ route('transaction.show',':id') }}";
            url = url.replace(':id',uuid);
            $('.transaction-detail-list').html('');
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
                                } 
                                var changed = transaction.total_paid - transaction.total;
                                $('.transaction-detail-list').html(orderList);
                                $('.transaction-detail-subtotal').html('Rp ' + addCommas(transaction.subtotal));
                                $('.transaction-detail-pajak').html('Rp ' + addCommas(transaction.tax));
                                $('.transaction-detail-diskon').html('Rp ' + addCommas(transaction.discount));
                                $('.transaction-detail-total').html('Rp ' + addCommas(transaction.total));
                                $('.transaction-detail-paid').html('Rp ' + addCommas(transaction.total_paid));
                                $('.transaction-detail-changed').html('Rp ' + addCommas(changed));
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
    </script>

@endsection