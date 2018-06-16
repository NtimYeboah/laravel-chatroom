
## Learn how to build realtime applications in Laravel

This is a simple project to demonstrate how to build realtime applications using Laravel and Pusher or SocketIO. This is a chatting app that performs the following in real-time


1. Notifies connected users when a new user joins
2. Update messages
3. Shows who is typing

## Installation and Setup

Clone this repository by running
```bash
git clone https://github.com/NtimYeboah/laravel-chatroom.git
```
Install the packages by running the composer install command
```bash
composer install
```
Set your database credentials in the `.env` file

Run the migrations
```base
php artisan migrate
```

### Pusher
[Pusher](https://pusher.com/) is a hosted service that makes it super-easy to add real-time data and functionality to web and mobile applications. Since we will be using Pusher, make sure to sign up and get your app credentials. Set the Pusher app credentials in the `.env` as follows
```
PUSHER_APP_ID=your-pusher-app-id
PUSHER_APP_KEY=your-pusher-app-key
PUSHER_APP_SECRET=your-pusher-app-secret
PUSHER_APP_CLUSTER=mt1
```
Set the `BROADCAST_DRIVER` variable in the `.env` file to `pusher`
```base
BROADCAST_DRIVER=pusher
```

### SocketIO
[SocketIO](https://socket.io/) enables realtime, bi-directional communication between web clients and servers. If you opt to use SocketIO, do the follow;

Set the `BROADCAST_DRIVER` variable in the `.env` file to `socketio`
```base
BROADCAST_DRIVER=socketio
```

### Broadcasting Events
Since Laravel event broadcasting is done via queued jobs, we need to configure and run a queue listener. If you are not comfortable with Laravel queues, make sure to look at this [repository](https://github.com/NtimYeboah/laravel-queues-example) to learn more. To configure the queue to user redis as the queue driver, set the credentials in the `.env` file.
```bash
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379
```
Then set the `QUEUE_DRIVER` to `redis`
```bash
QUEUE_DRIVER=redis
```
Start the queue.
```bash
php artisan queue:work redis
```

## Running Application
Visit the `APP_URL` you set in the `.env` file to see your Laravel application. Register and create a new chat room to get started.

### Notify connected users when new users join
Open up another browser, register a new user and join the chat room created. Notice the new user is added to the list of online users.

### Shows who is typing
Start tying a message in one browser. Notice a typing indicator is shown below the textarea of the other browser. This makes use of
client events. Be sure to enable client events when using [Pusher](https://pusher.com/). 


