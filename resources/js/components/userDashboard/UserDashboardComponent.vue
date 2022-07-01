<template>
    <div class='user-background-image'>
        <div class='nav-false-background'></div>
        <div class='container-display-user'>
            <div class='menu-dashboard-user'>
                <div class='menu-category-size-user-first-menu'>
                    <a @click='isHiddenInformations()'>
                        <h5>Mes informations</h5>
                    </a>
                </div>
                <div class='menu-category-size-user'>
                    <a @click="showModal">
                        <h5>Demander un devis</h5>
                    </a>
                </div>
                <div class='menu-category-size-user'>
                    <a v-show='!isEstimatesUserVisible' @click='estimatesIndex();isHiddenEstimateUser()'>
                        <h5 >Mes Devis</h5>
                    </a>
                    <a v-show='isEstimatesUserVisible' @click='allIsHidden()'>
                        <h5 >Mes Devis</h5>
                    </a>
                </div>
                <div class='menu-category-size-user'>
                    <a v-show='!isOrderUserVisible' @click='ordersIndex();isHiddenOrderUser()'>
                        <h5>Mes Commandes</h5>
                    </a>
                    <a v-show='isOrderUserVisible' @click='allIsHidden()'>
                        <h5>Mes Commandes</h5>
                    </a>
                </div>
                <div class='menu-category-size-user'>
                    <a v-show='!isContactUserVisible' @click='ticketsIndex();isHiddenContactUser()'>
                        <h5>Contacts</h5>
                    </a>
                    <a v-show='isContactUserVisible' @click='allIsHidden()'>
                        <h5>Contacts</h5>
                    </a>
                </div>
            </div>
            <div class='flex-information-user display-dashboard-user background-color-user'>
                <div class='infos-title-user' v-show='isWelcomeVisible'>
                    <h2>Bienvenue sur votre espace personel</h2>
                </div>
                <!-- <div class='image-user-Dashboard'>
                    <img src='/storage/images/travailler-bois.jpg'>
                </div> -->
                <div v-show="isInformationsVisible">
                    <User></User>
                </div>
                <div v-show='isEstimatesUserVisible'>
                   <Estimates :estimatesUsers='estimatesUsers'></Estimates>
                </div>
                <div v-show='isOrderUserVisible'>
                    <Orders :ordersUsers='ordersUsers'></Orders>
                </div>
                <div v-show='isContactUserVisible'>
                    <Contact :ticketsUsers='ticketsUsers'></Contact>
                </div>
            </div>
        </div>
        <div>
            <Modal v-show="isModalVisible" @close="closeModal">
                <template v-slot:header>
                    <h3>Demander Votre Devis</h3>
                </template>

                <template v-slot:body>
                    <div class='modal-display-center form-request-estimate'>
                        <form class='modal-display-center' v-if="!savingSuccessful" enctype="multipart/form-data">
                            <div class='modal-display-center'>
                                <label for='inputEstimateName'><h5 class='modal-display-center modal-title-request-estimate'>Titre de votre demande</h5></label>
                                <input type='text' aria-describedby='estimateNameHelp' placeholder='Entrez votre titre'
                                name='inputEstimateName' v-model='estimateName'>
                                <p v-if='savingUnsuccessfulName'>Vous devez remplir ce Champs</p>
                            </div>
                            <div class='modal-display-center'>
                                <label for='inputEstimateContents'><h5 class='modal-display-center modal-title-request-estimate'>Description de votre demande</h5></label>
                                <textarea aria-describedby='estimateContentsHelp' placeholder='Description'
                                name='inputEstimateContents' v-model='estimateContents'></textarea>
                                <p v-if='savingUnsuccessfulContent'>Vous devez remplir ce Champs</p>
                            </div>
                            <div>
                                <div class='modal-display-center'>
                                    <div class='modal-display-center data-tiny-editor'>
                                        <label for='inputEstimateFile'><h5 class='modal-display-center modal-title-request-estimate'>Choisissez la maquette de la pièce à réaliser au format .pdf</h5></label>
                                        <input class='modal-input-number' type='file' aria-describedby='estimateUserFile'
                                        name='inputEstimateFile' @change="estimateUserFileChange">
                                        <p v-if='savingUnsuccessfulUserFile'>Vous devez choisir un fichier au format .pdf et faisant moins de 1 Mo </p>
                                    </div>
                                    <div class='modal-display-center'>
                                        <label for='inputEstimateItemNumber'><h5 class='modal-display-center modal-title-request-estimate'>Combien de pièces désirez vous ?</h5></label>
                                        <input class='modal-input-number' type='number' aria-describedby='estimateItemNumberHelp' placeholder='1, 5, 23, 78'
                                        name='inputEstimateItemNumber' v-model='estimateItemNumber'>
                                        <p v-if='savingUnsuccessfulItemNumber'>Vous devez remplir ce Champs</p>
                                    </div>
                                </div>
                            </div>
                            <div class='modal-display-center'>
                                <button type='submit' class='modal-button-estimates' @click='userEstimateForm' v-if="!savingSuccessful"><h5>Enregistrer</h5></button>
                            </div>
                        </form>
                    <div class="success" v-if="savingSuccessful">
                        <h5>Votre demande de devis a bien été envoyé</h5>
                    </div>
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
    import Contact from './uDComponents/ContactComponent.vue';

    export default {
        components: {
            Modal,
            User,
            Estimates,
            Orders,
            Contact,
            },
        data(){
            return{
                // Show/hide information div
                isInformationsVisible: true,
                isWelcomeVisible:false,

                // Show/hide Modal
                isModalVisible: false,

                // Show/hide response Form
                savingSuccessful: false,
                savingUnsuccessfulName:false,
                savingUnsuccessfulContent:false,
                savingUnsuccessfulUserFile:false,
                savingUnsuccessfulItemNumber:false,

                // Post Request
                users:{},
                estimateName:'',
                estimateContents:'',
                estimateUserFile:'',
                estimateItemNumber:'',
                success:'',

                // Informations from DB estimates
                estimatesUsers:[],
                ordersUsers:[],
                ticketsUsers:[],
                idPayment:'',
                isEstimatesUserVisible:false,
                isOrderUserVisible:false,
                isContactUserVisible:false,

                // Local storage
                id:localStorage.getItem('id'),
                token:localStorage.getItem('token')
            }
        },

        methods: {
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
                    axios.get('api/estimatesSearch', {

                    }).then ((response) => {
                        console.log('Liste des devis bien reçu')
                        this.estimatesUsers=response.data.data
                        console.log(response.data)
                    }).catch ((errors) => {
                        console.log(errors.response);

                    })
                })
            },
            // Show orders
            ordersIndex(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/ordersSearch', {

                    }).then ((response) => {
                        console.log('Liste des commandes bien reçu')
                        this.ordersUsers=response.data.data
                        console.log(this.ordersUsers);
                    }).catch ((errors) => {
                        console.log(errors.response);

                    })
                })
            },
            ticketsIndex(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/ticketsSearch', {

                    }).then ((response) => {
                        console.log('Liste des commandes bien reçu')
                        this.ticketsUsers=response.data.data
                        console.log(this.ticketsUsers);
                    }).catch ((errors) => {
                        console.log(errors.response);

                    })
                })
            },
            // Modal Functions
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
            // Hide/Show Functions
            isHiddenInformations(){
                this.isWelcomeVisible=false,
                this.isInformationsVisible= true;
                this.isEstimatesUserVisible=false;
                this.isOrderUserVisible=false;
                this.isContactUserVisible=false;
            },
            isHiddenEstimateUser(){
                this.isWelcomeVisible=false,
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=true;
                this.isOrderUserVisible=false;
                this.isContactUserVisible=false;
            },
            isHiddenOrderUser(){
                this.isWelcomeVisible=false,
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isOrderUserVisible=true;
                this.isContactUserVisible=false;
            },
             isHiddenContactUser(){
                this.isWelcomeVisible=false,
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isOrderUserVisible=false;
                this.isContactUserVisible=true;
            },
            allIsHidden(){
                this.isWelcomeVisible=true,
                this.isInformationsVisible= false;
                this.isEstimatesUserVisible=false;
                this.isOrderUserVisible=false;
                this.isContactUserVisible=false;
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
