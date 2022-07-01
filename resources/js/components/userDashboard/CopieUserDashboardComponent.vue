<template>
    <div>
        <div class='lsh_container-display'>
            <div class='lsh_flex-information lsh_menu-user-dashboard'>
                <div>
                    <h1 v-for='user in users' :key='user.id' >Bienvenue {{ user.name }}</h1>
                </div>
                <div>
                    <button class="btn" @click='isHiddenInformations'>
                        <h5>Mes informations</h5>
                    </button>
                </div>
                <div>
                    <button type="button" class="btn" @click="showModal">
                        <h5>Demander un devis</h5>
                    </button>
                </div>
                <div>
                    <button class="btn" @click='estimatesIndex();IsHiddenEstimateUser()'>
                        <h5 >Mes Devis</h5>
                    </button>
                </div>
                <div>
                    <button class="btn" @click='ordersIndex();IsHiddenOrderUser()'>
                        <h5>Mes Commandes</h5>
                    </button>
                </div>
            </div>
            <div class='lsh_flex-information lsh_display-user-dashboard'>
                <div v-show="isInformationsVisible">
                <User></User>
                    <!-- <div v-for='user in users' :key='user.id'>
                        <div>
                            <button @click='editInformationsVisible = true' v-show='!editInformationsVisible'>Modifier mes Informations</button>
                            <!-- <button type='submit' @click='editInformations(user.id)' v-show='editInformationsVisible'>Enregistrer les Modifications</button> -->
                        <!--</div>
                        <div v-show='!editInformationsVisible'>
                            <h5>Prénom : {{ user.firstname }}</h5>
                            <h5>Nom : {{ user.lastname }}</h5>
                            <h5 id='companyName'>Nom de l'entreprise : {{ user.company }}</h5>
                            <h5 id='userPhoneNumber'>Numéro de Téléphone : {{ user.phoneNumber }}</h5>
                            <h5>Nom d'utilisateur est : {{ user.pseudonym }}</h5>
                            <h5>votre adresse mail est : {{ user.email }}</h5>
                            <!-- <h5>Mofifier mon mot de passe</h5> -->
                        <!--</div>
                        <form @submit.prevent>
                            <div>
                            <button type='submit' @click='editInformations(user.id)' v-show='editInformationsVisible'>Enregistrer les Modifications</button>
                            <button @click='editInformationsVisible = false' v-show='editInformationsVisible'>Annuler</button>
                            </div>
                            <div v-show='editInformationsVisible'>
                                <div>
                                    <label for="inputFirstname">Prénom</label>
                                    <input type="text" aria-describedby="firstnameHelp" :placeholder="user.firstname" name='firstname' v-model="firstname">
                                    <p v-text='errors.firstname'></p>
                                </div>
                                <div>
                                    <label for="inputLastname">Nom de Famille</label>
                                    <input type="text" aria-describedby="lastnameHelp" :placeholder="user.lastname" name='lastname' v-model="lastname">
                                    <p v-text='errors.lastname'></p>
                                </div>
                                <div>
                                    <label for="inputCompany">Nom de votre entreprise (facultatif)</label>
                                    <input type="text" aria-describedby="companyHelp" :placeholder="user.company" name='company' v-model="company">
                                    <p v-text='errors.company'></p>
                                </div>
                                <div>
                                    <label for="inputPhoneNumber">Numéro de téléphone (facultatif)</label>
                                    <input type="tel" aria-describedby="phoneNumberHelp" :placeholder="user.phoneNumber" name='phoneNumber' v-model="phoneNumber">
                                    <p v-text='errors.phoneNumber'></p>
                                </div>
                                <div>
                                    <label for="inputPseudonym">Nom d'utilisateur</label>
                                    <input type="text" aria-describedby="pseudonymHelp" :placeholder="user.pseudonym" name='pseudonym' v-model="pseudonym">
                                    <p v-text='errors.pseudonym'></p>
                                </div>
                                <div>
                                    <label for="inputEmail">Adresse mail</label>
                                    <input type="email" aria-describedby="emailHelp" :placeholder="user.email" name='email' v-model="email">
                                    <p v-text='errors.email'></p>
                                </div>
                                <div>
                                    <label for="inputPassword">Password</label>
                                    <input type="password" aria-describedby="passwordHelp" placeholder="Password" name='password' v-model="password">
                                    <p v-text='errors.password'></p>
                                </div>
                                <div>
                                    <label for="inputConfirmedPassword">Mot de passe</label>
                                    <input type="password" aria-describedby="confirmedPasswordHelp" placeholder="Confirmer votre mot de passe" name='password_confirmation' v-model="passwordConfirmation">
                                    <p v-text='errors.passwordConfirmation'></p>
                                </div>
                            </div>
                        </form>
                    </div> -->
                </div>
                <div v-show='isEstimatesUserVisible'>
                    <!-- <p>Love</p> -->
                    <!-- <div v-show='isEstimatesUserVisible' class='lsh_cards-container'>
                        <div class='lsh_estimate-cards' v-for='estimatesUser in estimatesUsers' :key='estimatesUser.id'>
                            <div>
                                <p>Titre du devis : {{ estimatesUser.estimateName }} </p>
                            </div>
                            <div>
                                <p>Numéro du Devis : {{ estimatesUser.estimateNumber }} </p>
                            </div>
                            <div>
                                <p>Nombre de pièces souhaitées : {{ estimatesUser.estimateItemNumber }}</p>
                            </div>
                            <div>
                                <button @click='estimateById(estimatesUser.id);isHiddenEstimateById()'>Voir le devis</button>
                            </div>
                        </div>
                    </div>
                    <div v-show='isEstimateByIdVisible' >
                        <div>
                            <div>
                                <p>Titre du Devis : {{ estimateUserByIds.estimateName }}</p>
                            </div>
                            <div>
                                <p>Numéro du Devis : {{ estimateUserByIds.estimateNumber }}</p>
                            </div>
                            <div>
                                <p>Nombre de pièces souhaitée: {{ estimateUserByIds.estimateItemNumber }}</p>
                            </div>
                        </div>
                        <div>
                            <button v-show='!isAdminResponseVisible' @click='isHiddenEstimateAdminResponse'>Voir mon message</button> <!-- Quand je clique sur ce bouton j'active UserContents et je referme AdminContents -->
                            <!-- <button v-show='isAdminResponseVisible' @click='isAdminResponseVisible=!isAdminResponseVisible'>Voir la réponse de Gepetto</button> Fait l'inverse -->
                        <!-- </div>
                        <div v-show='!isAdminResponseVisible'>
                           <div v-show='adminResponse'>
                               <p id='adminContents'>test admin contents : {{estimateAdminByIds.estimateAdminContents}}</p>
                               <p id='adminPrice'>Prix du devis: {{ estimateAdminByIds.estimateAdminPrice }} euros</p>
                            </div>
                            <div v-show='!adminResponse'>
                                <p id='adminContents'>Vous n'avez pas encore reçu de réponse de la part de notre entreprise</p>
                                <p id='adminPrice'>Aucun prix n'a encore été défini pour votre devis</p>
                            </div>
                            <div>
                                <button v-show='adminResponse' @click='ddlEstimatesAdminFile(estimateUserByIds.id,estimateUserByIds.estimateNumber)'>Devis à télécharger</button>
                            </div>
                            <div>
                                <button v-show='adminResponse' @click.prevent='paymentPage(estimateUserByIds.id)'>Payer</button>
                            </div>
                        </div>
                        <div v-show='isAdminResponseVisible'>
                            <p>{{ estimateUserByIds.estimateContents }}</p>
                        </div>
                    </div> -->
                    <Estimates :estimatesUsers='estimatesUsers'></Estimates>
                </div>
                <div v-show='isOrderUserVisible'>
                    <!-- <div v-show='isOrderUserVisible' class='lsh_cards-container'>
                        <div class='lsh_estimate-cards' v-for='orderUser in ordersUsers' :key='orderUser.id'>
                            <div>
                                <p>Numéro de la commande : {{ orderUser.orderNumber }} </p>
                            </div>
                            <div>
                                <p>Nombre de pièces souhaitées : {{ orderUser.orderItems }}</p>
                            </div>
                            <div>
                                <p>Prix de la commande: {{ orderUser.orderPrice }} euros</p>
                            </div>
                            <div>
                                <button @click='orderById(orderUser.id);isHiddenOrderById()'>Plus de détails</button>
                            </div>
                        </div>
                    </div>
                    <div v-show='isOrderByIdVisible' >
                        <div>
                            <div>
                                <p>Titre de la commande : {{ orderUserByIds.orderName }}</p>
                            </div>
                            <div>
                                <p>Numéro de la commande : {{ orderUserByIds.orderNumber }}</p>
                            </div>
                            <div>
                                <p>Nombre de pièces souhaitée: {{ orderUserByIds.orderItems }}</p>
                            </div>
                            <div>
                                <p>Prix de la commande: {{ orderUserByIds.orderPrice }} euros</p>
                            </div>
                            <div>
                                <p>Statut de la commande : {{ orderUserByIds.orderProgress }} </p>
                            </div>
                            <div>
                                <p>Commande acceptée le : {{ orderUserByIds.created_at }} </p>
                            </div>
                            <div>
                                <p>Dernière actualisation : {{ orderUserByIds.updated_at }} </p>
                            </div>

                        </div>
                    </div> -->

                <Orders :ordersUsers='ordersUsers'></Orders>
                </div>
            </div>
        </div>
        <div>
            <Modal v-show="isModalVisible" @close="closeModal">
                <template v-slot:header>
                    <h3>Demander Votre Devis</h3>
                </template>

                <template v-slot:body>
                    <form v-if="!savingSuccessful" enctype="multipart/form-data">
                        <div>
                            <label for='inputEstimateName'>Titre du Devis</label><br>
                            <input type='text' aria-describedby='estimateNameHelp' placeholder='Entrez votre titre'
                            name='estimateName' v-model='estimateName'>
                            <p v-if='savingUnsuccessfulName'>Vous devez remplir ce Champs</p>
                        </div>
                        <div>
                            <label for='inputEstimateContents'>Décrivez de votre demande</label><br>
                            <input type='textarea' aria-describedby='estimateContentsHelp' placeholder='Description'
                            name='estimateContents' v-model='estimateContents'>
                            <p v-if='savingUnsuccessfulContent'>Vous devez remplir ce Champs</p>
                        </div>
                        <div>
                            <label for='inputEstimateFile'>Choisissez la maquette de la pièce à réaliser au format .pdf</label><br>
                            <input type='file' aria-describedby='estimateUserFile'
                            name='estimateUserFile' @change="estimateUserFileChange">
                            <p v-if='savingUnsuccessfulUserFile'>Vous devez choisir un fichier au format .pdf et faisant moins de 1 Mo </p>
                        </div>
                        <div>
                            <label for='inputEstimateItemNumber'>Combien de pièces désirez vous ?</label><br>
                            <input type='number' aria-describedby='estimateItemNumberHelp' placeholder='1, 5, 23, 78'
                            name='estimateItemNumber' v-model='estimateItemNumber'>
                            <p v-if='savingUnsuccessfulItemNumber'>Vous devez remplir ce Champs</p>
                        </div>
                        <div>
                            <button type='submit' class='btn btn-primary' @click='userEstimateForm' v-if="!savingSuccessful">enregistrer</button>
                        </div>
                    </form>
                    <div class="success" v-if="savingSuccessful">
                        <p>Votre devis a bien été envoyé</p>
                    </div>

                </template>

                <template v-slot:footer>
                    Votre Devis Gratuit et Rapide
                </template>
            </Modal>
        </div>
    </div>
