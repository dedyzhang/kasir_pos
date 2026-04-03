import './bootstrap';
import $ from 'jquery';
window.jQuery = window.$ = $;

import 'flowbite';

import 'overlayscrollbars/overlayscrollbars.css';
import { 
  OverlayScrollbars, 
  ScrollbarsHidingPlugin, 
  SizeObserverPlugin, 
  ClickScrollPlugin 
} from 'overlayscrollbars';

window.OverlayScrollbars = OverlayScrollbars;

import DataTable from 'datatables.net-dt';
window.DataTable = DataTable;

import { cAlert, oAlert, cConfirm } from "./alert";
window.cAlert = cAlert;
window.oAlert = oAlert;
window.cConfirm = cConfirm;
cAlert("green", "Berhasil", "Data berhasil dimuat", false, null);

//Loading
import { loading, removeLoading } from "./loading";
window.loading = loading;
window.removeLoading = removeLoading;

//Modal
import { Modal } from "flowbite";
window.modal = Modal;

//Sortable
import Sortable from 'sortablejs';
window.Sortable = Sortable;

import moment from 'moment';
moment.locale('id');
window.moment = moment;

$('.open-sidebar').on('click',function() {
    $('.sidebar').toggleClass('hidden');

    $('.close-sidebar').on('click','button',function() {
        $('.sidebar').addClass('hidden');
    });
});

// Add Commas Function
function addCommas(nStr)
{
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
window.addCommas = addCommas;