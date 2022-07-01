<template>
    <div>
        <div class="add-new-members">
            <button @click='isModalNewUserVisble=true, successNewUser=false'>+ Ajouter un nouvel utilisateur</button>
        </div>
        <Modal v-show="isModalNewUserVisble" @close="closeModal">
            <!-- Show DB named estimates -->
            <template v-slot:header>
                <h3>Enregistrer un nouvel utilisateur</h3>
            </template>
            <template v-slot:body>
                <div class='infos-users-categories-user' v-show='successNewUser' >
                    <h5 >Félicitation, vous avez bien enregistrer le nouvel utilisateur</h5>
                </div>
                <div v-show='!successNewUser'>
                    <form @submit.prevent>
                        <div class='infos-users-flex-container'>
                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Rôle</h5></div>
                                <select v-model='role'>
                                    <option value="">--Choisissez une option--</option>
                                    <option value="1">Admin</option>
                                    <option value="3">Employé</option>
                                    <option value="2">Client</option>
                                </select>
                            </div>
                            <p v-text='errors.role'></p>
                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Prénom</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="text" aria-describedby="firstnameHelp" placeholder="Entrez votre prénom" name='firstname' v-model="firstname">
                                </div>
                            </div>
                            <p v-text='errors.firstname'></p>

                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Nom de Famille</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="text" aria-describedby="lastnameHelp" placeholder="Entrez votre nom de famille" name='lastname' v-model="lastname">
                                </div>
                            </div>
                            <p v-text='errors.lastname'></p>

                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Nom de l'entreprise (facultatif)</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="text" aria-describedby="companyHelp" placeholder="Entrez le nom de votre entreprise" name='company' v-model="company">
                                </div>
                            </div>
                            <p v-text='errors.company'></p>


                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Numéro de téléphone (facultatif)</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="tel" aria-describedby="phoneNumberHelp" placeholder="Entrez votre numéro de Téléphone" name='phoneNumber' v-model="phoneNumber">
                                </div>
                            </div>
                            <p v-text='errors.phoneNumber'></p>


                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Nom d'utilisateur</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="text" aria-describedby="pseudonymHelp" placeholder="Entrez votre nom d'utilisateur" name='pseudonym' v-model="pseudonym">
                                </div>
                            </div>
                            <p v-text='errors.pseudonym'></p>


                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Adresse mail</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="email" aria-describedby="emailHelp" placeholder="Entrez votre adresse mail" name='email' v-model="email">
                                </div>
                            </div>
                            <p v-text='errors.email'></p>


                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Mot de passe</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="password" aria-describedby="passwordHelp" placeholder="Password" name='password' v-model="password">
                                </div>
                            </div>
                            <p v-text='errors.password'></p>


                            <div class='table-display-user'>
                                <div class='infos-users-categories-user'><h5>Mot de passe</h5></div>
                                <div class='infos-users-data-user'>
                                    <input type="password" aria-describedby="confirmedPasswordHelp" placeholder="Confirmer votre mot de passe" name='password_confirmation' v-model="passwordConfirmation">
                                </div>
                            </div>
                            <p v-text='errors.c_password'></p>


                            <div class='display-container'>
                                <div class='form-confirmation-user-data'>
                                    <a type='submit' @click='createNewUser'><h5 class='validate-informations-user'>Enregistrer</h5></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </template>
            <template v-slot:footer>
                Enregistrement d'un nouvel Utilisateur
            </template>
        </Modal>
        <div>
            <div>
                <div class='searchbar-results' v-if="this.q && getFilteredUsers.length > 1">
                    <p>Il existe {{ getFilteredUsers.length }} Utilisateurs</p>
                </div>
                <div class='searchbar-results' v-if="this.q && getFilteredUsers.length === 1">
                    <p>Il existe {{ getFilteredUsers.length }} Utilisateur</p>
                </div>
                <div class='searchbar-results' v-else-if="this.q && getFilteredUsers.length===0">
                    <p>Aucune correspondance trouvée</p>
                </div>
            </div>
            <div class='searchbar-title-results' v-if='this.q && getFilteredUsers.length >= 1'>
                <div class='searchbar-title-results'>
                    <h5>Résultat de la recherche</h5>
                </div>
            </div>
            <table class='table-size' v-if='this.q && getFilteredUsers.length >= 1'>
                <thead class='table-color'>
                    <tr>
                        <th>
                            <p>Prénom</p>
                        </th>
                        <th>
                            <p>Nom de famille</p>
                        </th>
                        <th>
                            <p>Entreprise</p>
                        </th>
                        <th>
                            <p>Numéro de Téléphone</p>
                        </th>
                        <th>
                            <p>Nom d'utilisateur</p>
                        </th>
                        <th>
                            <p>Email</p>
                        </th>
                        <th>
                            <p>Rôle</p>
                        </th>
                        <th>
                            <p>Date de création</p>
                        </th>
                        <th>
                            <p>Dernière modification</p>
                        </th>
                    </tr>
                </thead>
                <tbody class='table-color-tbody' v-for='user in getFilteredUsers' v-bind:key='user.id' >
                    <tr :class="{'table-color-shading-2':user.id% 2 === 0, 'table-color-shading-1':user.id% 2 !== 0 }">
                        <td>
                            <p>{{ user.firstname }}</p>
                        </td>
                        <td>
                            <p>{{ user.lastname }}</p>
                        </td>
                        <td>
                            <p>{{ user.company }}</p>
                        </td>
                        <td>
                            <p>{{ user.phoneNumber }}</p>
                        </td>
                        <td>
                            <p>{{ user.pseudonym }}</p>
                        </td>
                        <td>
                            <p>{{ user.email }}</p>
                        </td>
                        <td>
                            <p>{{ user.role }}</p>
                        </td>

                        <td>
                            <p>{{ user.created_at }}</p>
                        </td>
                        <td>
                            <p>{{ user.updated_at }}</p>
                        </td>
                    </tr>
                </tbody>
                <div class='searchbar-footer'></div>
            </table>
        </div>
        <table class='table-size'>
            <thead class='table-color'>
                <tr>
                    <th>
                        <p>Prénom</p>
                    </th>
                    <th>
                        <p>Nom de famille</p>
                    </th>
                    <th>
                        <p>Entreprise</p>
                    </th>
                    <th>
                        <p>Numéro de Téléphone</p>
                    </th>
                    <th>
                        <p>Nom d'utilisateur</p>
                    </th>
                    <th>
                        <p>Email</p>
                    </th>
                    <th>
                        <p>Rôle</p>
                    </th>
                    <th>
                        <p>Date de création</p>
                    </th>
                    <th>
                        <p>Dernière modification</p>
                    </th>
                </tr>
            </thead>
            <tbody  class='table-color-tbody' v-for='user in paginationsUsers.data' v-bind:key='user.id'>
                <!-- <tr v-if='user.id=nbr%2==0'> -->
                <tr :class="{'table-color-shading-2':user.id% 2 === 0, 'table-color-shading-1':user.id% 2 !== 0 }">
                    <td>
                        <p>{{ user.firstname }}</p>
                    </td>
                    <td>
                        <p>{{ user.lastname }}</p>
                    </td>
                    <td>
                        <p>{{ user.company }}</p>
                    </td>
                    <td>
                        <p>{{ user.phoneNumber }}</p>
                    </td>
                    <td>
                        <p>{{ user.pseudonym }}</p>
                    </td>
                    <td>
                        <p>{{ user.email }}</p>
                    </td>
                    <td>
                        <p>{{ user.role }}</p>
                    </td>

                    <td>
                        <p>{{ user.created_at }}</p>
                    </td>
                    <td>
                        <p>{{ user.updated_at }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination :data="paginationsUsers" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
import Modal from './../../ModalComponent.vue';
 export default {
    components: {
            Modal,
    },
    name: 'Users',
    props:{
        'q':'',
        'users':Array,
        'paginationsUsers':Object,
    },
    data(){
    return{
        token:localStorage.getItem('token'),
        // Modal
            isModalNewUserVisble:false,
            successNewUser:false,
        // Form v-model
            role:'',
            firstname:'',
            lastname:'',
            company:'',
            phoneNumber:'',
            pseudonym:'',
            email:'',
            password:'',
            passwordConfirmation:'',
            errors:'',
            index:''


}
    },

    methods: {
        createNewUser(){
            axios.post('api/auth/adminRegister', {
                role:this.role,
                firstname: this.firstname,
                lastname: this.lastname,
                company: this.company,
                phoneNumber: this.phoneNumber,
                pseudonym: this.pseudonym,
                email: this.email,
                password: this.password,
                passwordConfirmation: this.passwordConfirmation

            }).then((response) => {
                console.log(response)
                this.firstname = this.lastname = this.company = this.phoneNumber =this.pseudonym = this.email = this.password = this.passwordConfirmation =''
                this.errors=''
                this.successNewUser=true
                this.searchRequests()
            }).catch ((errors) => {
                this.errors = errors.response.data.errors;
                console.log(errors);
            });
        },
        getResults(page = 1) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/users?page=' + page)
                    .then(response => {
                        this.paginationsUsers = response.data;
                        console.log('test pagination',this.paginationsUsers.data)
                    });
            })
        },
        closeModal() {
            this.isModalNewUserVisble=false;
        },

    },

    computed: {
        getFilteredUsers() {
            const lowerCaseSearch = this.q.toLowerCase()
            console.log(this.users,'je ne comprends pas')
            return this.users.filter(
                user => {
                    return user.pseudonym.toLowerCase().includes(lowerCaseSearch)
                    || user.email.toLowerCase().includes(lowerCaseSearch)
                    || user.firstname.toLowerCase().includes(lowerCaseSearch)
                    || user.lastname.toLowerCase().includes(lowerCaseSearch)
                    || user.company.toLowerCase().includes(lowerCaseSearch)
                    || user.pseudonym.toLowerCase().includes(lowerCaseSearch)
                    || user.phoneNumber.toLowerCase().includes(lowerCaseSearch);
                },
            )
        },
    },
    mounted(){
        // this.searchRequests();
        // this.getResults();
        console.log('Users Mounted',this.q)
    }
 }

</script>
