require('./bootstrap');
import Vue          from 'vue';
import VueRouter    from 'vue-router'
Vue.use(VueRouter)
window.Vue = require('vue');


//ALL IMPORT ROUTES COMPONENTS
import Home             from './components/staticWebsite/HomeComponent.vue';
import Workplace        from './components/staticWebsite/WorkplaceComponent.vue';
import Technique        from './components/staticWebsite/TechniqueComponent.vue';
import Register         from './components/authentification/RegisterComponent.vue';
import Login            from './components/authentification/LoginComponent.vue';
import UserDashboard    from './components/userDashboard/UserDashboardComponent.vue';
import AdminDashboard   from './components/adminDashboard/AdminDashboardComponent.vue';
import Payment          from './components/userDashboard/uDComponents/PaymentComponent.vue';
import legalMention     from './components/rgpd/legalNotice.vue';
import confidentiality  from './components/rgpd/confidentiality.vue';
import axios            from 'axios';

Vue.component('navbar-component', require('./components/NavbarComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

//ROUTES
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
     {
        path: '/mentions-legales',
        name: 'legalMention',
        component: legalMention
    },
      {
        path: '/politique-de-confidentialite',
        name: 'confidentiality',
        component: confidentiality
    },
    {
        path: '/workplace',
        name: 'workplace',
        component: Workplace
    },
    {
        path: '/technique',
        name: 'technique',
        component: Technique
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { noAuth: true }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { noAuth: true }

    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: UserDashboard,
        props:true,
        meta:{ authOnly: true}
    },
    {
        path: '/admin/dashboard',
        name: 'adminDashboard',
        component: AdminDashboard,
        props:true,
        meta: { authOnly: true, roleGuard: true },
        beforeEnter: (to, from, next) => {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/userRole').then((response) => {
                    console.log(response.data)
                    let roleTest = response.data
                    if (roleTest === 1) {
                        next()
                    }
                }).catch((errors) => {
                    next({
                            path: '/',
                            query: { redirect: to.fullPath }
                        })
                })

            })
        }
    },
    {
        path: '/payment/:id',
        name: 'payment',
        props:true,
        component: Payment,
        meta: { authOnly: true, notPayed:true, alreadyPayed: true },
        // beforeEnter: (to, from, next) => {
        //     console.log(to.params.id);
        //     axios.get('/sanctum/csrf-cookie').then(response => {
        //         axios.get('api/estimates/'+ to.params.id).then((response) => {
        //             let paymentValidation = response.data.data.paymentValidation
        //             if (paymentValidation === 'Non') {
        //                 next(false)
        //             }
        //         }).catch((errors) => {
        //             next({
        //                 path: '/dashboard',
        //                 // query: { redirect: to.fullPath }
        //             })
        //         })

        //     })
        // }
    }

];

const router = new VueRouter({ routes });

/*_______________________AUTH___________________________*/


function loggedIn() {
    // console.log(localStorage.getItem("auth"));
    return localStorage.getItem("auth");
}
// If NOT authentified you can't access to...
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authOnly)) {
    if (!loggedIn()) {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

// If authentified you can't access to....

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.noAuth)) {
        if (loggedIn() !== null) {
            next({
                path: '/',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next()
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.notPayed)) {
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get('api/estimates/' + to.params.id).then((response) => {
                let paymentValidation = response.data.data.paymentValidation
                if (paymentValidation === 'Non') {
                    next()
                    // throw Error

                }
            }).catch((errors) => {
                next({
                    path: '/dashboard',
                    query: { redirect: to.fullPath }
                })
            })

        })
    } else {
        next()
    }
});
/*_______________________Admin_Only________________________*/



const app = new Vue({
    el: '#app',
    router
});





