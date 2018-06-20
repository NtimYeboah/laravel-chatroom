
## Learn how to build realtime applications in Laravel

This is a simple project to demonstrate how to build realtime applications using Laravel and Pusher or SocketIO. This is a chatting app that performs the following in real-time


1. Notify connected users when a user comes online
2. Update messages for other users
3. Show who is typing

## Table of contents
- [Installation and Setup](#installation-and-setup)
    * [Pusher](#pusher)
    * [SocketIO](#socketio)
        + [Install Server](#install-server)
        + [Setup Configuration file](#setup-configuration-file)
        + [Run Server](#run-server)
    * [Broadcasting Events](#broadcasting-events)
- [Running Application](#running-application)
    * [Notify connected users](#notify-connected-users)
    * [Update messages](#update-messages)
    * [Show who is typing](#show-who-is-typing)
- [Diving Deep](#diving-deep)
    * [Notify connected users when a user comes online](#notify-connected-users-when-a-user-comes-online)
        + [Migrations](#migrations)
            - [User migration](#user-migration)
            - [Room migration](#room-migration)
            - [Room User migration](#room-user-migration)
        + [Models](#models)
            - [User model](#user-model)
            - [Room model](#room-model)
        + [Routes](#routes)
        + [Controller](#controller)
            - [Show list of rooms](#show-list-of-rooms)
            - [Show form to create a room](#show-form-to-create-a-room)
            - [Store room](#store-room)
            - [Show a room](#show-a-room)
            - [Join a room](#join-a-room)
        + [Event](#event)
            - [Implement shouldBroadcast interface](#implement-shouldbroadcast-interface)
            - [Define queue](#define-queue)
            - [Define channel](#define-channel)
        + [Channel](#channel)
            - [Authorizing channel](#authorizing-channel)
    * [Show who is typing](#show-who-is-typing)
        + [Broadcast typing event](#broadcast-typing-event)
        + [Listen to typing event](#listen-to-typing-event)
        + [Define message channel](#define-message-channnel)


## Installation and Setup

Clone this repository by running
```bash
$ git clone https://github.com/NtimYeboah/laravel-chatroom.git
```
Install the packages by running the composer install command
```bash
$ composer install
```

Install JavaScript dependencies
```bash
$ npm install
```

Set your database credentials in the `.env` file

Run the migrations
```base
$ php artisan migrate
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
[SocketIO](https://socket.io/) enables realtime, bi-directional communication between web clients and servers. If you opt to use SocketIO, you need to install a Socket.io server. You can find a Socket.io server which is bundled inside laravel-echo-server [](https://github.com/tlaverdure/laravel-echo-server). Make sure you meet the system requirements.

#### Install Server
Install the package globally with the following command:
```bash
$ npm install -g laravel-echo-server
```

#### Setup configuration file
Run the init command in your project directory to setup **laravel-echo-server.json** configuration file to manage the configuration of your server.
```bash
$ laravel-echo-server init
```
Answer accordingly to generate the file.

#### Run server
Start the server in the root of your project directory
```bash
$ laravel-echo-server start
```

Set the `BROADCAST_DRIVER` variable in the `.env` file to `socketio`
```base
BROADCAST_DRIVER=redis
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
$ php artisan queue:work redis
```

## Running Application
Visit the `APP_URL` you set in the `.env` file to see your Laravel application. Register and create a new chat room to get started.

### Notify connected users
Open up another browser, register a new user and join the chat room created. Notice the new user is added to the list of online users.

### Update messages
Send a message. Notice the message is added to the list of the messages in thhe other browser in realtime.

### Show who is typing
Start tying a message in one browser. Notice a typing indicator is shown below the textarea of the other browser. This makes use of
client events. Be sure to enable client events when using [Pusher](https://pusher.com/). 


## Diving Deep
This section takes a deep dive into how each of the features are implemented.

### Notify connected users when a user comes online
To implement this feature, a user has to create a chat room and the other users will join. When a user joins a room, his presence will be broadcasted to the other online users. 

#### Migrations
A user can create several chat rooms, and a user can join any number of chat rooms. Therefore the relationshhip between chat rooms and users is a `many-to-many`. However, we will need a migration for `users`, `rooms` and `room_user` tables.

##### User migration
We won't make any modifications to the default `users` migration that comes with Laravel.

##### Room migration
A room have a name and a description.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/database/migrations/2018_06_09_080445_create_rooms_table.php](https://github.com/NtimYeboah/laravel-chatroom/database/migrations/2018_06_09_080445_create_rooms_table.php)
```php
...

$table->string('name');
$table->string('description');

...
```

##### Room User migration

The `room_user` table is the intermediary table between `users` and `rooms`.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/database/migrations/2018_06_09_211834_create_room_user_table.php](https://github.com/NtimYeboah/laravel-chatroom/database/migrations/2018_06_09_211834_create_room_user_table.php)
```php
...

$table->bigInteger('room_id');
$table->bigInteger('user_id');

...
```

#### Models
The model defines the relationship and methods for adding a room, joining a room, leaving a room and checking if a user has joined a room.

##### User Model
This defines a `many-to-many` relationship between `user` and `room`, a method for adding a room and another method for checking if a user has joined a room.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/app/User.php](https://github.com/NtimYeboah/laravel-chatroom/app/User.php)

Rooms relationship

Use `belongsToMany` method to define the `many-to-many` relationship.

```php
...

/**
 * The rooms that this user belongs to
 */
public function rooms()
{
    return $this->belongsToMany(Room::class, 'room_user')
        ->withTimestamps();
}

...
```

Adding a room to user's room list

Use the `attach` method on the query builder to insert into the intermediary table after creating a room.

```php
...

/**
 * Add a new room
 * 
 * @param \App\Room $room
 */
public function addRoom($room)
{
    return $this->rooms()->attach($room);
}

...
```

Check if a user has joined a room

Check if room exists on the list of user's rooms by using the `where` eloquent method

```php
...

/**
 * Check if user has joined room
 * 
 * @param mixed $roomId
 * 
 * @return bool
 */
public function hasJoined($roomId)
{
    $room = $this->rooms->where('id', $roomId)->first();

    return $room ? true : false;
}
```

##### Room model
This defines a `many-to-many` relationship between `room` and `user`, a method for adding a user to a room, a method for joining a room and another for leaving a room.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/app/Room.php](https://github.com/NtimYeboah/laravel-chatroom/app/Room.php)

Users relationship

Use `belongsToMany` method to define the `many-to-many` relationship.

```php
...
/**
 * The rooms that belongs to the user
 */
public function users()
{
    return $this->belongsToMany(User::class, 'room_user')
        ->withTimestamps();
}
...
```

Joining a room

Use the `attach` method on the query builder to insert into the intermediary table.

```php
...
/**
 * Join a chat room
 * 
 * @param \App\User $user
 */
public function join($user)
{
    return $this->users()->attach($user);
}
...
```

Leaving a room

Use the `detach` method on the query builder to remove a user from the intermediary table.

```php
...
/**
 * Leave a chat room
 * 
 * @param \App\User $user
 */
public function leave($user)
{
    return $this->users()->detach($user);
}
...
```

#### Routes

There is a route for listing rooms, showing a room, showing a form for creating room, storing a room and joining a room.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/routes/web.php](https://github.com/NtimYeboah/laravel-chatroom/routes/web.php)

```php
...

Route::group(['prefix' => 'rooms', 'as' => 'rooms.', 'middleware' => ['auth']], function () {
    Route::get('', ['as' => 'index', 'uses' => 'RoomsController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'RoomsController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'RoomsController@store']);
    Route::get('{room}', ['as' => 'show', 'uses' => 'RoomsController@show']);
    Route::post('{room}/join', ['as' => 'join', 'uses' => 'RoomsController@join']);
});

...
```

#### Controller

The `RoomsController` has methods for showing a list of rooms, showing a room, showing a form for creating a room, storing a room and joining a room.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/app/Http/Controllers/RoomsController.php](https://github.com/NtimYeboah/laravel-chatroom/app/Http/Controllers/RoomsController.php)

##### Show list of rooms
A room is shown with its users

```php
...
/**
 * Display a listing of the chat rooms.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
    $rooms = Room::with('users')->paginate();

    return view('rooms.index', compact('rooms'));
}

...
```

##### Show form to create a room

The form for creating a room can be found in `rooms/create.blade.php` directory

```php
...
/**
 * Show the form for creating a chat room.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    $room = app(Room::class);

    return view('rooms.create', compact('room'));
}

...
```

##### Store room

When storing a room, we validate the request and try to save the room. After saving the room, we add it to the list of the user's rooms. If any exception happens, we log it and return back to the form.

```php
...
/**
 * Store a newly created room in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    $this->validate($request, [
        'name' => 'required'
    ]);
    
    try {
        $room = Room::create([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        $request->user()->addRoom($room);
    } catch (Exception $e) {
        Log::error('Exception while creating a chatroom', [
            'file' => $e->getFile(),
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ]);

        return back()->withInput();
    }

    return redirect()->route('rooms.index');  
}
...
```

##### Show a room

We load the messages when showing a room

```php
...
/**
 * Show room with messages
 * 
 * @param mixed $room
 */
public function show(Room $room)
{
    $room = $room->load('messages');
    
    return view('rooms.show', compact('room'));
}
...
```

##### Join a room

When joining a room, we make use of the `join` method defined in the Room model and then emit the `RoomJoined` event.

```php
...
/**
 * Allow user to join chat room
 * 
 * @param Room $room
 * @param \Illuminate\Http\Request $request
 */
public function join(Room $room, Request $request) 
{
    try {
        $room->join($request->user());

        event(new RoomJoined($request->user(), $room));
    } catch (Exception $e) {
        Log::error('Exception while joining a chat room', [
            'file' => $e->getFile(),
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ]);

        return back();
    }

    return redirect()->route('rooms.show', ['room' => $room->id]);
}
...
```

#### Event

The `RoomJoined` event is emitted when a user joins a room. The event carries the data that will be sent to the connected browsers via Pusher or Socket.io. The `RoomJoined` event implements the `ShouldBroadcast` interface. It defines the queue the event will be placed on, for this event, it will be placed on `events:room-joined`. It also defines the channel the event will be broadcasted on. The name of the channel is `room.{roomId}`.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/app/Events/RoomJoined.php](https://github.com/NtimYeboah/laravel-chatroom/app/Events/RoomJoined.php)

##### Implement `shouldBroadcast` interface

```php
...
use use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RoomJoined implements ShouldBroadcast 
{

...
```

##### Define queue

```php
...
/**
 * The name of the queue on which to place the event
 */
public $broadcastQueue = 'events:room-joined';

...
```

##### Define channel

```php
...
use Illuminate\Broadcasting\PresenceChannel;
.
.
.

/**
 * Get the channels the event should broadcast on.
 *
 * @return \Illuminate\Broadcasting\Channel|array
 */ 
public function broadcastOn()
{
    return new PresenceChannel('room.' . $this->room->id);
}
...
```

#### Channel

Since `RoomJoined` event defines a Presence Channel, we need to return some data about the user when authorizing the channel. When authorizing the channel, we use the `hasJoined` methods to determine if the user has joined the room or not.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/routes/channels.php](https://github.com/NtimYeboah/laravel-chatroom/routes/channel.php)

##### Authorizing channel

```php
...
**
 * Authorize room.{roomId} channel 
 * for authenticated users
 */
Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    if ($user->hasJoined($roomId)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
});
...
```


### Show who is typing.
For this feature, we make use of client events. The event will be broadcasted without going the Laravel application.

To broadcast the event, we use Laravel Echo's `whisper` method. To listen to the event, we use the `listenForWhisper` method.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/resources/assets/js/app.js](https://github.com/NtimYeboah/laravel-chatroom/resources/assets/js/app.js)

#### Broadcast typing event
We broadcast `typing` event when a user begins to type along with the name of that user.

```javascript
...
const whisper = function () {
    setTimeout(function() {
        Echo.private('message')
        .whisper('typing', {
            name: authUserName
        });
    }, 300);  
}
...
```

#### Listen to typing event

Let's listen for the `typing` event and prepend the name of the user to the `is typing...` string.

```javascript
...
const listenForWhisper = function () {
    Echo.private('message')
        .listenForWhisper('typing', (e) => {
            $(selectors.whisperTyping).text(`${e.name} is typing...`);

            setTimeout(function () {
                $(selectors.whisperTyping).text('');
            }, 900);
        });
}
...
```

#### Define message channel
We need to authorize a private channel for client events. We will use a channel with name `message` and authorize it for authenticated users.

[https://github.com/NtimYeboah/laravel-chatroom/blob/master/routes/channels.php](https://github.com/NtimYeboah/laravel-chatroom/routes/channel.php)

```php
...
Broadcast::channel('message', function ($user) {
    return Auth::check();
});
...
```










