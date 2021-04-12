/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component("rol", require("./components/Rol.vue").default);
Vue.component("user", require("./components/User.vue").default);

Vue.component("categoria", require("./components/Categoria.vue").default);
Vue.component("campo", require("./components/Campus.vue").default);
Vue.component("escuela", require("./components/Escuela.vue").default);
Vue.component("taller", require("./components/Taller.vue").default);
Vue.component("promotor", require("./components/Promotor.vue").default);
Vue.component("alumno", require("./components/AlumnoTaller.vue").default);
Vue.component("matriculado", require("./components/Matriculado.vue").default);

//--------------------------

const app = new Vue({
    el: "#app",
    data: {
        menu: 0,
        campus : 0
    },
});
