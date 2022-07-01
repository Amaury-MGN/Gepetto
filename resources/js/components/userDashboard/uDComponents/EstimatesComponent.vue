<template>
    <div>
        <div class='infos-title-user'>
                <h2>Mes Devis</h2>
            </div>
        <div v-show='isEstimatesUserVisible' class='cards-container'>
            <div class='card-border' v-for='estimatesUser in estimatesUsers' :key='estimatesUser.id'>
                <div class='cards-center'>
                    <div>
                        <h5>Numéro du Devis : </h5>
                    </div>
                    <div>
                        <p>{{ estimatesUser.estimateNumber }} </p>
                    </div>
                </div>
                <div class='cards-center'>
                    <div>
                        <h5>Titre du devis : </h5>
                    </div>
                    <div>
                        <p>{{ estimatesUser.estimateName }} </p>
                    </div>
                </div>

                <div class='cards-center'>
                    <div>
                        <h5>Nombre de pièces souhaitées : </h5>
                    </div>
                    <div>
                        <p>{{ estimatesUser.estimateItemNumber }}</p>
                    </div>
                </div>
                <div class='cards-center'>
                    <button  class='btn-reponse-userDB button-card-userDB' @click='estimateById(estimatesUser.id);showModal(estimatesUser.id)'><h5>Voir le devis</h5></button>
                </div>
            </div>
        </div>
        <Modal v-show="isModalVisible" @close="closeModal">
            <template v-slot:header>
                <h3>Votre devis n°{{ estimateUserByIds.estimateNumber }}</h3>
            </template>

            <template v-slot:body>
                <div class='modal-estimates-style'>
                    <div class='modal-display-table'>
                        <div><h5>Numéro du Devis :</h5></div>
                        <div><p> {{ estimateUserByIds.estimateNumber }}</p></div>
                    </div>
                    <div class='modal-display-table'>
                        <div><h5>Titre du Devis :</h5></div>
                         <div><p> {{ estimateUserByIds.estimateName }}</p></div>
                    </div>
                    <div class='modal-display-table'>
                        <div><h5>Nombre de pièces souhaitées :</h5></div>
                        <div><p> {{ estimateUserByIds.estimateItemNumber }}</p></div>
                    </div>
                </div>
                <div class='modal-display-center modal-estimates-style modal-estimates-column'>

                    <button class='btn-fermer-userDB' v-show='!isAdminResponseVisible' @click='isHiddenEstimateAdminResponse'><h5>Voir ma demande</h5></button> <!-- Quand je clique sur ce bouton j'active UserContents et je referme AdminContents -->
                    <h4 v-show='!isAdminResponseVisible'>Réponse à votre demande de devis</h4>
                    <button class='btn-fermer-userDB' v-show='isAdminResponseVisible' @click='isAdminResponseVisible=!isAdminResponseVisible'><h5>Voir la réponse de Gepetto</h5></button> <!--Fait l'inverse-->
                </div>
                <div  class='modal-display-center' v-show='!isAdminResponseVisible'>
                    <div  class='message-modal-userDB' v-show='adminResponse'>
                        <p id='adminContents'>{{estimateAdminByIds.estimateAdminContents}}</p>
                        <p id='adminPrice'>Prix du devis: {{ estimateAdminByIds.estimateAdminPrice }} euros</p>
                    </div>
                    <div  class='message-modal-userDB-center' v-show='!adminResponse'>
                        <p id='adminContents'>Vous n'avez pas encore reçu de réponse de la part de notre entreprise</p>
                        <p id='adminPrice'>Aucun prix n'a encore été défini pour votre devis</p>
                    </div>
                    <div class='modal-display-center modal-estimates-style modal-estimates-column'>
                        <button class='btn-reponse-userDB' v-show='adminResponse' @click='ddlEstimatesAdminFile(estimateUserByIds.id,estimateUserByIds.estimateNumber)'>Devis à télécharger</button>
                    </div>
                    <div class='modal-display-center modal-estimates-style modal-estimates-column'>
                        <button class='btn-reponse-userDB' v-show='adminResponse' @click.prevent='paymentPage(estimateUserByIds.id)'>Payer</button>
                    </div>
                </div>
                <div class='modal-display-center'>
                    <div class='message-modal-userDB' v-show='isAdminResponseVisible'>
                        <p>{{ estimateUserByIds.estimateContents }}</p>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                Toutes vos informations sur le devis
            </template>
        </Modal>
    </div>
</template>

<script>
 import Modal from '../../ModalComponent.vue';
 export default {
    components: {
        Modal,
    },
    name: 'Estimates',
    props:{
        'estimatesUsers':Array,
    },
    data(){
    return{
        // Informations from DB estimates
        estimateUserByIds:{},
        estimateAdminByIds:{},
        isEstimatesUserVisible:true,
        isEstimateByIdVisible:false,
        isAdminResponseVisible:false,
        adminResponse:false,
        // Modal
        isModalVisible: false,
         // Local storage
        id:localStorage.getItem('id'),
        token:localStorage.getItem('token')
}
    },

    methods: {
        estimateById($id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            this.isModalVisible = true;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/estimates/${$id}`, {
                }).then ((response) => {
                    this.estimateUserByIds=response.data.data
                    console.log( this.estimateUserByIds)
                    this.id='';
                }).catch ((errors) => {
                    console.log(errors.response);
                    this.id='';

                })
            });
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/estimateAdminFile/${$id}`, {

                }).then ((response) => {
                    console.log('Devis n°' + $id + ' bien reçu')
                    this.estimateAdminByIds=response.data.data
                    this.adminResponse=true
                    // console.log(response.data.data)

                }).catch ((errors) => {
                    console.log(errors.response.status);
                    if(errors.response.status===401){
                        this.adminResponse=false
                    }

                })
            })
        },
        ddlEstimatesAdminFile($id, $number){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                console.log($id);

                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/estimateAdminDownload/${$id}`,
                    {
                        responseType: 'arraybuffer',
                        headers: {'Accept': 'application/pdf'}
                    }
                    ).then ((response) =>{
                        let blob = new Blob([response.data], { type: 'application/pdf' })
                        let link = document.createElement('a')
                        link.href = window.URL.createObjectURL(blob)

                        link.download = 'Devis_'+$number+'.pdf'
                        link.click();
                    }).catch ((errors) => {
                        console.log(errors.response);
                        alert('Mauvaise id Bro')
                    })
                })
            },
        paymentPage($id){
            this.idPayment=$id
            console.log(this.idPayment)
                this.$router.push({
                name: 'payment',
                params: {
                    id:$id,
                    // items: this.idPayment
                }
            });
        },
        isHiddenEstimateById(){
            this.isEstimatesUserVisible=false;
            this.isEstimateByIdVisible=true;
            this.isAdminResponseVisible=false;
        },
        isHiddenEstimateAdminResponse(){
            this.isEstimatesUserVisible=false;
            this.isEstimateByIdVisible=true;
            this.isAdminResponseVisible=true;
        },
                  // Modal Functions
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
    },
    mounted(){
        console.log('EstimatesComponent Mounted')
    }
 }

</script>
