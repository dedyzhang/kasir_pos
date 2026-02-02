import './bootstrap';
import $ from 'jquery';
window.jQuery = window.$ = $;

import 'flowbite';

$('.open-sidebar').on('click',function() {
    $('.sidebar').toggleClass('hidden');

    $('.close-sidebar').on('click','button',function() {
        $('.sidebar').addClass('hidden');
    });
});