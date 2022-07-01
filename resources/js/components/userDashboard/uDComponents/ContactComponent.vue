<template>
    <div>
        <div class='infos-title-user'>
            <h2>Contacter GEPETTO</h2>
        </div>
        <div class='infos-users-user'>
                <div >
                    <a type='button' @click='showModal();openNewTicket()'><h5 class='button-informations-user'>Créer un nouveau ticket</h5></a>
                </div>
        </div>

        <div v-show='isEstimatesUserVisible' class='cards-container'>
            <div class='card-border' v-for='ticketsUser in ticketsUsers' :key='ticketsUser.id'>
                <div class='cards-center'>
                    <div>
                        <h5>Votre Ticket</h5>
                    </div>
                    <div>
                        <p>{{ ticketsUser.ticketNumber }} </p>
                    </div>
                </div>
                <div class='cards-center'>
                    <div>
                        <h5>Réponse attribuée: </h5>
                    </div>
                    <div>
                        <p>{{ ticketsUser.checkGepettoResponse }} </p>
                    </div>
                </div>

                <div class='cards-center'>
                    <div>
                        <h5>Catégorie: </h5>
                    </div>
                    <div>
                        <p>{{ ticketsUser.category }}</p>
                    </div>
                </div>
                <div class='cards-center'>
                    <button  class='btn-reponse-userDB button-card-userDB' @click='ticketById(ticketsUser.id)'><h5>Voir le Ticket</h5></button>
                </div>
            </div>
        </div>
        <ModalTicket v-show="isModalTicketVisible" @close="closeModalTicket">
            <template v-slot:header>
                <h3>Votre ticket n°{{ ticketsByIds.ticketNumber }}</h3>
            </template>

            <template v-slot:body>
                <div class='modal-estimates-style'>
                    <div class='modal-display-table'>
                        <div><h5>Numéro du ticket :</h5></div>
                        <div><p> {{ ticketsByIds.ticketNumber }}</p></div>
                    </div>
                    <div class='modal-display-table'>
                        <div><h5>Catégorie choisie :</h5></div>
                         <div><p> {{ ticketsByIds.category }}</p></div>
                    </div>
                    <div class='modal-display-table'>
                        <div><h5>Réponse attribuée :</h5></div>
                        <div><p> {{ ticketsByIds.checkGepettoResponse }}</p></div>
                    </div>
                </div>
                <div class='modal-display-center modal-estimates-style modal-estimates-column'>

                    <button class='btn-fermer-userDB' v-show='!isAdminResponseVisible' @click='isHiddenEstimateAdminResponse'><h5>Voir mon message</h5></button>
                    <h4 v-show='!isAdminResponseVisible'>Réponse à votre ticket</h4>
                    <button class='btn-fermer-userDB' v-show='isAdminResponseVisible' @click='isAdminResponseVisible=false;adminResponse=false'><h5>Voir la réponse de Gepetto</h5></button>
                </div>
                <div  class='modal-display-center' v-show='!isAdminResponseVisible'>
                    <div  class='message-modal-userDB' v-show='!adminResponse'>
                        <p id='adminContents'>{{ticketsByIds.gepettoResponse}}</p>

                    </div>
                    <div  class='message-modal-userDB-center' v-show='adminResponse'>
                        <p id='adminContents'>Vous n'avez pas encore reçu de réponse de la part de notre entreprise</p>
                    </div>
                </div>
                <div class='modal-display-center'>
                    <div class='message-modal-userDB' v-show='isAdminResponseVisible'>
                        <p>{{ ticketsByIds.userTicket }}</p>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                Toutes vos informations sur le devis
            </template>
        </ModalTicket>
        <Modal v-show="isModalVisible" @close="closeModal">
            <template v-slot:header>
                <h3>Création d'un ticket</h3>
            </template>

            <template v-slot:body>
                <div class='modal-display-center modal-estimates-style modal-estimates-column' v-show='successTicketSend'>
                    <h5 class='success-send-ticket'>Félicitation, votre ticket a bien été pris en compte</h5>
                </div>
                <div>
                    <div class='modal-display-center modal-estimates-style modal-estimates-column' v-show="!showTicketForm">
                        <h4 v-show='!isAdminResponseVisible'>Voulez-vous créer un ticket de contact ?</h4>
                        <button class='btn-fermer-userDB' v-show='!isAdminResponseVisible' @click='isHiddenEstimateAdminResponse'><h5>Oui</h5></button>
                        <button class='btn-fermer-userDB' v-show='!isAdminResponseVisible' @click='closeModal()'><h5>Non</h5></button>
                        <h4 v-show='isAdminResponseVisible'>Choisissez la raison de votre demande :</h4>
                    </div>
                    <div class='modal-display-center modal-estimates-style modal-estimates-column' v-show='showErrorMessage'>
                        <h4 >Vous ne pouvez pas créer plus de 5 tickets simultanément</h4>
                    </div>
                    <div class='modal-display-center modal-estimates-style modal-estimates-column' v-show='showTicketFormSend'>
                        <h4 >Envoyez votre ticket</h4>
                    </div>
                    <div class='alert-category-choice' v-show='showInformationMessageContact'>
                        <h5 >Vous devez choisir une catégorie</h5>
                    </div>
                    <div class='alert-category-choice' v-show='showMessageEmptyForm'>
                        <h5 >Vous ne pouvez pas envoyer un message vide</h5>
                    </div>

                    <div class='contact-verif-ticket-position' v-show="!showTicketForm">
                        <div class='contact-verif-ticket'>
                            <select name="newTicket" v-model='category' v-show='isAdminResponseVisible'>
                                <option value="">--Please choose an option--</option>
                                <option value="devis">Devis</option>
                                <option value="commande">Commande</option>
                                <option value="autre">Autre</option>
                            </select>

                            <button class='' v-show='isAdminResponseVisible' @click='verifOnlyOneTicket()'><h5>Valider</h5></button>
                            <button class='' v-show='isAdminResponseVisible' @click='isAdminResponseVisible=!isAdminResponseVisible;showInformationMessageContact=false'><h5>Annuler</h5></button>
                        </div>
                    </div>
                    <div class='contact-ticket-form-position' v-show='showTicketForm'>
                        <form @submit.prevent v-show='!successTicketSend'>
                            <div class='contact-ticket-form'>
                                <textarea placeholder='Rédiger votre requête et nous vous répondrons dans les plus brefs délais' v-model='userTicket'></textarea>
                            </div>
                            <div class='contact-ticket-form'>
                                <button class='' @click='sendTicket()'><h5> Envoyer le Ticket</h5></button>
                                <button class='' @click='showTicketForm=!showTicketForm;showMessageEmptyForm=false;showTicketFormSend=false'><h5>Annuler</h5></button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                Création du ticket de contact
            </template>
        </Modal>
    </div>
