<template>
   <!-- <div class="lsh_topNav" id="lsh_topNav"> -->
   <div>
        <div class='topnav' id='myTopnav'>
            <div class='topnav-display'>
                <router-link to='/' class='nav-iconeHover'><img src="storage/images/logo-cerf.png"/></router-link>
                <router-link to='/'>Accueil</router-link>
                <router-link to='/workplace'>Notre Entreprise</router-link>
                <router-link to='/technique'>Nos Techniques</router-link>

            <!-- <div class='nav-account-link'> -->
                <!-- If user is NOT LoggedIn -->
                <router-link to='/register' class='nav-account-link' v-if='!id'>Enregistrement</router-link>
                <router-link to='/login' class='nav-account-link' v-if='!id'>Se Connecter</router-link>
                <!-- If user is LoggedIn -->
                <a class='nav-account-link' @click='rolebased' v-if='id'>Mon Espace</a>
                <a class='nav-account-link' @click='logout' v-if='id'>Se Déconnecter</a>
</div>
                <a href='javascript:void(0);' class='icon' @click='navResponsive()'>
                    <i class='fa fa-bars'></i>
                </a>

       </div>
   </div>
</template>

<script>
    export default {
        data(){
            return{
                id:localStorage.getItem('id'),
                token:localStorage.getItem('token')
            }
        },
        methods:{
            navResponsive() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            },
            rolebased(e){
                e.preventDefault();
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.get('sanctum/csrf-cookie').then(response => {

                    axios.get(`api/user/${this.id}`).then ((response) =>
                        {
                            this.role=response.data.user.role
                            if (this.role === 1){
                                this.$router.push(`/admin/dashboard`)
                            } if (this.role === 2){
                                this.$router.push(`/dashboard`)
                            } else {
                                console.log('Aucune page ne correspond à votre demande')
                            }
                        }).catch ((errors) => {
                            console.log(errors.response);
                        })
                })
            },
            setupData(){
                    this.id=localStorage.getItem('id')
                    this.token=localStorage.getItem('token')
                },
            logout(){

                axios.post('api/auth/logout').then((response) => {
                    // console.log(this.token)
                    localStorage.removeItem('auth')
                    localStorage.removeItem('token')
                    localStorage.removeItem('id')

                    this.$router.push('/login')
                    // config

                }).catch((errors) => {
                    console.log(errors)
                    localStorage.removeItem('auth')
                    localStorage.removeItem('token')
                    localStorage.removeItem('id')

                    this.$router.push('/login')


                })
            },
        },
        watch: {
            $route (to, from) {
            this.setupData()
            }
        },
        mounted() {
            console.log('Component mounted.')
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        },


    }
</script>
