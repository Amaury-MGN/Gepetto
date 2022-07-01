<template>
    <div>
        <div class="container">
        <h1>Bienvenue Monsieur l'admin</h1>
        </div>
        <div>
            <div>
                <div class="" v-if="this.q
                    || getFilteredUsers.length     >= 1
                    || getFilteredEstimates.length >= 1
                    || getFilteredOrders.length    >= 1">

                    <button @click='hideUsers=!hideUsers'>{{ getFilteredUsers.length }} utilisateurs</button>
                    <button @click='hideEstimates=!hideEstimates'>{{ getFilteredEstimates.length }} devis</button>
                    <button @click='hideOrders=!hideOrders'>{{ getFilteredOrders.length }} Commandes</button>
                </div>
                <div class="" v-else>
                    <p>Aucune correspondance trouvée</p>
                </div>
                <input type="text" v-model="q" placeholder="Rechercher...">
            </div>
        </div>
        <div>
            <!-- Users -->
            <div>
                <table v-show='!hideUsers'>
                    <thead>
                        <th>
                            <p>ID</p>
                        </th>
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

                    </thead>
                    <tbody v-for='user in getFilteredUsers' v-bind:key='user.id' >
                        <td>
                            <p>{{ user.id }}</p>
                        </td>
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

                    </tbody>
                </table>
            </div>
            <!-- Estimates -->
            <div>
                <table v-show='hideEstimates'>
                    <thead>
                        <!-- <th>
                            <p>id</p>
                        </th>
                        <th>
                            <p>UserId</p>
                        </th> -->
                        <th>
                            <p>Titre</p>
                        </th>
                        <th>
                            <p>Numéro</p>
                        </th>
                        <!-- <th>
                            <p>Contenu du devis</p>
                        </th> -->
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

                    </thead>
                    <tbody v-for="estimate in getFilteredEstimates" v-bind:key="estimate.id" >
                        <!-- <td>
                            <p>{{ estimate.id }}</p>
                        </td>
                        <td>
                            <p>{{ estimate.user_id }}</p>
                        </td> -->
                        <td>
                            <p>{{ estimate.estimateName }}</p>
                        </td>
                        <td>
                            <p>{{ estimate.estimateNumber }}</p>
                        </td>
                        <!-- <td>
                            <p>{{ estimate.estimateContents }}</p>
                        </td> -->
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
                    </tbody>
                </table>
                <Modal v-show="isModalEstimateVisible" @close="closeModal">
                    <!-- Show DB named estimates -->
                    <template v-slot:header>
                        <h3>Devis {{ estimateModals.estimateNumber }} </h3>
                    </template>

                    <template v-slot:body>
                        <div v-if="!savingSuccessfull">
                            <div>
                                <p>id{{ estimateModals.id }}</p>
                            </div>
                            <div>
                                <p>{{ estimateModals.estimateName }}</p>
                            </div>
                            <div>
                                <p>{{ estimateModals.estimateContents }}</p>
                            </div>
                            <div>
                                <p>{{ estimateModals.estimateNumber }}</p>
                            </div>
                            <div>
                                <p>{{ estimateModals.estimateItemNumber }}</p>
                            </div>
                        </div>

                        <!-- Input Form for estimate Admin response  -->

                        <form @submit.prevent v-if="!savingSuccessfull" enctype="multipart/form-data">
                            <div>
                                <p v-if='savingUnsuccessfullFile'>Vous avez déja envoyé un Devis pour la commande de ce Client</p>
                            </div>
                            <div>
                                <label for='inputEstimateAdminContents'>Entrez un message avec le Devis</label><br>
                                <input type='textarea' aria-describedby='estimateAdminContentsHelp' placeholder='Description du Devis'
                                name='estimateAdminContents' v-model='estimateAdminContents'>
                                <p v-if='savingUnsuccessfullContent'>Vous devez écrire un message</p>
                            </div>

                            <div>
                                <label for='inputEstimateAdminPrice'>Renseignez le prix du Devis</label><br>
                                <input type='number' required min='0' step='0.01' pattern='^\d+(?:\.\d{1,2})?$' aria-describedby='estimateAdminPriceHelp' placeholder='Prix du Devis'
                                name='estimateAdminPrice' v-model='estimateAdminPrice'>
                                <p v-if='savingUnsuccessfullPrice'>Vous devez renseigner un prix positif</p>
                            </div>
                            <div>
                                <label for='inputEstimateAdminFile'>Choisissez la maquette de la pièce à réaliser au format .pdf</label><br>
                                <input type='file' aria-describedby='estimateAdminFile'
                                name='estimateAdminFile' @change="estimateAdminFileChange">
                                <p v-if='savingUnsuccessfullAdminFile'>Vous devez choisir un fichier au format .pdf et faisant moins de 1 Mo </p>
                            </div>
                            <div>
                            <button type='submit' class='btn btn-primary' @click='estimateEditAdmin(estimateModals.id)' v-if='!savingSuccessfull'>Enregistrer</button>
                            </div>
                        </form>
                        <div class="success" v-if="savingSuccessfull">
                            <p>Votre devis a bien été envoyé</p>
                        </div>
                    </template>

                    <template v-slot:footer>
                        Votre Devis Gratuit et Rapide
                    </template>
                </Modal>
            </div>
            <!-- Orders -->
            <div>
                <table v-show='hideOrders'>
                    <thead>
                        <!-- <th>
                            <p>ID</p>
                        </th>
                        <th>
                            <p>ID de l'utilisateur</p>
                        </th> -->
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

                    </thead>
                    <tbody v-for='order in getFilteredOrders' v-bind:key='order.id' >
                        <!-- <td>
                            <p>{{ order.id }}</p>
                        </td>
                        <td>
                            <p>{{ order.user_id }}</p>
                        </td> -->
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
                            <button @click='ddlOrderFile(order.id, order.orderNumber)'> Devis {{ order.orderNumber }} </button>
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
                    </tbody>
                </table>
                <Modal v-show="isModalOrderVisible" @close="closeModal">
                    <template v-slot:header>
                        <h3> {{ orderModals.orderNumber }} </h3>
                    </template>
                    <template v-slot:body>
                        <div>
                            <p>id: {{ orderModals.id }}</p>
                        </div>
                        <div>
                            <p>Nom de l'utilisateur: {{ orderModals.name }}</p>
                        </div>
                        <div>
                            <p>Nombre d'objets: {{ orderModals.orderItems }}</p>
                        </div>
                        <div>
                            <button @click='ddlOrderFile(orderModals.id, orderModals.orderNumber)'> Télécharger le devis</button>
                        </div>
                        <div>
                            <p>Numéro de commande: {{ orderModals.orderNumber }}</p>
                        </div>
                        <div>
                            <p>Statut de la commande: <span id='editStatus' v-show='!hideEditOrder'>{{ orderModals.orderProgress }}</span>
                                <select v-show='hideEditOrder' v-model='editStatus'>
                                    <option value="">--Choisissez une option--</option>
                                    <option value="En attente">En attente</option>
                                    <option value="En cours d'usinage">En cours d'usinage</option>
                                    <option value="Arrêté">Arrêté</option>
                                    <option value="Terminé">Terminé</option>
                                </select>
                                <button @click='hideEditOrder=!hideEditOrder' v-show='!hideEditOrder'>Editer</button>
                                <button v-show='hideEditOrder' @click='editOrderStatus(orderModals.id), hideEditOrder=!hideEditOrder'>Enregistrer</button>
                            </p>
                        </div>
                        <div>
                            <p>Prix du devis: {{ orderModals.orderPrice }} € TTC</p>
                        </div>
                        <div>
                            <p>Date de création de la commande: {{ orderModals.created_at }}</p>
                        </div>
                        <div>
                            <p>Date de la dernière MaJ: {{ orderModals.updated_at }}</p>
                        </div>
                    </template>
                    <template v-slot:footer>
                        Récapitulatif de la commande
                    </template>
                </Modal>
            </div>
        </div>
        <!-- Edit Posts static Website -->
        <div>
            <button @click='editStaticWebsite=!editStaticWebsite'>Editer les images du site</button>
        </div>
        <div v-show='editStaticWebsite' class='lsh_flex-information'>
            <div>
                <button @click='editImages=!editImages'>Modifier les images</button>
                <button @click='editPosts=!editPosts'>Modifier les posts</button>
                <button @click='isModalNewImageVisble=!isModalNewImageVisble, successNewImage=false'>Enregistrer une nouvelle image sur S3</button>
            </div>
            <div>
                <Modal v-show="isModalNewImageVisble" @close="closeModal">
                    <!-- Show DB named estimates -->
                    <template v-slot:header>
                        <h3>Enregistrer une nouvelle image</h3>
                    </template>

                    <template v-slot:body>
                        <div>
                            <p v-show='successNewImage'>Félicitation, vous avez bien enregistrer l'image</p>
                        </div>
                        <form @submit.prevent enctype="multipart/form-data" v-show='!successNewImage'>
                            <div>
                                <label for='inputName'>Nom de l'image</label>
                                <input type='text' name='name' placeHolder='Entrez un nom' v-model='newImageName'>
                                <p v-show='failUploadImageName'>Vous devez entrer un nom pour l'image</p>

                            </div>
                            <div>
                                <label for='inputFile'>Choisissez un fichier</label>
                                <input type='file' name='newImageFile' @change="storeNewImageChange">
                                <p v-show='failUploadImageFile'>Vous devez choisir une image aux formats .jpg, .jpeg, .svg ou .png et faisant moins de 4Mo</p>
                            </div>
                            <div>
                                <button type='submit' @click='storeNewImage'>Enregistrer</button>
                            </div>
                        </form>
                    </template>

                    <template v-slot:footer>
                        Enregistrement de l'image sur s3
                    </template>
                </Modal>

            </div>

            <div v-show='editImages' class='lsh_flex-information'>
                <!-- Show All Images inside imagesStorages DB (s3) -->
                <button v-show='!hideAllImage' @click='ddlAllImage'>
                    <h4>Toutes les images enregistrées</h4>
                </button>
                <button v-show='hideAllImage' @click='hideAllImage=false'>
                    <h4>Toutes les images enregistrées</h4>
                </button>
                <div v-show='hideAllImage' class='lsh_flex-information' v-for='allImage in allImages' :key='allImage.id'> <!-- V-for='s3' pour récupérer toutes les images et mettre une barre de défilement à droite-->
                    <img :src='allImage.url' class='lsh_allImageCards'>
                    <p>Nom : {{ allImage.imageName }}</p>
                    <p>Url : {{ allImage.url }}</p>
                </div>
                <button @click='hideWebsiteImages=!hideWebsiteImages'>
                    <h4>Images présentes sur le site à l'heure actuelle</h4>
                </button>
                <div v-show='hideWebsiteImages'>
                    <!-- Edit Home Website images -->
                    <div>
                        <button v-show='!hideHomeImages' @click='ddlHomeImages'>Accueil</button>
                        <button v-show='hideHomeImages' @click='hideHomeImages=false'>Accueil</button>
                        <div  class='lsh_flex-information' v-show='hideHomeImages' v-for='homeImage in homeImages' :key='homeImage.id'> <!--v-for pour récupérer les images avec api/img/1-->
                            <div>
                                <img :src='homeImage.firstImage' class='lsh_allImageCards'>
                                <p>Url : {{ homeImage.firstImage }}</p>
                                <input type='text' :placeholder="homeImage.firstImage">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='homeImage.secondImage' class='lsh_allImageCards'>
                                <p>Url : {{ homeImage.secondImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='homeImage.thirdImage' class='lsh_allImageCards'>
                                <p>Url : {{ homeImage.thirdImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='homeImage.fourthImage' class='lsh_allImageCards'>
                                <p>Url : {{ homeImage.fourthImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                        </div>
                        <button>Editer</button>
                    </div>
                    <!-- Edit Workplace Website images -->
                    <div>
                        <button v-show='!hideWorkplaceImages' @click='ddlWorkplaceImages'>Notre Entreprise</button>
                        <button v-show='hideWorkplaceImages' @click='hideWorkplaceImages=false'>Notre Entreprise</button>
                        <div class='lsh_flex-information' v-show='hideWorkplaceImages' v-for='workplaceImage in workplaceImages' :key='workplaceImage.id'> <!--v-for pour récupérer les images avec api/img/2-->
                            <div>
                                <img :src='workplaceImage.firstImage' class='lsh_allImageCards'>
                                <p>Url : {{ workplaceImage.firstImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='workplaceImage.secondImage' class='lsh_allImageCards'>
                                <p>Url : {{ workplaceImage.secondImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='workplaceImage.thirdImage' class='lsh_allImageCards'>
                                <p>Url : {{ workplaceImage.thirdImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='workplaceImage.fourthImage' class='lsh_allImageCards'>
                                <p>Url : {{ workplaceImage.fourthImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                             </div>
                        </div>
                        <button>Editer</button>
                    </div>
                    <!-- Edit Skills website images -->
                    <div>
                        <button v-show='!hideSkillsImages' @click='ddlSkillsImages'>Nos Techniques</button>
                        <button v-show='hideSkillsImages' @click='hideSkillsImages=false'>Nos Techniques</button>
                        <div class='lsh_flex-information' v-show='hideSkillsImages' v-for='skillsImage in skillsImages' :key='skillsImage.id'> <!--v-for pour récupérer les images avec api/img/3-->

                            <div>
                                <img :src='skillsImage.firstImage' class='lsh_allImageCards'>
                                <p>Url : {{ skillsImage.firstImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='skillsImage.secondImage' class='lsh_allImageCards'>
                                <p>Url : {{ skillsImage.secondImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='skillsImage.thirdImage' class='lsh_allImageCards'>
                                <p>Url : {{ skillsImage.thirdImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                            <div>
                                <img :src='skillsImage.fourthImage' class='lsh_allImageCards'>
                                <p>Url : {{ skillsImage.fourthImage }}</p>
                                <input type='text' placeholder="Nouvelle URL pour l'image">
                                <button>Enregistrer</button>
                            </div>
                        </div>
                        <button>Editer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import Modal from './../ModalComponent.vue';
    export default {
        components: {
            Modal,
        },
        data(){
            return {
                token:localStorage.getItem('token'),
                // Variables' function
                users:[],
                estimates:[],
                orders:[],
                fileId:0,
                // Table Seek and Hide
                hideUsers:true,
                hideEstimates:false,
                hideOrders:false,
                hideEditOrder:false,

                // edit Static website
                editStaticWebsite:false,
                editImages:false,

                allImages:{},
                hideAllImage:false,



                homeImages:{},
                workplaceImages:{},
                skillsImages:{},
                hideHomeImages:false,
                hideWorkplaceImages:false,
                hideSkillsImages:false,
                hideWebsiteImages:false,
                editPosts:false,
                // image Modal
                isModalNewImageVisble:false,
                newImageFile:'',
                newImageName:'',
                failUploadImageName:false,
                failUploadImageFile:false,
                successNewImage:false,

                // Modal
                isHidden: false,
                isModalEstimateVisible: false,
                isModalOrderVisible: false,
                    // Variables' modal
                    modalFileId:'',
                    estimateModals:{},
                    orderModals:{},
                    estimateAdminContents:'',
                    estimateAdminFile:'',
                    estimateAdminPrice: 0,
                    orderStatus:'',
                    editStatus:'',

                // Form errors
                savingSuccessfull:false,
                savingUnsuccessfullContent:false,
                savingUnsuccessfullAdminFile:false,
                savingUnsuccessfullPrice:false,
                savingUnsuccessfullFile:false,
                //SearchBar
                q: '',
            }
        },
        methods:{
            searchRequests() {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/users`).then ((response) =>
                        {
                            this.users=response.data.data
                            console.log(response.data.data);
                        }).catch ((errors) => {
                            console.log(errors);
                    })
                });
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/estimates`).then ((response) =>
                    {
                        this.estimates=response.data.data
                        console.log(this.estimates)
                    }).catch ((errors) => {
                        console.log(errors.response);
                    })
                });
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/orders`).then ((response) =>
                        {
                            this.orders=response.data.data
                            console.log(this.orders);
                        }).catch ((errors) => {
                            console.log(errors.response);
                    })
                });

            },
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
            // Modal Functions
            estimateAdminShow(id){

                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                // Show Modal and retrieve id
                this.isModalEstimateVisible = true
                let modalFileId=id
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/estimates/${modalFileId}`).then ((response) =>
                    {
                        this.estimateModals=response.data.data
                        console.log(this.estimateModals)
                        this.modalFileId=''
                    }).catch ((errors) => {
                        console.log(errors.response);
                        this.modalFileId=''
                    })
                })
            },
            orderAdminShow(id){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;

                // Show Modal and retrieve id
                this.isModalOrderVisible = true
                let modalFileId=id
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get(`api/orders/${modalFileId}`).then ((response) =>
                    {
                        this.orderModals=response.data
                        console.log(this.orderModals)
                        this.modalFileId=''
                    }).catch ((errors) => {
                        console.log(errors.response);
                        this.modalFileId=''
                    })
                })
            },
            estimateAdminFileChange(e){
                console.log(e.target.files[0]);
                this.estimateAdminFile = e.target.files[0];
            },
            estimateEditAdmin(id){
                console.log(modalFileId)
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };
                this.estimateAdminPrice.replace(/,/g, '.')

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
            editOrderStatus(id){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.patch(`api/orders/${id}`,{
                        orderProgress:this.editStatus
                    }).then ((response) =>{
                        if(response.status===200){
                            document.getElementById('editStatus').innerHTML = this.editStatus;
                        }
                    }).catch ((errors) => {
                        console.log(errors.response);
                    })
                })
            },
            showModal() {
                this.isModalEstimateVisible = true;
                this.isModalOrderVisible = true;
            },
            closeModal() {
                this.isModalEstimateVisible = false;
                this.isModalOrderVisible = false;
                this.hideEditOrder=false;
                this.isModalNewImageVisble=false;
            },
            // Edit images Static Website
            ddlAllImage(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                 axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/imagesStorages').then ((response) =>{
                        this.allImages=response.data.data
                        this.hideAllImage=true
                        console.log(this.allImages)

                    }).catch ((errors) => {
                        console.log(errors);


                    })
                })
            },
            ddlHomeImages(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                 axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/imagesWebsite/1').then ((response) =>{
                        this.homeImages=response.data
                        this.hideHomeImages=true
                        console.log(this.homeImages)

                    }).catch ((errors) => {
                        console.log(errors);

                    })
                })
            },
            ddlWorkplaceImages(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                 axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/imagesWebsite/2').then ((response) =>{
                        this.workplaceImages=response.data
                        this.hideWorkplaceImages=true
                        console.log(this.workplaceImages)

                    }).catch ((errors) => {
                        console.log(errors);

                    })
                })

            },
            ddlSkillsImages(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                 axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('api/imagesWebsite/3').then ((response) =>{
                        this.skillsImages=response.data
                        this.hideSkillsImages=true
                        console.log(this.skillsImages)

                    }).catch ((errors) => {
                        console.log(errors);

                    })
                })
            },
            storeNewImageChange(e){
                console.log(e.target.files[0]);
                this.newImageFile = e.target.files[0];
            },
            storeNewImage(){
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let formData = new FormData;
                formData.append('imageName',this.newImageName);
                formData.append('file',this.newImageFile);

                if(this.newImageName == ''){
                    this.failUploadImageName=true
                }else {
                    this.failUploadImageName=false
                }
                if ( this.newImageFile == ''){
                    this.failUploadImageFile=true
                }else{
                    this.failUploadImageFile=false
                    }
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post(`api/imagesStorages`, formData, config)
                    .then ((response) =>{
                        this.successNewImage=true

                    }).catch ((errors) => {
                        if (errors ){
                            this.failUploadImageFile=true
                            // this.successNewImage=true
                        }
                    })
                })
            },
        },
        computed: {
            // hideResults(){

            // },
            getFilteredUsers() {
                const lowerCaseSearch = this.q.toLowerCase()
                console.log(this.users)
                return this.users.filter(
                    user => {
                        return user.pseudonym.toLowerCase().includes(lowerCaseSearch)
                            || user.email.toLowerCase().includes(lowerCaseSearch);
                    },
                )
            },
            getFilteredEstimates() {
                const lowerCaseSearch = this.q.toLowerCase()
                return this.estimates.filter(
                    estimate => {
                        return estimate.estimateName.toLowerCase().includes(lowerCaseSearch)
                            || estimate.estimateContents.toLowerCase().includes(lowerCaseSearch)
                            || estimate.paymentValidation.toLowerCase().includes(lowerCaseSearch);
                    },
                )
            },
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
        mounted() {
            this.searchRequests();
        },

    }
    </script>
