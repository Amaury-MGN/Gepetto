<template>
    <div>
        <div class='infos-title-user'>
            <h2>Mes Commandes</h2>
        </div>
        <div v-show='isOrderUserVisible' class='cards-container'>
            <div class='card-border' v-for='ordersUser in ordersUsers' :key='ordersUser.id'>
                 <div class='cards-center'>
                    <div>
                        <h5>Numéro de la commande : </h5>
                    </div>
                    <div>
                        <p>{{ ordersUser.orderNumber }} </p>
                    </div>
                </div>
                 <div class='cards-center'>
                    <div>
                        <h5>Nombre de pièces souhaitées : </h5>
                    </div>
                    <div>
                        <p>{{ ordersUser.orderItems }}</p>
                    </div>
                </div>
                 <div class='cards-center'>
                    <div>
                        <h5>Prix de la commande: </h5>
                    </div>
                    <div>
                        <p>{{ ordersUser.orderPrice }} euros</p>
                    </div>
                </div>
                <div class='cards-center'>
                    <button  class='btn-reponse-userDB button-card-userDB'
                        @click='orderById(ordersUser.id);showModal(ordersUser.id)'>
                        <h5>Voir le devis</h5>
                    </button>
                </div>
            </div>
        </div>
        <Modal v-show="isModalVisible" @close="closeModal">
            <template v-slot:header>
                <h3>Votre commande n°{{ orderUserByIds.orderNumber }}</h3>
            </template>

            <template v-slot:body>
                <div class='modal-orders-style'>
                    <div class='modal-orders-style'></div>
                        <div class='modal-display-table'>
                            <div><h5>Titre du Devis :</h5></div>
                            <div><p> {{ orderUserByIds.orderName }}</p></div>
                        </div>
                        <div class='modal-display-table'>
                            <div><h5>Numéro du Devis :</h5></div>
                            <div><p> {{ orderUserByIds.orderNumber }}</p></div>
                        </div>

                        <div class='modal-display-table'>
                            <div><h5>Nombre de pièces :</h5></div>
                            <div><p> {{ orderUserByIds.orderItems }}</p></div>
                        </div>
                    <!-- </div>
                    <div class='modal-orders-style'> -->
                        <div class='modal-display-table'>
                            <div><h5>Prix de la commande: </h5></div>
                            <div><p>{{ orderUserByIds.orderPrice }} euros</p></div>
                        </div>
                        <div class='modal-display-table'>
                            <div><h5>Statut de la commande :</h5></div>
                            <div><p>  {{ orderUserByIds.orderProgress }} </p></div>
                        </div>
                        <div class='modal-display-table'>
                            <div><h5>Commande acceptée le : </h5></div>
                            <div><p> {{ orderUserByIds.created_at }} </p></div>
                        </div>
                        <div class='modal-display-table'>
                            <div><h5>Dernière actualisation : </h5></div>
                            <div><p>{{ orderUserByIds.updated_at }} </p></div>
                        </div>
                    </div>
                <!-- </div> -->
               <!--  <div class='modal-display-center modal-estimates-style modal-estimates-column'>

                    <button class='btn-fermer-userDB' v-show='!isAdminResponseVisible' @click='isHiddenEstimateAdminResponse'><h5>Voir ma demande</h5></button>
                    <h4 v-show='!isAdminResponseVisible'>Réponse à votre demande de devis</h4>
                    <button class='btn-fermer-userDB' v-show='isAdminResponseVisible' @click='isAdminResponseVisible=!isAdminResponseVisible'><h5>Voir la réponse de Gepetto</h5></button>
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
                </div>-->
            </template>

            <template v-slot:footer>
                Toutes vos informations sur la commande
            </template>
        </Modal>
        <!-- <div v-show='isOrderByIdVisible' >
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

            </div>-->
        </div>
</template>

<script>
import Modal from '../../ModalComponent.vue';
 export default {
    components: {
        Modal,
    },
    name: 'Orders',
    props:{
        'ordersUsers': Array,
    },
    data(){
    return{
        // Infos from DB orders
        isOrderUserVisible:true,
        orderUserByIds:{},
        isOrderByIdVisible:false,
        // Modal
        isModalVisible: false,
        // Local storage
        id:localStorage.getItem('id'),
        token:localStorage.getItem('token')
    }
    },
    created(){
    },
    methods: {
        orderById($id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/orders/${$id}`, {

                }).then ((response) => {
                    this.orderUserByIds=response.data
                    console.log(this.orderUserByIds)
                }).catch ((errors) => {
                    console.log(errors.response);

                })
            });
        },
         isHiddenOrderById(){

            this.isOrderUserVisible=false;
            this.isOrderByIdVisible=true;
        },
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },

    },
    mounted(){

    }
 }

</script>
