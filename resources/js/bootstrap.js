window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {
}

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
//
// if (process.env.MIX_BROADCAST_DRIVER === 'pusher') {
//     window.Pusher = require('pusher-js');
//
//     window.Echo = new Echo({
//         broadcaster: 'pusher',
//         key: process.env.MIX_PUSHER_APP_KEY,
//         cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//         encrypted: true
//     });
// } else if (process.env.MIX_BROADCAST_DRIVER === 'redis') {
//     window.io = require('socket.io-client');
//
//     window.Echo = new Echo({
//         broadcaster: 'socket.io',
//         host: window.location.hostname + ':' + process.env.MIX_BROADCAST_PORT
//     });
// }

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'b075746e303703cd3e40',
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     wssPort: 443,
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
//     authEndpoint : 'http://' + window.location.hostname + '/broadcasting/auth'
// });
window.Echo = new Echo( {
    broadcaster: "pusher",
    key: "b075746e303703cd3e40",
    wsHost: 'localhost',
    // wsHost:'45.55.35.46',
    wsPort: 6001,
    wssPort: 443,
    forceTLS: false,
    cluster: "ap1",
    disableStats: true,
    enabledTransports: [ "ws", "wss" ],
} );
