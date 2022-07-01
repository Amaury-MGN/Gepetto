<template>
    <div class='user-background-image'>
        <div class='nav-false-background'></div>
        <div class="container">
        </div>
        <div class='container-display-user'>

                <div class='menu-dashboard-user'>
                    <div class='menu-category-size-user-first-menu'>
                        <a v-show='isUsersVisible' @click='getResultsUsers();searchRequestsUsers();showUsers()'><h5>Utilisateurs</h5></a>
                        <a v-show='!isUsersVisible' @click='hideAll();'><h5>Utilisateurs</h5></a>
                    </div>
                    <div class='menu-category-size-user'>
                        <a v-show='!isEstimatesVisible' @click='getResultsEstimates();searchRequestsEstimates();showEstimates()'><h5>Devis</h5></a>
                        <a v-show='isEstimatesVisible' @click='hideAll()'><h5>Devis</h5></a>
                    </div>
                    <div class='menu-category-size-user'>
                        <a v-show='!isOrdersVisible' @click='getResultsOrders();searchRequestsOrders();showOrders()'><h5>Commandes</h5></a>
                        <a v-show='isOrdersVisible' @click='hideAll()'><h5>Commandes</h5></a>
                    </div>
                    <div class='menu-category-size-user'>
                        <a v-show='!isEditVisible' @click='showEdit()'><h5>Editer le site</h5></a>
                        <a v-show='isEditVisible' @click='hideAll()'><h5>Editer le site</h5></a>
                    </div>
                    <div class='menu-category-size-user'>
                        <a v-show='!isContactVisible' @click='getResultsTickets();searchRequestTickets(),showContact()'><h5>Tickets1</h5></a>
                        <a v-show='isContactVisible' @click='hideAll()'><h5>Tickets2</h5></a>
                    </div>
                </div>



            <div class='flex-information-user display-dashboard-user background-color-user'>
                <div class='infos-title-user' v-show='isWelcomeVisible'>
                    <h2>Bienvenue sur votre page de contrôle</h2>
                </div>
                <div class="form-auth searchbar-ad" v-if='hideUsers==true || hideEstimates==true||hideOrders==true||hideContact==true'>
                    <div><input type='text' placeholder='Rechercher...' name='inputSearch' v-model='q'></div>
                </div>

                <!-- Users -->

                <div v-show='hideUsers'>
                    <Users :q='q' :users='users' :paginationsUsers='paginationsUsers'></Users>
                </div>

                <!-- Estimates -->

                <div v-show='hideEstimates'>
                    <Estimates :q='q' :paginationsEstimates='paginationsEstimates' :estimates='estimates'></Estimates>

                </div>

                <!-- Orders -->

                <div v-show='hideOrders'>
                <Orders :q='q' :orders='orders' :paginationsOrders='paginationsOrders'></Orders>
                </div>

                <!-- Edit Posts static Website -->

                <div class='edit-images-positions-titles' v-show='editStaticWebsite'>

                    <div class='edit-images-titles'>
                        <button @click='editImages=!editImages;editPosts=false'><h5>Modifier les images</h5></button>
                    </div>
                    <div class='edit-posts-titles'>
                        <button @click='editPosts=!editPosts;editImages=false'><h5>Modifier les posts</h5></button>
                    </div>
                </div>
                <div v-show='editStaticWebsite'>
                    <div class=' display-dashboard-user' v-show='editImages'>
                        <EditImagesWebSite></EditImagesWebSite>
                    </div>
                </div>
                <div class=' display-dashboard-user' v-show='editPosts'>
                    <EditPostsWebSite></EditPostsWebSite>
                </div>
                <div v-show='hideContact'>
                    <Contact :q='q' :tickets='tickets' :paginationsTickets='paginationsTickets'></Contact>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Modal                from './../ModalComponent.vue';
    import Users                from './aDComponents/aDUsersComponent.vue';
    import Estimates            from './aDComponents/aDEstimatesComponent.vue';
    import Orders               from './aDComponents/aDOrdersComponent.vue';
    import EditImagesWebSite    from './aDComponents/aDEditImagesWebsiteComponent.vue';
    import EditPostsWebSite     from './aDComponents/aDEditPostsWebsiteComponent.vue';
    import Contact              from './aDComponents/aDContactComponent.vue';
    export default {
        components: {
            Modal,
            Users,
            Estimates,
            Orders,
            EditImagesWebSite,
            EditPostsWebSite,
            Contact,
        },
        data(){
            return {
                token:localStorage.getItem('token'),

                // Variables' function
                users:[],
                paginationsUsers:{},
                estimates:[],
                orders:[],
                paginationsOrders:{},
                paginationsEstimates:{},
                tickets:[],
                paginationsTickets:{},
                fileId:0,

                // Table Seek and Hide
                hideUsers:true,
                hideEstimates:false,
                hideOrders:false,
                hideEditOrder:false,
                hideContact:false,
                isWelcomeVisible:true,
                isUsersVisible:true,
                isEstimatesVisible:false,
                isOrdersVisible:false,
                isEditVisible:false,
                isContactVisible:false,

                // edit Static website
                editStaticWebsite:false,
                editImages:false,
                editPosts:false,
                //SearchBar
                q: '',
            }
        },
        methods:{
            searchRequestsUsers(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/usersSearch`).then ((response) =>{
                        console.log(response);
                        this.users=response.data.data
                    }).catch ((errors) => {
                        console.log(errors);
                    })
                });
            },
            searchRequestsEstimates(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/estimatesSearch`).then ((response) =>{
                        this.estimates=response.data.data
                        console.log(this.estimates)
                    }).catch ((errors) => {
                        console.log(errors.response);
                    })
                });
            },
            searchRequestsOrders() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/ordersSearch`).then ((response) =>
                        {
                            this.orders=response.data.data
                        }).catch ((errors) => {
                            console.log(errors.response);
                    })
                });
            },
            searchRequestTickets(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                 axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/ticketsSearch`).then ((response) =>
                        {
                            this.tickets=response.data.data
                        }).catch ((errors) => {
                            console.log(errors.response);
                    })
                });
            },
            getResultsUsers(page = 1) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/users?page=' + page)
                    .then(response => {
                        this.paginationsUsers = response.data;
                    });
                })
            },
            getResultsEstimates(page = 1) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/estimates?page=' + page)
                    .then(response => {
                        this.paginationsEstimates = response.data;
                    });
                })
            },
            getResultsOrders(page = 1) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/orders?page=' + page)
                    .then(response => {
                        this.paginationsOrders = response.data;
                    });
                })
            },
            getResultsTickets(page = 1) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/tickets?page=' + page)
                    .then(response => {
                        this.paginationsTickets = response.data;
                    });
                })
            },
            hideAll(){
                this.hideUsers=false
                this.hideEstimates=false
                this.hideOrders=false
                this.editStaticWebsite=false
                this.isUsersVisible=true
                this.isEstimatesVisible=false
                this.isOrdersVisible=false
                this.isEditVisible=false
                this.hideContact=false
                this.isContactVisible=false
            },
            showUsers(){
                this.hideUsers=true
                this.hideEstimates=false
                this.hideOrders=false
                this.editStaticWebsite=false
                this.isUsersVisible=false
                this.isEstimatesVisible=false
                this.isOrdersVisible=false
                this.isEditVisible=false
                this.hideContact=false
                this.isContactVisible=false
            },
            showEstimates(){
                this.hideUsers=false
                this.hideEstimates=true
                this.hideOrders=false
                this.editStaticWebsite=false
                this.isUsersVisible=true
                this.isEstimatesVisible=true
                this.isOrdersVisible=false
                this.isEditVisible=false
                this.hideContact=false
                this.isContactVisible=false
            },
            showOrders(){
                this.hideUsers=false
                this.hideEstimates=false
                this.hideOrders=true
                this.editStaticWebsite=false
                this.isUsersVisible=true
                this.isEstimatesVisible=false
                this.isOrdersVisible=true
                this.isEditVisible=false
                this.hideContact=false
                this.isContactVisible=false
            },
            showEdit(){
                this.hideUsers=false
                this.hideEstimates=false
                this.hideOrders=false
                this.editStaticWebsite=true
                this.isUsersVisible=true
                this.isEstimatesVisible=false
                this.isOrdersVisible=false
                this.isEditVisible=true
                this.hideContact=false
                this.isContactVisible=false
            },
            showContact(){
                this.hideUsers=false
                this.hideEstimates=false
                this.hideOrders=false
                this.editStaticWebsite=false
                this.isUsersVisible=false
                this.isEstimatesVisible=false
                this.isOrdersVisible=false
                this.isEditVisible=false
                this.hideContact=true
                this.isContactVisible=true
            }

        },
        mounted() {
            this.searchRequestsUsers()
            this.searchRequestsEstimates()
            this.searchRequestsOrders()
            this.searchRequestTickets()
            this.getResultsUsers()

        },

    }
    </script>
