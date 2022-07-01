<template>
    <div>
        <!-- <img src='storage/images/TEc13B0IOVABj39TnhS982xzpzieUGycsTGLn5T6.jpg'> -->
        <div class='admin-postion-new-image'>
            <div class='admin-postion-right-new-image'>
                <button @click='isModalNewImageVisble=!isModalNewImageVisble, successNewImage=false, failUploadImageName=false,failUploadImageFile=false'>Enregistrer une nouvelle image</button>
            </div>
        </div>
        <div>
            <div class='edit-images-positions-titles'>
                <div class='edit-posts-titles'>
                    <button v-show='!hideAllImage' @click='ddlAllImage'>
                        <h5>Toutes les images enregistrées</h5>
                    </button>

                    <button  v-show='hideAllImage' @click='hideAllImage=false'>
                        <h5>Toutes les images enregistrées</h5>
                    </button>

                </div>

                <div class='edit-images-titles'>
                    <button @click='hideWebsiteImages=!hideWebsiteImages'>
                        <h5>Images présentes sur le site actuellement</h5>
                    </button>
                </div>
            </div>
            <div class='all-position-images-cards'>
                <div v-show='hideAllImage' class='all-images-cards' v-for='allImage in allImages' :key='allImage.id'> <!-- V-for='s3' pour récupérer toutes les images et mettre une barre de défilement à droite-->
                    <div class='show-all-images'>
                        <div>
                            <img :src='allImage.url' class='lsh_allImageCards'>
                        </div>
                        <div>
                            <div>
                                <h5>Nom :<br>{{ allImage.imageName }}</h5>
                            </div>
                            <div>
                                <p>Url : <br>{{ allImage.url }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='menu-actual-website-images' v-show='hideWebsiteImages'>

                <div class='menu-actual-website-images-position'>
                    <button v-show='!hideHomeImages' @click='ddlHomeImages();hideWorkplaceImages=false;hideSkillsImages=false'>Accueil</button>
                    <button v-show='hideHomeImages' @click='hideHomeImages=false'>Accueil</button>
                    <button v-show='!hideWorkplaceImages' @click='ddlWorkplaceImages();hideHomeImages=false;hideSkillsImages=false'>Notre Entreprise</button>
                    <button v-show='hideWorkplaceImages' @click='hideWorkplaceImages=false'>Notre Entreprise</button>
                    <button v-show='!hideSkillsImages' @click='ddlSkillsImages();hideHomeImages=false;hideWorkplaceImages=false'>Nos Techniques</button>
                    <button v-show='hideSkillsImages' @click='hideSkillsImages=false'>Nos Techniques</button>
                </div>
                        <!-- Edit Home Website images -->
                <div  class='all-position-images-cards' v-show='hideHomeImages' v-for='homeImage in homeImages' :key='homeImage.id'> <!--v-for pour récupérer les images avec api/img/1-->
                    <div class='show-all-images'>
                        <img :src='homeImage.firstImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ homeImage.firstImage }}</p>
                        <input v-show='showHomeImage1' v-model='editHomeImage1' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showHomeImage1'  @click='showHomeImage1=!showHomeImage1'>Modifier l'URL</button>
                        <button v-show='showHomeImage1' @click='showHomeImage1=!showHomeImage1'>Annuler</button>
                    </div>
                    <div class='show-all-images'>
                        <img :src='homeImage.secondImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ homeImage.secondImage }}</p>
                        <input v-show='showHomeImage2' v-model='editHomeImage2' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showHomeImage2' @click='showHomeImage2=!showHomeImage2'>Modifier l'URL</button>
                        <button v-show='showHomeImage2' @click='showHomeImage2=!showHomeImage2'>Annuler</button>
                    </div>
                    <div class='show-all-images'>
                        <img :src='homeImage.thirdImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ homeImage.thirdImage }}</p>
                        <input v-show='showHomeImage3' v-model='editHomeImage3' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showHomeImage3' @click='showHomeImage3=!showHomeImage3'>Modifier l'URL</button>
                        <button v-show='showHomeImage3' @click='showHomeImage3=!showHomeImage3'>Annuler</button>
                    </div>
                    <!-- <div class='show-all-images'>
                        <img :src='homeImage.fourthImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ homeImage.fourthImage }}</p>
                        <input v-show='showHomeImage4' v-model='editHomeImage4' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showHomeImage4' @click='showHomeImage4=!showHomeImage4'>Modifier l'URL</button>
                        <button v-show='showHomeImage4' @click='showHomeImage4=!showHomeImage4'>Annuler</button>
                    </div> -->
                </div>
                <div class='save-URL-images' v-show='hideHomeImages'>
                    <button @click='editHomeImages'>Enregistrer</button>
                </div>

                    <!-- Edit Workplace Website images -->
                <div class='all-position-images-cards' v-show='hideWorkplaceImages' v-for='workplaceImage in workplaceImages' :key='workplaceImage.id'> <!--v-for pour récupérer les images avec api/img/2-->
                    <div class='show-all-images'>
                        <img :src='workplaceImage.firstImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ workplaceImage.firstImage }}</p>
                        <input v-show='showWorkplaceImage1' v-model='editWorkplaceImage1' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showWorkplaceImage1'  @click='showWorkplaceImage1=!showWorkplaceImage1'>Modifier l'URL</button>
                        <button v-show='showWorkplaceImage1'  @click='showWorkplaceImage1=!showWorkplaceImage1'>Annuler</button>
                    </div>
                    <div class='show-all-images'>
                        <img :src='workplaceImage.secondImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ workplaceImage.secondImage }}</p>
                        <input v-show='showWorkplaceImage2' v-model='editWorkplaceImage2' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showWorkplaceImage2'  @click='showWorkplaceImage2=!showWorkplaceImage2'>Modifier l'URL</button>
                        <button v-show='showWorkplaceImage2'  @click='showWorkplaceImage2=!showWorkplaceImage2'>Annuler</button>
                    </div>
                    <div class='show-all-images'>
                        <img :src='workplaceImage.thirdImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ workplaceImage.thirdImage }}</p>
                        <input v-show='showWorkplaceImage3' v-model='editWorkplaceImage3' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showWorkplaceImage3'  @click='showWorkplaceImage3=!showWorkplaceImage3'>Modifier l'URL</button>
                        <button v-show='showWorkplaceImage3'  @click='showWorkplaceImage3=!showWorkplaceImage3'>Annuler</button>
                    </div>
                    <!-- <div class='show-all-images'>
                        <img :src='workplaceImage.fourthImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ workplaceImage.fourthImage }}</p>
                        <input v-show='showWorkplaceImage4' v-model='editWorkplaceImage4' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showWorkplaceImage4'  @click='showWorkplaceImage4=!showWorkplaceImage4'>Modifier l'URL</button>
                        <button v-show='showWorkplaceImage4'  @click='showWorkplaceImage4=!showWorkplaceImage4'>Annuler</button>
                    </div> -->

                </div>
                <div class='save-URL-images' v-show='hideWorkplaceImages'>
                    <button @click='editWorkplaceImages'>Enregistrer</button>
                </div>

                    <!-- Edit Skills website images -->
                <div class='all-position-images-cards' v-show='hideSkillsImages' v-for='skillsImage in skillsImages' :key='skillsImage.id'> <!--v-for pour récupérer les images avec api/img/3-->

                    <div class='show-all-images'>
                        <img :src='skillsImage.firstImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ skillsImage.firstImage }}</p>
                        <input v-show='showSkillsImage1' v-model='editSkillsImage1' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showSkillsImage1'  @click='showSkillsImage1=!showSkillsImage1'>Modifier l'URL</button>
                        <button v-show='showSkillsImage1'  @click='showSkillsImage1=!showSkillsImage1'>Annuler</button>
                    </div>
                    <div>
                        <img :src='skillsImage.secondImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ skillsImage.secondImage }}</p>
                        <input v-show='showSkillsImage2' v-model='editSkillsImage2' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showSkillsImage2'  @click='showSkillsImage2=!showSkillsImage2'>Modifier l'URL</button>
                        <button v-show='showSkillsImage2'  @click='showSkillsImage2=!showSkillsImage2'>Annuler</button>
                    </div>
                    <div class='show-all-images'>
                        <img :src='skillsImage.thirdImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ skillsImage.thirdImage }}</p>
                        <input v-show='showSkillsImage3' v-model='editSkillsImage3' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showSkillsImage3'  @click='showSkillsImage3=!showSkillsImage3'>Modifier l'URL</button>
                        <button v-show='showSkillsImage3'  @click='showSkillsImage3=!showSkillsImage3'>Annuler</button>
                    </div>
                    <!-- <div class='show-all-images'>
                        <img :src='skillsImage.fourthImage' class='lsh_allImageCards'>
                        <p>Url : <br> {{ skillsImage.fourthImage }}</p>
                        <input v-show='showSkillsImage4' v-model='editSkillsImage4' type='text' placeholder="Nouvelle URL pour l'image">
                        <button v-show='!showSkillsImage4'  @click='showSkillsImage4=!showSkillsImage4'>Modifier l'URL</button>
                        <button v-show='showSkillsImage4'  @click='showSkillsImage4=!showSkillsImage4'>Annuler</button>
                    </div> -->

                </div>
                <div class='save-URL-images' v-show='hideSkillsImages'>
                    <button @click='editSkillsImages'>Enregistrer</button>
                </div>
            </div>

        </div>
        <Modal v-show="isModalNewImageVisble" @close="closeModal">
            <!-- Show DB named estimates -->
            <template v-slot:header>
                <h3>Enregistrer une nouvelle image</h3>
            </template>
            <template v-slot:body>
                <div class='admin-success-upload-new-image'>
                    <p v-show='successNewImage'>Félicitation, vous avez bien enregistré votre image</p>
                </div>
                <form @submit.prevent enctype="multipart/form-data" v-show='!successNewImage'>
                    <div class='admin-postion-new-image'>
                        <div class='admin-upload-new-image'>
                            <label for='inputName'>Nom de l'image</label>
                            <input type='text' name='inputName' placeHolder='Entrez un nom' v-model='newImageName'>
                            <p v-show='failUploadImageName'>Vous devez entrer un nom pour l'image</p>
                        </div>
                        <div class='admin-upload-new-image'>
                            <label for='inputNewImageFile'>Choisissez un fichier</label>
                            <input type='file' name='inputNewImageFile' @change="storeNewImageChange">
                            <p v-show='failUploadImageFile'>Vous devez choisir une image aux formats .jpg, .jpeg, .svg ou .png et faisant moins de 4Mo</p>
                        </div>
                    </div>
                    <div class='save-new-image'>
                        <button type='submit' @click='storeNewImage'>Enregistrer</button>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                Enregistrement d'une nouvelle image
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
    name: 'EditImagesWebSite',
    // props:{
    //     'listEditWebSite':Array,
    // },
    data(){
    return{
        token:localStorage.getItem('token'),
        // Hide Edite Url input
            showHomeImage1:false,
            showHomeImage2:false,
            showHomeImage3:false,
            showHomeImage4:false,

            showWorkplaceImage1:false,
            showWorkplaceImage2:false,
            showWorkplaceImage3:false,
            showWorkplaceImage4:false,

            showSkillsImage1:false,
            showSkillsImage2:false,
            showSkillsImage3:false,
            showSkillsImage4:false,

        // edit posts v-models
            editHomeImage1:'',
            editHomeImage2:'',
            editHomeImage3:'',
            editHomeImage4:'',

            editWorkplaceImage1:'',
            editWorkplaceImage2:'',
            editWorkplaceImage3:'',
            editWorkplaceImage4:'',

            editSkillsImage1:'',
            editSkillsImage2:'',
            editSkillsImage3:'',
            editSkillsImage4:'',

        // edit Static website
            editStaticWebsite:false,

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
    }
    },

    methods: {
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
        editHomeImages(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/imagesWebsites/1', {
                    firstImage : this.editHomeImage1,
                    secondImage: this.editHomeImage2,
                    thirdImage : this.editHomeImage3,
                    fourthImage: this.editHomeImage4,
                }).then ((response) =>{
                    this.emptyEditInputs()
                    this.closeEditInputs()
                    this.hideHomeImages=false
                    this.editPostsCompleted=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        editWorkplaceImages(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/imagesWebsites/2', {
                    firstImage : this.editWorkplaceImage1,
                    secondImage: this.editWorkplaceImage2,
                    thirdImage : this.editWorkplaceImage3,
                    fourthImage: this.editWorkplaceImage4,
                }).then ((response) =>{
                    this.emptyEditInputs()
                    this.closeEditInputs()
                    this.hideWorkplaceImages=false
                    this.editPostsCompleted=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        editSkillsImages(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/imagesWebsites/3', {
                    firstImage : this.editSkillsImage1,
                    secondImage: this.editSkillsImage2,
                    thirdImage : this.editSkillsImage3,
                    fourthImage: this.editSkillsImage4,
                }).then ((response) =>{
                    this.emptyEditInputs()
                    this.closeEditInputs()
                    this.hideSkillsImages=false
                    this.editPostsCompleted=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        closeEditInputs(){
            this.showHomeImage1=false
            this.showHomeImage2=false
            this.showHomeImage3=false
            this.showHomeImage4=false

            this.showWorkplaceImage1=false
            this.showWorkplaceImage2=false
            this.showWorkplaceImage3=false
            this.showWorkplaceImage4=false

            this.showSkillsImage1=false
            this.showSkillsImage2=false
            this.showSkillsImage3=false
            this.showSkillsImage4=false
        },
        emptyEditInputs(){
            this.editHomeImage1=''
            this.editHomeImage2=''
            this.editHomeImage3=''
            this.editHomeImage4=''

            this.editWorkplaceI=''
            this.editWorkplaceI=''
            this.editWorkplaceI=''
            this.editWorkplaceI=''

            this.editSkillsImag=''
            this.editSkillsImag=''
            this.editSkillsImag=''
            this.editSkillsImag=''
        },
        closeModal() {
            this.hideEditOrder=false;
            this.isModalNewImageVisble=false;
        },
    },
    computed: {

    },
    mounted(){

        console.log('Orders Mounted')
    }
 }

</script>
