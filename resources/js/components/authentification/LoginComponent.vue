<template>
    <div>
        <div class='nav-false-background'></div>
        <div class='background-auth'>
            <div class='main-title-auth'>
                <h1>GEPETTO</h1>
            </div>
            <div class='title-auth'>
                <h2>S'identifier</h2>
            </div>
            <div class='container-auth'>
                <form class='form-auth'>
                    <div>
                        <div><label for='inputEmail'>Adresse email</label></div>
                        <div><input type='email' aria-describedby='emailHelp' placeholder='Entrez votre adresse e-mail' name='inputEmail' v-model='email'></div>

                        <div><p v-text="errors.email"></p></div>
                    </div>
                    <div>
                        <div><label for='inputPassword'>Mot de Passe</label></div>
                        <div><input type='password' aria-describedby="passwordHelp" placeholder='Entrez votre mot de passe' name='inputPassword' v-model='password'></div>
                        <div><p v-text='errors.password'></p></div>
                    </div>
                    <div class='center-informations'>
                        <p class='cookies-informations'>En vous connectant, vous acceptez les Conditions générales de GEPETTO. Veuillez consulter notre Notice Protection de vos informations personnelles et notre Notice Cookies.</p>
                    </div>
                    <!-- <div class='form-check'>
                        <input type='checkbox'>

                        <label for='RGPD'>Accepter les conditions d'utilisation</label>
                    </div> -->
                    <input type='submit' @click='userLogin' placeholder='Se Connecter'>
                    <div>
                        <router-link to="/register" class='link-auth'>Je n'ai pas de compte</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return{
                email:'',
                password:'',
                token:'',
                auth:'',
                id:'',
                errors:'',
                role:''
            }
        },

        methods:{

            userLogin(e){
                e.preventDefault();
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/auth/login', {
                        email: this.email,
                        password: this.password,

                    }).then ((response) => {
                        console.log(response)


                        this.email = this.password =''
                        this.errors=''
                        this.token=response.data.data.token
                        this.name=response.data.data.name
                        this.id=response.data.data.id
                        this.role=response.data.data.role
                        console.log(this.token)
                        window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                        localStorage.setItem("token", this.token)
                        localStorage.setItem("id", this.id)
                        localStorage.setItem("auth", true)
                        if (this.role === 1){
                            this.$router.push(`/admin/dashboard`)
                        } if (this.role === 2){
                            this.$router.push(`/dashboard`)
                        } else {
                            console.log('Aucune page ne correspond à votre demande')
                            his.$router.push(`/`)
                        }

                    }).catch ((errors) => {
                        console.log(errors.response);
                        this.errors = {

                            email:'Email Invalide',
                            password:'Mot de Passe Invalide'
                        };
                    }).finally(()=>{
                        console.log(this.errors)
                    })

                })
            },
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
