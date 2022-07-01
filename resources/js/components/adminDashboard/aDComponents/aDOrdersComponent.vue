<template>
        <div>
            <div>
                <div class='searchbar-results' v-if="this.q && getFilteredOrders.length > 1">
                    <p>Il existe {{ getFilteredOrders.length }} Commandes</p>
                </div>
                <div class='searchbar-results' v-if="this.q && getFilteredOrders.length === 1">
                    <p>Il existe {{ getFilteredOrders.length }} commande</p>
                </div>
                <div class='searchbar-results' v-else-if="this.q && getFilteredOrders.length===0">
                    <p>Aucune correspondance trouvée</p>
                </div>
            </div>
            <div class='searchbar-title-results' v-if='this.q && getFilteredOrders.length >= 1'>
                <div class='searchbar-title-results'>
                    <h5>Résultat de la recherche</h5>
                </div>
            </div>
            <table class='table-size' v-if='this.q && getFilteredOrders.length >= 1'>
                <thead  class='table-color'>
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
                            <p>Devis .pdf</p>
                        </th>
                        <th>
                            <p>Avancée</p>
                        </th>
                        <th>
                            <p>Date de Création</p>
                        </th>
                        <th>
                            <p>Dernière MAJ</p>
                        </th>
                        <th>
                            <p>Détails</p>
                        </th>
                    </tr>
                </thead>
                    <tbody class='table-color-tbody' v-for='order in getFilteredOrders' v-bind:key='order.id'>
                        <tr :class="{'table-color-shading-2':order.id% 2 === 0, 'table-color-shading-1':order.id% 2 !== 0 }">
                            <td>
                                <p>{{ order.orderName }}</p>
                            </td>
                            <td>
                                <p>{{ order.orderNumber }}</p>
                            </td>
                            <td>
                                <p>{{ order.orderItems }}</p>
                            </td>
                            <td>
                                <button @click='ddlOrderFile(order.id, order.orderNumber)'> {{ order.orderNumber }} </button>
                            </td>
                            <td>
                                <p>{{ order.orderProgress }}</p>
                            </td>

                            <td>
                                <p>{{ order.created_at }}</p>
                            </td>
                            <td>
                                <p>{{ order.updated_at }}</p>
                            </td>
                            <td>
                                <button @click="orderAdminShow(order.id)">Plus de Détails</button>
                            </td>
                        </tr>
                    </tbody>
                    <div class='searchbar-footer'></div>
            </table>
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
                            <p>Devis .pdf</p>
                        </th>
                        <th>
                            <p>Avancée</p>
                        </th>
                        <th>
                            <p>Date de Création</p>
                        </th>
                        <th>
                            <p>Dernière MAJ</p>
                        </th>
                        <th>
                            <p>Détails</p>
                        </th>
                    </tr>
                </thead>
                <tbody class='table-color-tbody' v-for='order in paginationsOrders.data' v-bind:key='order.id' >
                    <tr :class="{'table-color-shading-2':order.id% 2 === 0, 'table-color-shading-1':order.id% 2 !== 0 }">
                        <td>
                            <p>{{ order.orderName }}</p>
                        </td>
                        <td>
                            <p>{{ order.orderNumber }}</p>
                        </td>
                        <td>
                            <p>{{ order.orderItems }}</p>
                        </td>
                        <td>
                            <button @click='ddlOrderFile(order.id, order.orderNumber)'> {{ order.orderNumber }} </button>
                        </td>
                        <td>
                            <p>{{ order.orderProgress }}</p>
                        </td>

                        <td>
                            <p>{{ order.created_at }}</p>
                        </td>
                        <td>
                            <p>{{ order.updated_at }}</p>
                        </td>
                        <td>
                            <button @click="orderAdminShow(order.id)">Plus de Détails</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :data="paginationsOrders" @pagination-change-page="getResults"></pagination>
            <Modal v-show="isModalOrderVisible" @close="closeModal">
                <template v-slot:header>
                    <h3>Commande n°{{ orderModals.orderNumber }} </h3>
                </template>
                <template v-slot:body>
                    <div class='modal-orders-style'>
                        <div class='modal-orders-style'>
                            <!-- <div class='modal-display-table'>
                                <div><h5>id: </h5></div>
                                <div><p>{{ orderModals.id }}</p></div>
                            </div> -->
                            <div class='modal-display-table'>
                                <div><h5>Prénom de l'utilisateur: </h5></div>
                                <div><p>{{ orderModals.firstname }}</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>Nom de l'utilisateur: </h5></div>
                                <div><p>{{ orderModals.lastname }}</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>E-mail: </h5></div>
                                <div><p>{{ orderModals.email }}</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>Nombre d'objets: </h5></div>
                                <div><p>{{ orderModals.orderItems }}</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>Devis .pdf</h5></div>
                                <button class='button-modal-pdf' @click='ddlOrderFile(orderModals.id, orderModals.orderNumber)'>Télécharger le devis</button>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>Numéro de commande: </h5></div>
                                <div><p>{{ orderModals.orderNumber }}</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div>
                                    <h5>Statut de la commande:</h5>
                                </div>
                                <div>
                                    <p id='editStatus' v-show='!hideEditOrder'>{{ orderModals.orderProgress }}</p>
                                </div>
                                <select class='button-modal-pdf' v-show='hideEditOrder' v-model='editStatus'>
                                    <option value="">--Choisissez une option--</option>
                                    <option value="En attente">En attente</option>
                                    <option value="En cours d'usinage">En cours d'usinage</option>
                                    <option value="Arrêté">Arrêté</option>
                                    <option value="Terminé">Terminé</option>
                                </select>
                            </div>
                            <button class='button-modal-pdf' @click='hideEditOrder=!hideEditOrder' v-show='!hideEditOrder'>Editer le statut</button>
                            <button class='button-modal-pdf' v-show='hideEditOrder' @click='editOrderStatus(orderModals.id), hideEditOrder=!hideEditOrder, getResults()'>Enregistrer</button>


                            <div class='modal-display-table'>
                                <div><h5>Prix du devis: </h5></div>
                                <div><p>{{ orderModals.orderPrice }} € TTC</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>Date de création de la commande: </h5></div>
                                <div><p>{{ orderModals.created_at }}</p></div>
                            </div>
                            <div class='modal-display-table'>
                                <div><h5>Date de la dernière MaJ: </h5></div>
                                <div><p>{{ orderModals.updated_at }}</p></div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-slot:footer>
                    Récapitulatif de la commande
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
    name: 'Orders',
    props:{
        'q':'',
        'orders':Array,
        'paginationsOrders':Object,
    },
    data(){
    return{
        token:localStorage.getItem('token'),
        // Variables' function
            users:[],
            estimates:[],
            // orders:[],
            // paginationsOrders:{},
        // Table Seek and Hide
            hideEditOrder:false,
        // Modal
            isHidden: false,
            isModalOrderVisible: false,
                // Variables' modal
                    orderModals:{},
                    orderStatus:'',
                    editStatus:'',
}
    },

    methods: {
        getResults(page = 1) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/orders?page=' + page)
                    .then(response => {
                        this.paginationsOrders = response.data;
                        console.log('test pagination',this.paginationsOrders)
                    });
            })
        },
        // searchRequests() {
        //     axios.get('/sanctum/csrf-cookie').then(response => {
        //         axios.get(`api/ordersSearch`).then ((response) =>
        //             {
        //                 this.orders=response.data.data
        //                 console.log(this.orders,'test');
        //             }).catch ((errors) => {
        //                 console.log(errors.response);
        //         })
        //     });

        // },
        ddlOrderFile(id, number){
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
                axios.get(`api/estimateAdminDownload/${this.fileId}`,
                {
                    responseType: 'arraybuffer',
                    headers: {'Accept': 'application/pdf'}
                }
                ).then ((response) =>{
                    console.log(number)
                    let blob = new Blob([response.data], { type: 'application/pdf' })
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)

                    link.download = 'Devis_'+number+'.pdf'
                    this.fileId=''
                    link.click();
                }).catch ((errors) => {
                    console.log(errors.response);
                    this.fileId=''
                    alert('Mauvaise id Bro')
                })
            })
        },
        orderAdminShow(id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            this.isModalOrderVisible = true
            let modalFileId=id
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(`api/orders/${modalFileId}`)
                .then ((response) =>{
                    this.orderModals=response.data
                    console.log(this.orderModals)
                    this.modalFileId=''


                }).catch ((errors) => {
                    console.log(errors.response);
                    this.modalFileId=''
                })
            })
        },
        editOrderStatus(id){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.patch(`api/ordersUpdate/${id}`,{
                    orderProgress:this.editStatus
                }).then ((response) =>{
                    if(response.status===200){
                        document.getElementById('editStatus').innerHTML = this.editStatus;
                        this.searchRequests();
                    }
                }).catch ((errors) => {
                    console.log(errors.response);
                })
            })
        },
        showModal() {
            // this.isModalEstimateVisible = true;
            this.isModalOrderVisible = true;
        },
        closeModal() {
            // this.isModalEstimateVisible = false;
            this.isModalOrderVisible = false;
            this.hideEditOrder=false;
            // this.isModalNewImageVisble=false;
        },
    },
    computed: {
        getFilteredOrders(){
            const lowerCaseSearch = this.q.toLowerCase()
            return this.orders.filter(
                order => {
                    return order.orderName.toLowerCase().includes(lowerCaseSearch)
                        || order.orderNumber.toLowerCase().includes(lowerCaseSearch)
                        || order.orderProgress.toLowerCase().includes(lowerCaseSearch);
                },
            )
        },

    },
    mounted(){
        // this.searchRequests();
        // this.getResults();
        console.log('Orders Mounted')
    }
 }

</script>
