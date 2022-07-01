<template>
    <div>
        <div>
            <div>
                <div class='searchbar-results' v-if="this.q && getFilteredEstimates.length > 1">
                    <p>Il existe {{ getFilteredEstimates.length }} Devis</p>
                </div>
                <div class='searchbar-results' v-if="this.q && getFilteredEstimates.length === 1">
                    <p>Il existe {{ getFilteredEstimates.length }} Utilisateur</p>
                </div>
                <div class='searchbar-results' v-else-if="this.q && getFilteredEstimates.length===0">
                    <p>Aucune correspondance trouvée</p>
                </div>
            </div>
            <div class='searchbar-title-results' v-if='this.q && getFilteredEstimates.length >= 1'>
                <div class='searchbar-title-results'>
                    <h5>Résultat de la recherche</h5>
                </div>
            </div>
            <table class='table-size' v-if='this.q && getFilteredEstimates.length >= 1'>
                <thead class='table-color'>
                    <tr>
                        <th>
                            <p>Titre</p>
                        </th>
                        <th>
                            <p>Numéro</p>
                        </th>
                        <th>
                            <p>Nombre de pièces</p>
                        </th>
                        <th>
                            <p>Demande .pdf</p>
                        </th>
                        <th>
                            <p>Paiement effectué</p>
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
                <tbody class='table-color-tbody' v-for="estimate in getFilteredEstimates" v-bind:key="estimate.id" >
                    <tr :class="{'table-color-shading-2':estimate.id% 2 === 0, 'table-color-shading-1':estimate.id% 2 !== 0 }">
                        <td>
                            <p>{{ estimate.estimateName }}</p>
                        </td>
                        <td>
                            <p>{{ estimate.estimateNumber }}</p>
                        </td>
                        <td>
                            <p>{{ estimate.estimateItemNumber }}</p>
                        </td>
                        <td>
                            <button @click='ddlEstimatesUserFile(estimate.id, estimate.estimateNumber)'> Demande {{ estimate.estimateNumber }} </button>
                        </td>
                        <td>
                            <p>{{ estimate.paymentValidation }} </p>
                        </td>
                        <td>
                            <p>{{ estimate.created_at }}</p>
                        </td>
                        <td>
                            <p>{{ estimate.updated_at }}</p>
                        </td>

                        <td>
                            <button @click="estimateAdminShow(estimate.id)">Plus de Détails</button>
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
                        <p>Titre</p>
                    </th>
                    <th>
                        <p>Numéro</p>
                    </th>
                    <th>
                        <p>Nombre de pièces</p>
                    </th>
                    <th>
                        <p>Demande .pdf</p>
                    </th>
                    <th>
                        <p>Paiement effectué</p>
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
            <tbody class='table-color-tbody'  v-for='estimate in paginationsEstimates.data' v-bind:key='estimate.id' >
                 <tr :class="{'table-color-shading-2':estimate.id% 2 === 0, 'table-color-shading-1':estimate.id% 2 !== 0 }">
                    <td>
                        <p>{{ estimate.estimateName }}</p>
                    </td>
                    <td>
                        <p>{{ estimate.estimateNumber }}</p>
                    </td>
                    <td>
                        <p>{{ estimate.estimateItemNumber }}</p>
                    </td>
                    <td>
                        <button @click='ddlEstimatesUserFile(estimate.id, estimate.estimateNumber)'> Document {{ estimate.estimateNumber }} </button>
                    </td>
                    <td>
                        <p>{{ estimate.paymentValidation }} </p>
                    </td>
                    <td>
                        <p>{{ estimate.created_at }}</p>
                    </td>
                    <td>
                        <p>{{ estimate.updated_at }}</p>
                    </td>

                    <td>
                        <button @click="estimateAdminShow(estimate.id)">Plus de Détails</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination :data="paginationsEstimates" @pagination-change-page="getResults"></pagination>
        <Modal v-show="isModalEstimateVisible" @close="closeModal">
            <!-- Show DB named estimates -->
            <template v-slot:header>
                <h3>Demande {{ estimateModals.estimateNumber }} </h3>
            </template>

            <template v-slot:body>
                <div class='modal-orders-style' v-if="!savingSuccessfull" v-show='!adminEstimateResponse'>
                    <div class='modal-display-table-AD' >
                        <!-- <div class='modal-display-table'>
                            <h5>id :</h5>
                            <p>{{ estimateModals.id }}</p>
                        </div> -->
                        <div class='modal-display-table-AD-child'>
                            <h5>Prénom</h5>
                            <p>{{ estimateModals.firstname }}</p>
                        </div>
                        <div class='modal-display-table-AD-child'>
                            <h5>Nom</h5>
                            <p>{{ estimateModals.lastname }}</p>
                        </div>
                    </div>
                    <div class='modal-display-table-AD-child'>
                        <h5>E-mail</h5>
                        <p>{{ estimateModals.email }}</p>
                    </div>

                    <div class='modal-display-table-AD-ask'>
                        <h5>Titre de la demande</h5>
                        <p>{{ estimateModals.estimateName }}</p>
                    </div>
                    <div class='modal-display-table-AD-ask'>
                        <h5>Contenu</h5>
                        <p class='modal-display-content'>{{ estimateModals.estimateContents }}</p>
                    </div>
                    <div class='modal-display-table-AD-ask'>
                        <h5>Plans .pdf</h5>
                        <button class='button-modal-pdf' @click='ddlEstimatesUserFile(estimateModals.id, estimateModals.estimateNumber)'> Demande {{ estimateModals.estimateNumber }} </button>
                    </div>
                    <div class='button-modal-answer'>
                        <button class='button-modal-pdf' type='text' v-show='!adminEstimateResponse' @click='adminEstimateResponse=true'><h5 class='show-response-button'>Formulaire de réponse</h5></button>
                    </div>
                </div>
                <!-- Input Form for estimate Admin response  -->
                <div class='modal-display-center form-request-estimate'>
                    <form @submit.prevent v-show='adminEstimateResponse' v-if="!savingSuccessfull" enctype="multipart/form-data">
                        <div class='align-item-center'>
                            <p v-if='savingUnsuccessfullFile'>Vous avez déja envoyé un Devis pour la commande de ce Client</p>
                        </div>
                        <div class='modal-display-center'>
                            <!-- <label for='inputEstimateAdminContents'><h5 class='modal-display-center modal-title-request-estimate'>Message du devis</h5></label><br> -->
                            <label for='inputEstimateAdminContents'><h5 class='modal-answer-admin-titles'>Message du devis</h5></label><br>
                            <textarea class='modal-answer-admin-contents' aria-describedby='estimateAdminContentsHelp' placeholder='Description du Devis'
                                name='inputEstimateAdminContents' v-model='estimateAdminContents'>
                            </textarea>
                            <p v-if='savingUnsuccessfullContent'>Vous devez écrire un message</p>
                        </div>

                        <div class='modal-display-center'>
                            <!-- <label for='inputEstimateAdminPrice'><h5 class='modal-display-center modal-title-request-estimate'>Renseignez le prix du Devis</h5></label><br> -->
                            <label for='inputEstimateAdminPrice'><h5 class='modal-answer-admin-titles'>Renseignez le prix du Devis</h5></label><br>
                            <input class='modal-answer-admin-inputs' type='number' required min='0' step='0.01' pattern='^\d+(?:\.\d{1,2})?$'
                            aria-describedby='estimateAdminPriceHelp'
                            name='inputEstimateAdminPrice' v-model='estimateAdminPrice'>
                            <p v-if='savingUnsuccessfullPrice'>Vous devez renseigner un prix positif</p>
                        </div>
                        <div class='modal-display-center'>
                            <!-- <label for='inputEstimateAdminFile'><h5 class='modal-display-center modal-title-request-estimate'>Choisissez la maquette de la pièce à réaliser au format .pdf</h5></label><br> -->
                            <label for='inputEstimateAdminFile'><h5 class='modal-answer-admin-titles'>Choisissez la maquette de la pièce à réaliser au format .pdf</h5></label><br>
                            <input type='file' aria-describedby='estimateAdminFile'
                            name='inputEstimateAdminFile' @change="estimateAdminFileChange">
                            <p v-if='savingUnsuccessfullAdminFile'>Vous devez choisir un fichier au format .pdf et faisant moins de 1 Mo </p>
                        </div>
                        <div class='modal-display-center button-modal-answer'>
                            <button class='button-modal-pdf' type='submit' @click='estimateEditAdmin(estimateModals.id)' v-if='!savingSuccessfull'><h5>Envoyer la réponse</h5></button>
                        </div>
                    </form>
                </div>
                 <div class='modal-display-center button-modal-answer'>
                    <button class='button-modal-pdf' type='text' v-show='adminEstimateResponse' @click='adminEstimateResponse=false' v-if='!savingSuccessfull'><h5 class='show-response-button'>Annuler</h5></button>
                </div>
                <div class="success" v-if="savingSuccessfull">
                    <h5>Votre devis a bien été envoyé</h5>
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
    name: 'Estimates',
    props:{
        'q':'',
        'estimates':Array,
        'paginationsEstimates':Object,
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
            isModalEstimateVisible: false,
            isModalOrderVisible: false,
            adminEstimateResponse:false,
            // Variables' modal
                estimateModals:{},
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
                axios.get('api/estimates?page=' + page)
                    .then(response => {
                        this.paginationsEstimates = response.data;
                    });
            })
        },
        // searchRequests() {

        //     axios.get('/sanctum/csrf-cookie').then(response => {
        //         axios.get(`api/estimatesSearch`).then ((response) =>
        //         {
        //             this.estimates=response.data.data
        //             console.log(this.estimates)
        //         }).catch ((errors) => {
        //             console.log(errors.response);
        //         })
        //     });
        // },
        ddlEstimatesUserFile(id, number){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            let fileId=this.fileId
            if(fileId > 0){
                this.fileId=fileId
                console.log(this.fileId)
            } else {
                this.fileId=id
                console.log(this.fileId)
            }
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/estimateUserDownload/${this.fileId}`,
                {
                    responseType: 'arraybuffer',
                    headers: {'Accept': 'application/pdf'}
                }
                ).then ((response) =>{
                    let blob = new Blob([response.data], { type: 'application/pdf' })
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    // link.setAttribute('download', 'devis.pdf'); // set custom file name
                    // document.body.appendChild(link);
                    link.download = 'Demande_'+number+'.pdf'
                    this.fileId=''
                    link.click(); // force download file without open new tab
                }).catch ((errors) => {
                    console.log(errors.response);
                    this.fileId=''
                    alert('Mauvaise id Bro')
                })
            })
        },
        estimateAdminFileChange(e){
            console.log(e.target.files[0]);
            this.estimateAdminFile = e.target.files[0];
        },
        estimateAdminShow(id){

            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

            // Show Modal and retrieve id
            this.isModalEstimateVisible = true
            let modalFileId=id
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/estimates/${modalFileId}`).then ((response) =>
                {
                    this.estimateModals=response.data
                    console.log(this.estimateModals)
                    this.modalFileId=''
                }).catch ((errors) => {
                    console.log(errors.response);
                    this.modalFileId=''
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
            this.isModalEstimateVisible = true;
            // this.isModalOrderVisible = true;
        },
        closeModal() {
            this.isModalEstimateVisible = false;
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
        getFilteredEstimates() {
            const lowerCaseSearch = this.q.toLowerCase()
            return this.estimates.filter(
                estimate => {
                    return estimate.estimateName.toLowerCase().includes(lowerCaseSearch)
                        || estimate.estimateContents.toLowerCase().includes(lowerCaseSearch)
                        || estimate.estimateNumber.toLowerCase().includes(lowerCaseSearch)
                        || estimate.paymentValidation.toLowerCase().includes(lowerCaseSearch);
                },
            )
        },
    },
    mounted(){
        // this.getResults();
        // this.searchRequests();
        console.log('Estimates Mounted')
    }
 }

</script>
