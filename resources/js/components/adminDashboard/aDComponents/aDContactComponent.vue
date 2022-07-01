<template>
    <div>
        <div>
            <div>
                <div class='searchbar-results' v-if="this.q && getFilteredTickets.length > 1">
                    <p>Il existe {{ getFilteredTickets.length }} Tickets</p>
                </div>
                <div class='searchbar-results' v-if="this.q && getFilteredTickets.length === 1">
                    <p>Il existe {{ getFilteredTickets.length }} Ticket</p>
                </div>
                <div class='searchbar-results' v-else-if="this.q && getFilteredTickets.length===0">
                    <p>Aucune correspondance trouvée</p>
                </div>
            </div>
            <div class='searchbar-title-results' v-if='this.q && getFilteredTickets.length >= 1'>
                <div class='searchbar-title-results'>
                    <h5>Résultat de la recherche</h5>
                </div>
            </div>
            <table class='table-size' v-if='this.q && getFilteredTickets.length >= 1'>
                <thead class='table-color'>
                    <tr>
                        <th>
                            <p>Numéro</p>
                        </th>
                        <th>
                            <p>Catégorie</p>
                        </th>
                        <th>
                            <p>Réponse attribuée</p>
                        </th>
                        <th>
                            <p>Cloturer</p>
                        </th>
                        <th>
                            <p>Date de création</p>
                        </th>
                        <th>
                            <p>Dernière modification</p>
                        </th>
                        <th>
                            <p>Détails</p>
                        </th>
                    </tr>
                </thead>
                <tbody class='table-color-tbody' v-for="ticket in getFilteredTickets" v-bind:key="ticket.id" >
                    <tr :class="{'table-color-shading-2':ticket.id% 2 === 0, 'table-color-shading-1':ticket.id% 2 !== 0 }">
                        <td>
                            <p>{{ ticket.ticketNumber }}</p>
                        </td>
                        <td>
                            <p>{{ ticket.category }}</p>
                        </td>
                        <td>
                            <p>{{ ticket.checkGepettoResponse }}</p>
                        </td>
                        <td>
                            <p>{{ ticket.closed }}</p>
                        </td>

                        <td>
                            <p>{{ ticket.created_at }}</p>
                        </td>
                        <td>
                            <p>{{ ticket.updated_at }}</p>
                        </td>

                        <td>
                            <!-- <button @click="estimateAdminShow(estimate.id)">Plus de Détails</button> -->
                            <button>Test Plus de détails</button>
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
                        <p>Numéro</p>
                    </th>
                    <th>
                        <p>Catégorie</p>
                    </th>
                    <th>
                        <p>Réponse attribuée</p>
                    </th>
                    <th>
                        <p>Cloturer</p>
                    </th>
                    <th>
                        <p>Date de création</p>
                    </th>
                    <th>
                        <p>Dernière modification</p>
                    </th>
                    <th>
                        <p>Détails</p>
                    </th>
                </tr>
            </thead>
            <tbody class='table-color-tbody' v-for="ticket in paginationsTickets.data" v-bind:key="ticket.id" >
                <tr :class="{'table-color-shading-2':ticket.id% 2 === 0, 'table-color-shading-1':ticket.id% 2 !== 0 }">
                    <td>
                        <p>{{ ticket.ticketNumber }}</p>
                    </td>
                    <td>
                        <p>{{ ticket.category }}</p>
                    </td>
                    <td>
                        <p>{{ ticket.checkGepettoResponse }}</p>
                    </td>
                    <td>
                        <p>{{ ticket.closed }}</p>
                    </td>

                    <td>
                        <p>{{ ticket.created_at }}</p>
                    </td>
                    <td>
                        <p>{{ ticket.updated_at }}</p>
                    </td>

                    <td>
                        <button @click="ticketAdminShow(ticket.id)">Plus de Détails</button>
                    </td>
                </tr>
            </tbody>
            <!-- <div class='searchbar-footer'></div> -->
        </table>
        <pagination :data="paginationsTickets" @pagination-change-page="getResults"></pagination>
        <Modal v-show="isModalTicketVisible" @close="closeModal">

            <template v-slot:header>
                <h3>{{ ticketModals.ticketNumber }} </h3>
            </template>

            <template v-slot:body>
                <div class='modal-orders-style' v-if="!savingSuccessfull" v-show='!adminEstimateResponse'>
                    <div class='modal-display-table-AD' >
                        <div class='modal-display-table-AD-child'>
                            <h5>Prénom</h5>
                            <p>{{ ticketModals.firstname }}</p>
                        </div>
                        <div class='modal-display-table-AD-child'>
                            <h5>Nom</h5>
                            <p>{{ ticketModals.lastname }}</p>
                        </div>
                    </div>
                    <div class='modal-display-table-AD-child'>
                        <h5>E-mail</h5>
                        <p>{{ ticketModals.email }}</p>
                    </div>

                    <div class='modal-display-table-AD-ask'>
                        <h5>Catégorie</h5>
                        <p>{{ ticketModals.category}}</p>
                    </div>
                    <div class='modal-display-table-AD-ask'>
                        <h5>Contenu</h5>
                        <p class='modal-display-content'>{{ ticketModals.userTicket }}</p>
                    </div>
                    <!-- <div class='modal-display-table-AD-ask'>
                        <h5>Plans .pdf</h5>
                        <button class='button-modal-pdf' @click='ddlEstimatesUserFile(ticketModals.id, ticketModals.estimateNumber)'> Demande {{ ticketModals.estimateNumber }} </button>
                    </div> -->
                    <div class='button-modal-answer'>
                        <button class='button-modal-pdf' type='text' v-show='!adminEstimateResponse' @click='adminEstimateResponse=true'><h5 class='show-response-button'>Formulaire de réponse</h5></button>
                    </div>
                </div>

                <div class='modal-display-center form-request-estimate'>
                    <form @submit.prevent v-show='adminEstimateResponse' v-if="!savingSuccessfull">
                        <div>
                            <p v-if='savingUnsuccessfullFile'>Vous avez déja envoyé une Réponse au Client</p>
                        </div>
                        <div class='modal-display-center'>
                            <label for='inputEstimateAdminContents'><h5 class='modal-answer-admin-titles'>Message de réponse</h5></label><br>
                            <textarea class='modal-answer-admin-contents' aria-describedby='estimateAdminContentsHelp' :placeholder='ticketModals.gepettoResponse'
                                name='inputEstimateAdminContents' v-model='gepettoResponse'>
                            </textarea>
                            <p v-if='savingUnsuccessfullContent'>Vous devez écrire un message</p>
                        </div>

                        <!-- <div class='modal-display-center'>
                            <label for='inputEstimateAdminPrice'><h5 class='modal-answer-admin-titles'>Renseignez le prix du Devis</h5></label><br>
                            <input class='modal-answer-admin-inputs' type='number' required min='0' step='0.01' pattern='^\d+(?:\.\d{1,2})?$'
                            aria-describedby='estimateAdminPriceHelp'
                            name='inputEstimateAdminPrice' v-model='estimateAdminPrice'>
                            <p v-if='savingUnsuccessfullPrice'>Vous devez renseigner un prix positif</p>
                        </div> -->
                        <!-- <div class='modal-display-center'>
                            <label for='inputEstimateAdminFile'><h5 class='modal-answer-admin-titles'>Choisissez la maquette de la pièce à réaliser au format .pdf</h5></label><br> --> -->
                            <!-- <input type='file' aria-describedby='estimateAdminFile'
                            name='inputEstimateAdminFile' @change="estimateAdminFileChange"> -->
                            <!-- <p v-if='savingUnsuccessfullAdminFile'>Vous devez choisir un fichier au format .pdf et faisant moins de 1 Mo </p>
                        </div> -->
                        <div class='modal-display-center button-modal-answer'>
                            <button class='button-modal-pdf' type='submit' @click='ticketGepettoResponse(ticketModals.id)' v-if='!savingSuccessfull'><h5>Envoyer la réponse</h5></button>
                        </div>
                    </form>
                </div>
                 <div class='modal-display-center button-modal-answer'>
                    <button class='button-modal-pdf' type='text' v-show='adminEstimateResponse' @click='adminEstimateResponse=false' v-if='!savingSuccessfull'><h5 class='show-response-button'>Annuler</h5></button>
                </div>
                <div class='modal-display-center button-modal-answer'>
                    <div class="success" v-if="savingSuccessfull">
                        <h5>Votre Réponse a bien été envoyé</h5>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                Votre Devis Gratuit et Rapide
            </template>
        </Modal>
    </div>
