window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {

}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.basictable = require('basictable');
window.select2 = require('select2');
window.Chart = require('chart.js');
window.iziToast = require('iziToast');
window.mask = require('jquery-mask-plugin');
window.Vue = require('vue');
window.trumbowyg = require('trumbowyg');
require('trumbowyg/dist/plugins/upload/trumbowyg.upload.js');
require('trumbowyg/dist/langs/fa.min');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('notification-navbar-component', require('./components/NotificationNavbarComponent.vue'));
Vue.component('span-component', require('./components/SpanComponent.vue'));

const app = new Vue({
    el: '#app'
});


window.selectProvince = function (province_id) {
    axios.post('ajax/cities', {'province_id': province_id}).then(function (response) {
        $('#city_id').html('');
        for (var i = 0, len = response.data.length; i < len; i++) {
            var city = new Option(response.data[i].name, response.data[i].id, false, false);
            $('#city_id').append(city).trigger('change');
        }
    }).catch(function (error) {
        console.log(error);
    });
}

window.showPassword = function (selector) {
    var input = $(selector);
    var icon = $(selector + '_icon');
    if (input.attr("type") == "password") {
        input.attr('type', 'text');
        icon.removeClass('fa-eye-slash');
        icon.addClass('fa-eye');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye');
        icon.addClass('fa-eye-slash');
    }
}


$(document).ready(function () {
    //select
    $('.select').select2({
        dir: "rtl",
        language: "fa"
    });

    //tags
    $(".tags").select2({
        dir: "rtl",
        language: "fa",
        tags: true,
        tokenSeparators: [',']
    });

    //price
    $('.price').mask('#,##0', {reverse: true});

    $('table').basictable();

    $("[data-toggle='tooltip']").tooltip();

    //Wisywig
    $('.wysiwyg').trumbowyg({
        btnsDef: {
            image: {
                dropdown: ['insertImage', 'upload'],
                ico: 'insertImage',
                urlPropertyName: 'data.url',
            },
        },
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['undo', 'redo'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['image'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        lang: 'fa',
        svgPath: 'images/icons.svg',
        plugins: {
            upload: {
                imageWidthModalEdit: true,
                serverPath: 'editor/upload',
                fileFieldName: 'source',
                urlPropertyName: 'url',
                headers: {
                    'X-CSRF-TOKEN': token.content
                },
                success: function (data, trumbowyg, _$modal, values) {
                    trumbowyg.doc.execCommand("insertHTML", false, "<img class='img-fluid' src='" + data.url + "' alt='" + values.alt + "'>")
                    trumbowyg.closeModal();
                }
            }
        }
    });
});