</template>

<script>
    import Modal from './../ModalComponent.vue';
    import User from './uDComponents/UserComponent.vue';
    import Estimates from './uDComponents/EstimatesComponent.vue';
    import Orders from './uDComponents/OrdersComponent.vue';

    export default {
        components: {
            Modal,
            User,
            Estimates,
            Orders
            },
        data(){
            return{
                test:'aie aie aie',
                // informations edition
                                // firstname:'',
                                // lastname:'',
                                // company:'',
                                // phoneNumber:'',
                                // pseudonym:'',
                                // email:'',
                                // password:'',
                                // passwordConfirmation:'',
                                // errors:'',

                // Show/hide information div
                isInformationsVisible: false,
                                // editInformationsVisible:false,
                // Show/hide Modal
                isModalVisible: false,

                // Show/hide response Form
                savingSuccessful: false,
                savingUnsuccessfulName:false,
                savingUnsuccessfulContent:false,
                savingUnsuccessfulUserFile:false,
                savingUnsuccessfulItemNumber:false,
                // savingUnsuccessful:false,

                // Post Request
                users:{},
                estimateName:'',
                estimateContents:'',
                estimateUserFile:'',
                estimateItemNumber:'',
                success:'',

                // Informations from DB estimates
                estimatesUsers:[],
                        // estimateUserByIds:{},
                        // estimateAdminByIds:{},
                ordersUsers:[],
                        // orderUserByIds:{},
                idPayment:'',
                isEstimatesUserVisible:false,
                        // isEstimateByIdVisible:false,
                        // isAdminResponseVisible:false,
                        // adminResponse:false,

                // Infos from DB orders
                        isOrderUserVisible:false,
                        // isOrderByIdVisible:false,

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
                // window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`,
                // axios.get(`api/user/${this.id}`)
                // .then((response) => {
                //     this.users = response.data
                //     console.log(response.data)
                // }).catch((error)=>
                //     console.log(error)
                // )
            },
            // Edit Informations
            // editInformations($id){
            //     window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            //     if(this.firstname==='' && this.lastname==='' &&
            //     this.company==='' && this.phoneNumber==='' && this.pseudonym===''
            //     && this.email==='' && this.password===''&& this.passwordConfirmation===''){
            //         this.editInformationsVisible = false
            //     }else{
            //         axios.get('/sanctum/csrf-cookie').then(response => {
            //         axios.post(`api/auth/editInformations/${$id}`, {
            //                 firstname: this.firstname,
            //                 lastname: this.lastname,
            //                 company: this.company,
            //                 phoneNumber: this.phoneNumber,
            //                 pseudonym: this.pseudonym,
            //                 email: this.email,
            //                 password: this.password,
            //                 passwordConfirmation: this.passwordConfirmation

            //             }). then ((response) => {
            //                 console.log(response);
            //                 this.firstname = this.lastname = this.company = this.phoneNumber =this.pseudonym = this.email = this.password = this.passwordConfirmation =''
            //                 this.errors=''
            //                 this.editInformationsVisible = false
            //                 this.userInformations()
            //             }).catch ((errors) => {
            //                 this.errors = errors.response.data.errors;
            //                 console.log(errors.response.data.errors);

            //             })
            //         })
            //     }
            // },
            // Form Functions
            estimateUserFileChange(e){
                // console.log(e.target.files[0]);
                this.estimateUserFile = e.target.files[0];
            },
            userEstimateForm(e){
                e.preventDefault();
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
                formData.append('estimateContents', this.estimateContents);
                formData.append('estimateUserFile', this.estimateUserFile);
                formData.append('estimateName', this.estimateName);
                formData.append('estimateItemNumber', this.estimateItemNumber);


                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/estimates', formData, config,  {

                    }).then ((response) => {
                        console.log('Demande de Devis bien envoyé')
                        this.savingSuccessful=true
                        this.success = response.data
                        this.estimateName = this.estimateContents = this.estimateUserFile = this.estimateItemNumber =''
                        this.errors=''
                        this.estimatesIndex()
                    }).catch ((errors) => {
                        console.log(errors.response);
                        // this.savingUnsuccessful=true,
                        if(this.estimateName == ''){
                            this.savingUnsuccessfulName=true
                        } else {
                            this.savingUnsuccessfulName=false
                        }
                        if(this.estimateContents == ''){
                            this.savingUnsuccessfulContent=true
                        }else {
                            this.savingUnsuccessfulContent=false
                        }
                        if(this.estimateUserFile == ''){
                            this.savingUnsuccessfulUserFile=true
                        }else {
                            this.savingUnsuccessfulUserFile=false
                        }
                        if(this.estimateItemNumber == []){
                            this.savingUnsuccessfulItemNumber=true
                        }else {
                            this.savingUnsuccessfulItemNumber=false
                        }

                        this.errors = {
                            estimateName:'Veuillez remplir ce champs',
                            estimateContents:'veuillez remplir ce champs',
                            estimateItemNumber:'Vous devez choisir un nombre de pièce à fabriquer pour envoyer votre devis',
                        };
                    })
                })
            },
            // Show estimates
            estimatesIndex(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/estimates', {

                    }).then ((response) => {
                        console.log('Liste des devis bien reçu')
                        this.estimatesUsers=response.data.data
                        console.log(response.data)
                    }).catch ((errors) => {
                        console.log(errors.response);

                    })
                })
            },
            // estimateById($id){
            //     // console.log($id);
            //     window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            //     var adminContents = document.getElementById('adminContents')
            //     axios.get('/sanctum/csrf-cookie').then(response => {
            //         axios.get(`api/estimates/${$id}`, {

            //         }).then ((response) => {
            //             this.estimateUserByIds=response.data.data

            //         }).catch ((errors) => {
            //             console.log(errors.response);

            //         })
            //     });
            //     axios.get('/sanctum/csrf-cookie').then(response => {
            //         axios.get(`api/estimateAdminFile/${$id}`, {

            //         }).then ((response) => {
            //             console.log('Devis n°' + $id + ' bien reçu')
            //             this.estimateAdminByIds=response.data.data
            //             this.adminResponse=true
            //             // console.log(response.data.data)

            //         }).catch ((errors) => {
            //             console.log(errors.response.status);
            //             if(errors.response.status===401){
            //                 this.adminResponse=false
            //             }

            //         })
            //     })
            // },
            // ddlEstimatesAdminFile($id, $number){
            //     window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            //     console.log($id);

            //     axios.get('/sanctum/csrf-cookie').then(response => {
            //         axios.get(`api/estimateAdminDownload/${$id}`,
            //         {
            //             responseType: 'arraybuffer',
            //             headers: {'Accept': 'application/pdf'}
            //         }
            //         ).then ((response) =>{
            //             let blob = new Blob([response.data], { type: 'application/pdf' })
            //             let link = document.createElement('a')
            //             link.href = window.URL.createObjectURL(blob)

            //             link.download = 'Devis_'+$number+'.pdf'
            //             link.click();
            //         }).catch ((errors) => {
            //             console.log(errors.response);
            //             alert('Mauvaise id Bro')
            //         })
            //     })
            // },
            // paymentPage($id){
            //     this.idPayment=$id
            //     console.log(this.idPayment)
            //      this.$router.push({
            //         name: 'payment',
            //         params: {
            //             id:$id,
            //             // items: this.idPayment
            //         }
            //     });
            // },
            // Show orders
            ordersIndex(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/orders', {

                    }).then ((response) => {
                        console.log('Liste des commandes bien reçu')
                        this.ordersUsers=response.data.data
                        console.log(this.ordersUsers);
                    }).catch ((errors) => {
                        console.log(errors.response);

                    })
                })
            },
            // orderById($id){
            //     window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            //     axios.get('/sanctum/csrf-cookie').then(response => {
            //         axios.get(`api/orders/${$id}`, {

            //         }).then ((response) => {
            //             this.orderUserByIds=response.data
            //             console.log(this.orderUserByIds)
            //         }).catch ((errors) => {
            //             console.log(errors.response);

            //         })
            //     });
            // },
            // Modal Functions
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
            // Hide/Show Functions
            isHiddenInformations(){
                this.isInformationsVisible= true;
                this.isEstimatesUserVisible=false;
                this.isEstimateByIdVisible=false;
                this.isAdminResponseVisible=false;
                this.isOrderUserVisible=false;
                this.isOrderByIdVisible=false;

            },
            IsHiddenEstimateUser(){
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=true;
                this.isEstimateByIdVisible=false;
                this.isAdminResponseVisible=false;
                this.isOrderUserVisible=false;
                this.isOrderByIdVisible=false;

            },
            isHiddenEstimateById(){
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isEstimateByIdVisible=true;
                this.isAdminResponseVisible=false;
                this.isOrderUserVisible=false;
                this.isOrderByIdVisible=false;
            },
            isHiddenEstimateAdminResponse(){
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isEstimateByIdVisible=true;
                this.isAdminResponseVisible=true;
                this.isOrderUserVisible=false;
                this.isOrderByIdVisible=false;

            },
            IsHiddenOrderUser(){
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isEstimateByIdVisible=false;
                this.isAdminResponseVisible=false;
                this.isOrderUserVisible=true;
                this.isOrderByIdVisible=false;
            },
            isHiddenOrderById(){
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isEstimateByIdVisible=false;
                this.isAdminResponseVisible=false;
                this.isOrderUserVisible=false;
                this.isOrderByIdVisible=true;
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
