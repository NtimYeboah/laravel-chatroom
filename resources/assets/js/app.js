
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});

(function ($, Echo) {
    const selectors = {
        roomIdInput: '#room-id-input',
        onlineListContainer: '#online-list-container'
    }

    const joinedRoom = function () {
        let roomId = $(selectors.roomIdInput).val();

        Echo.join(`room.${roomId}`)
            .here((users) => {
                let list = '';

                for (let i = 0; i < users.length; i++) {
                    list += `<div><a href="#">${users[i].name}</a></div>`;
                }
                
                $(selectors.onlineListContainer).append(list);
            })
            .joining((user) => {
                console.log('User from joining', user);
            })
            .leaving((user) => {
                console.log('User from leaving', user);
            });
    }

    $(document).ready(function() {
        joinedRoom();
    });
})(window.$, window.Echo);
