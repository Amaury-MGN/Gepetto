<template>
    <div>
        <div v-for='user in users' :key='user.id'>
            <div class='infos-title-user'>
                <h2>Mes Informations Personelles</h2>
            </div>
            <div class='infos-users-user' v-show='!editInformationsVisible'>
                <div >
                    <a type='button' @click='editInformationsVisible = true' v-show='!editInformationsVisible'><h5 class='button-informations-user'>Modifier mes Informations</h5></a>
                </div>
                <div class='infos-users-flex-container'>
                    <div class='table-display-user'>
                        <div class='infos-users-categories-user'><h5>Prénom :</h5></div>
                        <div class='infos-users-data-user'><h5>{{ user.firstname }}</h5></div>
                    </div>
                    <div class='table-display-user'>
                        <div class='infos-users-categories-user'><h5>Nom :</h5></div>
                        <div class='infos-users-data-user'><h5>{{ user.lastname }}</h5></div>
                    </div>
                    <div class='table-display-user'>
                        <div class='infos-users-categories-user'><h5>Nom de l'entreprise :</h5></div>
                        <div class='infos-users-data-user'><h5>{{ user.company }}</h5></div>
                    </div>
                    <div class='table-display-user'>
                        <div class='infos-users-categories-user'><h5>Nom d'utilisateur est :</h5></div>
                        <div class='infos-users-data-user'><h5>{{ user.pseudonym }}</h5></div>
                    </div>
                    <div class='table-display-user'>
                        <div class='infos-users-categories-user'><h5>Numéro de Téléphone :</h5></div>
                        <div class='infos-users-data-user'><h5>{{ user.phoneNumber }}</h5></div>
                    </div>
                    <div class='table-display-user'>
                        <div class='infos-users-categories-user'><h5>Votre adresse mail est :</h5></div>
                        <div class='infos-users-data-user'><h5>{{ user.email }}</h5></div>
                    </div>
                </div>
            </div>
            <form @submit.prevent>
                <div v-show='editInformationsVisible'>
                    <div class='infos-users-flex-container'>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Prénom :</h5></div>
                             <div  class='infos-users-data-user'>
                                <input type='text' aria-describedby='firstnameHelp' :placeholder='user.firstname' name='firstname' v-model='firstname'>
                                <p v-text='errors.firstname'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Nom :</h5></div>
                            <div  class='infos-users-data-user'>
                                <input type='text' aria-describedby='lastnameHelp' :placeholder='user.lastname' name='lastname' v-model='lastname'>
                                <p v-text='errors.lastname'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Nom de votre entreprise</h5><p>(facultatif) :</p></div>

                            <div  class='infos-users-data-user'>
                                <input type='text' aria-describedby='companyHelp' :placeholder='user.company' name='company' v-model='company'>
                                <p v-text='errors.company'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Nom d'utilisateur :</h5></div>
                            <div  class='infos-users-data-user'>
                                <input type='text' aria-describedby='pseudonymHelp' :placeholder='user.pseudonym' name='pseudonym' v-model='pseudonym'>
                                <p v-text='errors.pseudonym'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Numéro de téléphone</h5><p>(facultatif) :</p></div>
                            <div  class='infos-users-data-user'>
                                <input type='tel' aria-describedby='phoneNumberHelp' :placeholder='user.phoneNumber' name='phoneNumber' v-model='phoneNumber'>
                                <p v-text='errors.phoneNumber'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Adresse mail :</h5></div>
                            <div  class='infos-users-data-user'>
                                <input type='email' aria-describedby='emailHelp' :placeholder='user.email' name='email' v-model='email'>
                                <p v-text='errors.email'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Mot de passe :</h5></div>
                            <div  class='infos-users-data-user'>
                                <input type='password' aria-describedby='passwordHelp' placeholder='Password' name='password' v-model='password'>
                                <p v-text='errors.password'></p>
                            </div>
                        </div>
                        <div class='table-display-user'>
                            <div class='infos-users-categories-user'><h5>Confirmation de mot de passe :</h5></div>
                            <div  class='infos-users-data-user'>
                                <input type='password' aria-describedby='confirmedPasswordHelp' placeholder='Confirmer votre mot de passe' name='password_confirmation' v-model='passwordConfirmation'>
                                <p v-text='errors.passwordConfirmation'></p>
                            </div>
                        </div>
                        <div class='display-container'>
                            <div class='form-confirmation-user-data'>
                                <a type='submit' @click='editInformations(user.id)' v-show='editInformationsVisible'><h5 class='validate-informations-user'>Enregistrer les Modifications</h5></a>
                                <a @click='editInformationsVisible = false' v-show='editInformationsVisible'><h5 class='validate-informations-user'>Annuler</h5></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
 export default {
    name: 'User',
    data(){
    return{
        users:{},
        // informations edition
        firstname:'',
        lastname:'',
        company:'',
        phoneNumber:'',
        pseudonym:'',
        email:'',
        password:'',
        passwordConfirmation:'',
        errors:'',

        // Show/hide information div
        editInformationsVisible:false,
        // Local storage
        id:localStorage.getItem('id'),
        token:localStorage.getItem('token')
    }
    },
    created(){
        this.userInformations()
    },
    methods: {
        userInformations(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`,
            axios.get(`api/user/${this.id}`)
            .then((response) => {
                this.users = response.data
                console.log(response.data)
            }).catch((error)=>
                console.log(error)
            )
        },
        editInformations($id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            if(this.firstname==='' && this.lastname==='' &&
            this.company==='' && this.phoneNumber==='' && this.pseudonym===''
            && this.email==='' && this.password===''&& this.passwordConfirmation===''){
                this.editInformationsVisible = false
            }else{
                axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(`api/auth/editInformations/${$id}`, {
                        firstname: this.firstname,
                        lastname: this.lastname,
                        company: this.company,
                        phoneNumber: this.phoneNumber,
                        pseudonym: this.pseudonym,
                        email: this.email,
                        password: this.password,
                        passwordConfirmation: this.passwordConfirmation

                    }). then ((response) => {
                        console.log(response);
                        this.firstname = this.lastname = this.company = this.phoneNumber =this.pseudonym = this.email = this.password = this.passwordConfirmation =''
                        this.errors=''
                        this.editInformationsVisible = false
                        this.userInformations()
                    }).catch ((errors) => {
                        this.errors = errors.response.data.errors;
                        console.log(errors.response.data.errors);

                    })
                })
            }
        },
    },
    mounted(){
        // this.$emit(userInformations());
    }
 }

</script>
