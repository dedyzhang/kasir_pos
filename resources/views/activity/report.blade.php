@extends('layout.index')

@section('title','Report')

@section('navbar')
    <div class="navbar-container flex items-center justify-between w-full gap-4 pe-6">
        <h1 class="text-lg md:text-3xl font-bold">Activity <span class="text-base text-gray-400">> Reports</span></h1>
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
            <a href="{{ route('activity.index') }}" aria-current="true" class="block w-full px-4 py-5 text-lg cursor-pointer hover:bg-brand-softer hover:text-fg-brand rounded-lg">
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
        <div class="date-place flex flex-wrap gap-0 sm:gap-3 mb-6 sm:mb-3 justify-between">
            <div class="date-input flex flex-col gap-1 w-full sm:w-auto">
                <label class="w-full">Select Date To View Report</label>
                <input type="date" name="report-date" id="report-date" class="px-3 py-2 w-full sm:w-50 bg-neutral-primary rounded-base border border-brand-medium" value="" />
            </div>
            <div class="print-container mt-10 sm:mt-0">
                <button class="px-4 py-2 bg-brand-softer cursor-pointer border border-brand-light rounded-base hover:bg-brand-medium rounded-full print-button">
                    <i class="fas fa-print text-brand-light"></i>
                </button>
            </div>
        </div>
        <div class="report-place grid grid-cols-1 md:grid-cols-6 w-full gap-3" id="print-report">
            <div class="col-span-1 md:col-span-3">
                <table class="w-full">
                    <tr>
                        <td class="p-2">Tanggal</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="selected-date"></td>
                    </tr>
                    <tr class="bg-brand-softer">
                        <td class="p-2">Total Transaksi</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="total-transactions"></td>
                    </tr>
                    <tr>
                        <td class="p-2">Total Item Terjual</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="total-items"></td>
                    </tr>
                    <tr class="bg-brand-softer">
                        <td class="p-2">Omzet Bersih</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="total-revenue"></td>
                    </tr>
                </table>
            </div>
            <div class="col-span-1 md:col-span-6 mt-3">
                <h3 class="font-bold text-lg sm:text-2xl">Sales By Menus</h3>
                <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default mt-3">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Product Name
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Harga Satuan
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Harga HPP Satuan
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Total HPP
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Total Penjualan
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Keuntungan
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sales-by-menu">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-1 md:col-span-3">
                <h3 class="font-bold text-lg sm:text-2xl">Order Type Summary</h3>
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Order Type
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Total Transaksi
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Total Penjualan
                            </th>
                        </tr>
                    </thead>
                    <tbody id="order-type-summary">
                        
                    </tbody>
                </table>
            </div>
             <div class="col-span-1 md:col-span-6 mt-3">
                <h3 class="font-bold text-lg sm:text-2xl">Payment Report Method</h3>
                <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default mt-3">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Metode Pembayaran
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Jumlah Transaksi
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Total
                                </th>
                               
                            </tr>
                        </thead>
                        <tbody id="payment-method-summary">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-1 md:col-span-3">
                <h3 class="font-bold text-lg sm:text-2xl">Profit Summary</h3>
                <table class="w-full">
                    <tr>
                        <td class="p-2">Total Penjualan</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-revenue"></td>
                    </tr>
                    <tr>
                        <td class="p-2">Total Diskon</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-discount"></td>
                    </tr>
                    <tr>
                        <td class="p-2">Total Pajak</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-tax"></td>
                    </tr>
                    <tr class="">
                        <td class="p-2">HPP ( Estimasi )</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-cost-price"></td>
                    </tr>
                    <tr>
                        <td class="p-2">Laba Kotor</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-gross-profit"></td>
                    </tr>
                    <tr class="">
                        <td class="p-2">Biaya Operasional</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-operational-cost"></td>
                    </tr>
                    <tr class="bg-brand-softer">
                        <td class="p-2">Laba Bersih</td>
                        <td class="p-2">:</td>
                        <td class="p-2" id="summary-net-profit"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="module">
    $('#report-date').on('change',function() {
        var date = $(this).val();

        //Empty All Data
        $('#selected-date').text('');
        $('#total-transactions').text('');
        $('#total-items').text('');
        $('#total-revenue').text('');
        $('#sales-by-menu').html('');
        $('#order-type-summary').html('');
        $('#payment-method-summary').html('');
        $('#summary-revenue').text('');
        $('#summary-discount').text('');
        $('#summary-tax').text('');
        $('#summary-cost-price').text('');
        $('#summary-gross-profit').text('');
        $('#summary-operational-cost').text('');
        $('#summary-net-profit').text('');

        loading();
        var url = "{{ route('activity.report.show',':date') }}";
        url = url.replace(':date',date);
        $.ajax({
            type: "GET",
            url : url,
            success : function(data) {
                console.log(data);
                var summary = data.summary;
                removeLoading();
                //Masukkan Tanggal Ke Format Yang Lebih Mudah Dibaca
                var date = moment(summary.date).format('ddd, D MMMM YYYY');
                $('#selected-date').text(date);
                //Masukkan data ke format
                $('#total-transactions').text(summary.total_transactions);
                $('#total-items').text(summary.total_items);
                $('#total-revenue').text('Rp. ' + summary.total_revenue.toLocaleString('id-ID') + ',-');

                //sales by menu
                var salesRow = '';
                Object.entries(summary.items).forEach(([key, element]) => {
                    salesRow += `<tr class="bg-neutral-primary border-b border-default">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    ${element.name}
                                </th>
                                <td class="px-6 py-4">
                                    ${element.qty}
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.price.toLocaleString('id-ID')},-
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.cost_price.toLocaleString('id-ID')},-
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.cost_price_total.toLocaleString('id-ID')},-
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.total.toLocaleString('id-ID')},-
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.profit.toLocaleString('id-ID')},-
                                </td>
                            </tr>`;
                });
                $('#sales-by-menu').html(salesRow);
                
                //Order Type Summary
                var orderTypeRow = '';
                Object.entries(summary.order_types).forEach(([key, element]) => {
                    orderTypeRow += `<tr class="bg-neutral-primary border-b border-default">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    ${key}
                                </th>
                                <td class="px-6 py-4">
                                    ${element.total_transaction}
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.total.toLocaleString('id-ID')},-
                                </td>
                            </tr>`;
                });
                $('#order-type-summary').html(orderTypeRow);

                //Payment Method Summary
                var paymentMethodRow = '';
                Object.entries(summary.payment_methods).forEach(([key, element]) => {
                    paymentMethodRow += `<tr class="bg-neutral-primary border-b border-default">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    ${key}
                                </th>
                                <td class="px-6 py-4">
                                    ${element.total_transaction}
                                </td>
                                <td class="px-6 py-4">
                                    Rp. ${element.total.toLocaleString('id-ID')},-
                                </td>
                                
                            </tr>`;
                });
                $('#payment-method-summary').html(paymentMethodRow);

                //Summary
                $('#summary-revenue').text('Rp. ' + summary.total_revenue.toLocaleString('id-ID') + ',-');
                $('#summary-discount').text('Rp. ' + summary.total_discount.toLocaleString('id-ID') + ',-');
                $('#summary-tax').text('Rp. ' + summary.total_tax.toLocaleString('id-ID') + ',-');
                $('#summary-cost-price').text('Rp. ' + summary.total_cost_price.toLocaleString('id-ID') + ',-');
                $('#summary-gross-profit').text('Rp. ' + summary.laba_kotor.toLocaleString('id-ID') + ',-');
                $('#summary-operational-cost').text('Rp. ' + summary.operasional_cost.toLocaleString('id-ID') + ',-');
                $('#summary-net-profit').text('Rp. ' + summary.laba_bersih.toLocaleString('id-ID') + ',-');
            },
            error : function(data) {
                console.log(data.responseJSON.message);
            }
        });
    });

    $('.print-button').on('click', function() {
        window.print();
    });
</script>
@endsection