
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
        msgForm: '#msg-form',
        msgInput: '#msg-input',
        sendMsgBtn: '#send-msg-btn',
        roomIdInput: '#room-id-input',
        chatListContainer: '.chat-list',
        whisperTyping: '#whisper-typing',
        authUserNameInput: '#auth-user-name-input',
        onlineListContainer: '#online-list-container'
    },
    roomId = $(selectors.roomIdInput).val(),
    authUserName = $(selectors.authUserNameInput).val();

    const joinedRoom = function () {
        Echo.join(`room.${roomId}`)
            .here((users) => {
                let list = '';

                for (let i = 0; i < users.length; i++) {
                    list += `<div><a href="#">${users[i].name}</a></div>`;
                }
                
                $(selectors.onlineListContainer).append(list);
            })
            .joining((user) => {
                let child = `<div><a href="#">${user.name}</a></div>`;

                $(selectors.onlineListContainer).append(child);
            })
            .leaving((user) => {
                //
            })
            .listen('MessageCreated', (e) => {
                console.log('Event', e);
            });
    }
    
    const sendMsg = function () {
        let msg = $(selectors.msgInput).val();

        if (msg) {
            axios.post('/messages/store', {
                body: msg,
                room_id: roomId
            })
            .then(function () {
                $(selectors.msgInput).val('');

                let chat = `<article class="chat-item right">
                <section class="chat-body">
                    <div class="panel b-light text-sm m-b-none">
                    <div class="panel-body">
                        <span class="arrow right"></span>
                        <strong><small class="text-muted"><i class="fa fa-ok text-success"></i></small></strong>
                        <p class="m-b-none">${msg}</p>
                    </div>
                    </div>
                    <small class="text-muted"><i class="fa fa-ok text-success"></i>${new Date()}</small>
                </section>
            </article>`;

            $(selectors.chatListContainer).append(chat);
                
            })
            .catch(function (error) {
                //
            });
        }
    }

    const whisper = function () {
        setTimeout(function() {
            Echo.private('message')
            .whisper('typing', {
                name: authUserName
            });
        }, 300);  
    }

    const listenForWhisper = function () {
        Echo.private('message')
            .listenForWhisper('typing', (e) => {
                $(selectors.whisperTyping).text(`${e.name} is typing...`);

                setTimeout(function () {
                    $(selectors.whisperTyping).text('');
                }, 900);
            });
    }

    $(document.body).on('keypress', selectors.msgInput, whisper);
    $(document.body).on('click', selectors.sendMsgBtn, sendMsg);

    $(document).ready(function() {
        joinedRoom();
        listenForWhisper();
    });
})(window.$, window.Echo);