</template>

<script>
import Modal from './../../ModalComponent.vue';
 export default {
    components: {
        Modal,
    },
    name: 'Contact',
    props:{
        'q':'',
        'tickets':Array,
        'paginationsTickets':Object,
    },
    data(){
    return{
        token:localStorage.getItem('token'),
        // Variables' function
            users:[],
            // estimates:[],
            orders:[],
            // paginationsEstimates:{},
        // Modal
            isHidden: false,
            isModalTicketVisible: false,
            isModalOrderVisible: false,
            adminEstimateResponse:false,
            // Variables' modal
                ticketModals:{},
                gepettoResponse:'',
                estimateAdminContents:'',
                estimateAdminFile:'',
                estimateAdminPrice: 0,
        // Form errors
        savingSuccessfull:false,
        savingUnsuccessfullContent:false,
        savingUnsuccessfullAdminFile:false,
        savingUnsuccessfullPrice:false,
        savingUnsuccessfullFile:false,
}
    },

    methods: {
        getResults(page = 1) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/tickets?page=' + page)
                    .then(response => {
                        this.paginationsTickets = response.data;
                    });
            })
        },

        ticketAdminShow(id){
             window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

            this.isModalTicketVisible = true
            let modalFileId=id
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/tickets/${modalFileId}`).then ((response) =>
                {
                    this.ticketModals=response.data
                    console.log(this.ticketModals)
                    this.modalFileId=''
                }).catch ((errors) => {
                    console.log(errors.response);
                    this.modalFileId=''
                })
            })
        },
        ticketGepettoResponse(id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            console.log(this.gepettoResponse)
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.patch(`api/ticketUpdate/${id}`, {
                    gepettoResponse: this.gepettoResponse,
                }). then ((response) => {
                    console.log(response)
                    this.savingSuccessfull=true
                    this.getResults()
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        estimateEditAdmin(id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            };
            console.log('test prix',this.estimateAdminPrice)
            // this.estimateAdminPrice.replace(/,/g,'.')
            // console.log('test prix modifié',this.estimateAdminPrice.replace(/,/g,'.'))
            let formData = new FormData;
            formData.append('estimateAdminContents',this.estimateAdminContents);
            formData.append('estimateAdminFile',this.estimateAdminFile);
            formData.append('estimateAdminPrice',this.estimateAdminPrice);


            // Show Modal and retrieve id

            let modalFileId=id;
            console.log()
            // Asynchronous request
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(`api/estimateAdminFile/${modalFileId}`, formData, config)
                .then ((response) =>{
                    console.log('Devis bien envoyé')

                    this.savingSuccessfull=true
                    this.modalFileId=''

                }).catch ((errors) => {
                    console.log(errors.response.status)
                    if(this.estimateAdminContents == ''){
                        this.savingUnsuccessfullContent=true
                        this.errors = {estimateAdminContents:'Veuillez remplir ce champs'}
                    } else {
                        this.savingUnsuccessfullContent=false
                        }
                    if (this.estimateAdminPrice == '' || this.estimateAdminPrice <= 0){
                        this.savingUnsuccessfullPrice=true
                        this.errors = {estimateAdminPrice:'Vous devez renseigner un prix positif',}
                    }else{
                        this.savingUnsuccessfullPrice=false
                        }
                    if ( this.estimateAdminFile == ''){
                        this.savingUnsuccessfullAdminFile=true
                        this.errors = {estimateAdminFile:'Veuillez remplir ce champs',}
                    }else{
                        this.savingUnsuccessfullAdminFile=false
                        }
                    if(errors.response.status = 404){
                        this.errors = {savingUnsuccessfullFile:'Veuillez remplir ce champs',}
                        this.savingUnsuccessfullFile=true
                    }
                    this.modalFileId=''
                })
            })
        },
        showModal() {
            this.isModalTicketVisible = true;
            // this.isModalOrderVisible = true;
        },
        closeModal() {
            this.isModalTicketVisible = false;
            this.savingSuccessfull=false;
            this.savingUnsuccessfullContent=false;
            this.savingUnsuccessfullAdminFile=false;
            this.savingUnsuccessfullPrice=false;
            this.savingUnsuccessfullFile=false;
            this.adminEstimateResponse=false;
            // this.isModalOrderVisible = false;
            // this.hideEditOrder=false;
            // this.isModalNewImageVisble=false;
        },

    },
    computed: {
        getFilteredTickets() {
            const lowerCaseSearch = this.q.toLowerCase()
            return this.tickets.filter(
                ticket => {
                    return ticket.userTicket.toLowerCase().includes(lowerCaseSearch)
                        || ticket.category.toLowerCase().includes(lowerCaseSearch)
                        || ticket.ticketNumber.toLowerCase().includes(lowerCaseSearch)
                        || ticket.closed.toLowerCase().includes(lowerCaseSearch)
                },
            )
        },
    },
    mounted(){
        // this.getResults();
        // this.searchRequests();
        console.log('Tickets Mounted')
    }
 }

</script>
