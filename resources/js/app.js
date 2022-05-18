require('./bootstrap');
import Vue from "vue";
import VueRouter from "vue-router";

// Router imported
import {routes} from "./routes"

Vue.use(VueRouter)


// VueRouter
const router = new VueRouter({
    mode: 'history',  // <- url'degi /#/ belgini olib tashlaydi
    routes,
})

// Import User Class
import User from "./Helpers/User";
window.User = User


// SWEET-ALERT
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 3000,
   timerProgressBar: true,
})
window.Toast = Toast


// Noty (notification)
import Notification from "./Helpers/Notification";
window.Notification = Notification


// Reload
window.Reload = new Vue();


// ROOT
const app = new Vue({
    el: '#app',
    router
});
