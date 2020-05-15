<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js"></script>
    <!-- For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics. -->
    <script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-analytics.js"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .cursor-p {
            cursor: pointer;
        }
    </style>
{{--    <link href="{{ mix('css/style.css') }}" rel="stylesheet">--}}
</head>
<body>
<div id="app">
    <example-component></example-component>
</div>
<script src="/js/app.js"></script>
<script>
    let config = {
        apiKey: "AIzaSyBkBQr8hRPB16A6rcC5NLMZUZScM9slDzY",
        authDomain: "rpj-vue.firebaseapp.com",
        databaseURL: "https://rpj-vue.firebaseio.com",
        projectId: "rpj-vue",
        storageBucket: "rpj-vue.appspot.com",
        messagingSenderId: "23595975905",
        appId: "1:23595975905:web:09463c9af3d73da648a3a0",
        measurementId: "G-48R63J06Y6"
    };
    firebase.initializeApp(config);
    const messaging = firebase.messaging();
    messaging.onMessage((payload) => {
        alert('Có thông báo mới!!', payload);
        // ...
    });
</script>
</body>
</html>