</template>

<script>
 import Modal from '../../ModalComponent.vue';
 import ModalTicket from '../../ModalComponent.vue';
 export default {
    components: {
        Modal,
        ModalTicket,
    },
    name: 'Contact',
    props:{
        'ticketsUsers':Array,
    },
    data(){
    return{

        // contact
        category:'',
        userTicket:'',
        showErrorMessage:false,
        showTicketForm:false,
        showInformationMessageContact:false,
        showMessageEmptyForm:false,
        successTicketSend:false,
        showTicketFormSend:false,
        // editInformationsVisible:false,
        // Informations from DB estimates
        ticketsByIds:{},
        isEstimatesUserVisible:true,
        isAdminResponseVisible:false,
        adminResponse:false,
        // Modal
        isModalVisible: false,
        isModalTicketVisible:false,
         // Local storage
        id:localStorage.getItem('id'),
        token:localStorage.getItem('token')
}
    },

    methods: {
        verifOnlyOneTicket(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/tickets`, {
                }).then ((response) => {
                    console.log(response.data)
                    let results = response.data
                    let check_closed = results.filter(close => (close.closed === "Oui"));
                    console.log(results.length,check_closed.length,Number(results.length-check_closed.length))
                    if(this.category == ''){
                        this.showInformationMessageContact=true
                    }else{
                        if(Number(results.length-check_closed.length)<5){
                            console.log('victory')
                            this.showTicketFormSend=true,
                            this.showTicketForm=true;
                            this.showInformationMessageContact=false;


                        }else{
                            console.log('error')
                            this.showErrorMessage=true;
                        }
                    }


                }).catch ((errors) => {
                    console.log(errors.response);


                })
            })

        },
        sendTicket(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            if(this.userTicket===''){
                this.showMessageEmptyForm=true;
            }else{
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post(`api/ticket`, {
                        category: this.category,
                        userTicket: this.userTicket,
                    }). then ((response) => {
                        console.log(response);
                        this.successTicketSend=true
                        this.showMessageEmptyForm=false
                        this.showTicketFormSend=false

                    }).catch ((errors) => {
                        console.log(errors.response.data.errors);
                    })
                })
            }

        },
        openNewTicket(){
            this.showTicketForm=false
        },
        ticketById($id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            this.isModalTicketVisible = true;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/tickets/${$id}`, {
                }).then ((response) => {
                    this.ticketsByIds=response.data.data
                    console.log( this.ticketsByIds)
                    this.id='';
                }).catch ((errors) => {
                    console.log(errors.response);
                    this.id='';
                })
            });
        },

        isHiddenEstimateById(){
            this.adminResponse=false;
            this.isAdminResponseVisible=false;
        },
        isHiddenEstimateAdminResponse(){
            this.adminResponse=true;
            this.isAdminResponseVisible=true;
        },
                  // Modal Functions
        showModal() {
            this.isModalVisible = true;
            this.successTicketSend = false;
        },
        closeModal() {
            this.isModalVisible = false;
        },
        showModalTicket() {
            this.isModalTicketVisible = true;
        },
        closeModalTicket() {
            this.isModalTicketVisible = false;
        }
    },
    mounted(){
        console.log('EstimatesComponent Mounted')
    }
 }

</script>
