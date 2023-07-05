window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/**
 * ----------------------------------------------------------------
 * jQuery 3
 * ----------------------------------------------------------------
 */
import $ from 'jquery';
window.jQuery = $;
window.$ = $;
window.$ = $;

/**
 * ----------------------------------------------------------------
 * Bootstrap
 * ----------------------------------------------------------------
 */
import 'bootstrap/dist/js/bootstrap.bundle.js';

/**
 * ----------------------------------------------------------------
 * Bootstrap Icons
 * ----------------------------------------------------------------
 */
import 'bootstrap-icons/font/bootstrap-icons.css';

/**
 * ----------------------------------------------------------------
 * DataTables.net
 * ----------------------------------------------------------------
 */
import jszip from 'jszip';
import pdfmake from 'pdfmake';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-fixedheader-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-scroller-bs5';
import 'datatables.net-staterestore-bs5';

/**
 * ----------------------------------------------------------------
 * Sweetalert2
 * ----------------------------------------------------------------
 */
import Swal from 'sweetalert2';
window.Swal = Swal;

/**
 * ----------------------------------------------------------------
 * Select2
 * ----------------------------------------------------------------
 */
import select2 from 'select2/dist/js/select2.full.min.js';
import 'select2/dist/css/select2.min.css';