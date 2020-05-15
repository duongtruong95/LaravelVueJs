import firebase from "firebase";

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

export default messaging
