<template>
    <div>
        <div class='menu-actual-website-images'>
            <div class='menu-actual-website-images-position'>
                <button v-show='!hideHomePosts' @click='homePosts();hideWorkplacePosts=false;hideSkillsPosts=false'>
                    <h5>Accueil</h5>
                </button>
                <button v-show='hideHomePosts' @click='hideHomePosts=!hideHomePosts'>
                    <h5>Accueil</h5>
                </button>
                <button v-show='!hideWorkplacePosts' @click='workplacePosts();hideHomePosts=false;hideSkillsPosts=false'>
                    <h5>Notre Entreprise</h5>
                </button>
                <button v-show='hideWorkplacePosts' @click='hideWorkplacePosts=!hideWorkplacePosts'>
                    <h5>Notre Entreprise</h5>
                </button>
                <button v-show='!hideSkillsPosts' @click='skillsPosts();hideHomePosts=false;hideWorkplacePosts=false'>
                    <h5>Nos Techniques</h5>
                </button>
                <button v-show='hideSkillsPosts' @click='hideSkillsPosts=!hideSkillsPosts'>
                    <h5>Nos Techniques</h5>
                </button>
            </div>
        </div>
        <div  class='lsh_flex-information' v-show='hideHomePosts' v-for='allHomePost in allHomePosts' :key='allHomePost.id'>
            <div><h4 class='posts-subtitle'>Accueil</h4></div>
            <div class='save-new-posts'>
                <button @click='editHomePosts()'>Enregistrer les Modifications</button>
            </div>
            <div class='edit-post-container'>
                <div class='edit-post-position'>
                    <h5>Premier Post</h5>
                    <p>{{ allHomePost.firstPost }}</p>
                    <textarea v-show='showHomePost1' v-model='editHomePost1' type='textarea' aria-describedby="firstPostHelp" name='firstPost' placeholder='Modifier le premier post'></textarea>
                    <button v-show='!showHomePost1' @click='showHomePost1=!showHomePost1'>Modifier</button>
                    <button v-show='showHomePost1' @click='showHomePost1=!showHomePost1'>Annuler</button>
                </div>
                <div  class='edit-post-position'>
                    <h5>Deuxième Post</h5>
                    <p>{{ allHomePost.secondPost }}</p>
                    <textarea v-show='showHomePost2' v-model='editHomePost2' type='textarea' aria-describedby="secondPostHelp" name='secondPost' placeholder='Modifier le second post'></textarea>
                    <button v-show='!showHomePost2' @click='showHomePost2=!showHomePost2'>Modifier</button>
                    <button v-show='showHomePost2' @click='showHomePost2=!showHomePost2'>Annuler</button>
                </div>
                <div  class='edit-post-position'>
                    <h5>Troisième Post</h5>
                    <p>{{ allHomePost.thirdPost }}</p>
                    <textarea v-show='showHomePost3' v-model='editHomePost3' type='textarea' aria-describedby="thirdPostHelp" name='thirdPost' placeholder='Modifier le troisième post'></textarea>
                    <button v-show='!showHomePost3' @click='showHomePost3=!showHomePost3'>Modifier</button>
                    <button v-show='showHomePost3'  @click='showHomePost3=!showHomePost3'>Annuler</button>
                </div>
                <div  class='edit-post-position'>
                    <h5>Quatrième Post</h5>
                    <p>{{ allHomePost.fourthPost }}</p>
                    <textarea v-show='showHomePost4' v-model='editHomePost4' type='textarea' aria-describedby="fourthPostHelp" name='fourthPost' placeholder='Modifier le quatrième post'></textarea>
                    <button v-show='!showHomePost4' @click='showHomePost4=!showHomePost4'>Modifier</button>
                    <button v-show='showHomePost4' @click='showHomePost4=!showHomePost4'>Annuler</button>
                </div>
            </div>
        </div>
        <div>
            <div  class='lsh_flex-information' v-show='hideWorkplacePosts' v-for='allWorkplacePost in allWorkplacePosts' :key='allWorkplacePost.id'>
                <div><h4 class='posts-subtitle'>Notre Entreprise</h4></div>
                <div class='save-new-posts'>
                    <button @click='editWorkplacePosts()'>Enregistrer les Modifications</button>
                </div>
                <div class='edit-post-container'>
                    <div class='edit-post-position'>
                        <h5>Premier Post</h5>
                        <p>{{ allWorkplacePost.firstPost }}</p>
                        <textarea v-show='showWorkplacePost1' v-model='editWorkplacePost1' type='textarea' aria-describedby="firstPostHelp" name='firstPost' placeholder='Modifier le premier post'></textarea>
                        <button v-show='!showWorkplacePost1' @click='showWorkplacePost1=!showWorkplacePost1'>Modifier</button>
                        <button v-show='showWorkplacePost1' @click='showWorkplacePost1=!showWorkplacePost1'>Annuler</button>

                    </div>
                    <div class='edit-post-position'>
                        <h5>Deuxième Post</h5>
                        <p>{{ allWorkplacePost.secondPost }}</p>
                        <textarea v-show='showWorkplacePost2' v-model='editWorkplacePost2' type='textarea' aria-describedby="secondPostHelp" name='secondPost' placeholder='Modifier le second post'></textarea>
                        <button v-show='!showWorkplacePost2' @click='showWorkplacePost2=!showWorkplacePost2'>Modifier</button>
                        <button v-show='showWorkplacePost2' @click='showWorkplacePost2=!showWorkplacePost2'>Annuler</button>

                    </div>
                    <div class='edit-post-position'>
                        <h5>Troisième Post</h5>
                        <p>{{ allWorkplacePost.thirdPost }}</p>
                        <textarea v-show='showWorkplacePost3' v-model='editWorkplacePost3' type='textarea' aria-describedby="thirdPostHelp" name='thirdPost' placeholder='Modifier le troisième post'></textarea>
                        <button v-show='!showWorkplacePost3' @click='showWorkplacePost3=!showWorkplacePost3'>Modifier</button>
                        <button v-show='showWorkplacePost3' @click='showWorkplacePost3=!showWorkplacePost3'>Annuler</button>

                    </div>
                    <div class='edit-post-position'>
                        <h5>Quatrième Post</h5>
                        <p>{{ allWorkplacePost.fourthPost }}</p>
                        <textarea v-show='showWorkplacePost4' v-model='editWorkplacePost4' type='textarea' aria-describedby="fourthPostHelp" name='fourthPost' placeholder='Modifier le quatrième post'></textarea>
                        <button v-show='!showWorkplacePost4' @click='showWorkplacePost4=!showWorkplacePost4'>Modifier</button>
                        <button v-show='showWorkplacePost4' @click='showWorkplacePost4=!showWorkplacePost4'>Annuler</button>

                    </div>

                </div>
            </div>
        </div>
        <div>
            <div  class='lsh_flex-information' v-show='hideSkillsPosts' v-for='allSkillsPost in allSkillsPosts' :key='allSkillsPost.id'>
                <div><h4 class='posts-subtitle'>Notre savoir-faire</h4></div>
                <div class='save-new-posts'>
                    <button @click='editSkillsPosts()'>Enregistrer les Modifications</button>
                </div>
                <div class='edit-post-container'>
                    <div class='edit-post-position'>
                        <h5>Premier Post</h5>
                        <p>{{ allSkillsPost.firstPost }}</p>
                        <textarea v-show='showSkillsPost1' v-model='editSkillsPost1'  type='textarea' aria-describedby="firstPostHelp" name='firstPost' placeholder='Modifier le premier post'></textarea>
                        <button v-show='!showSkillsPost1' @click='showSkillsPost1=!showSkillsPost1'>Modifier</button>
                        <button v-show='showSkillsPost1' @click='showSkillsPost1=!showSkillsPost1'>Annuler</button>

                    </div>
                    <div class='edit-post-position'>
                        <h5>Deuxième Post</h5>
                        <p>{{ allSkillsPost.secondPost }}</p>
                        <textarea v-show='showSkillsPost2' v-model='editSkillsPost2' type='textarea' aria-describedby="secondPostHelp" name='secondPost' placeholder='Modifier le second post'></textarea>
                        <button v-show='!showSkillsPost2' @click='showSkillsPost2=!showSkillsPost2'>Modifier</button>
                        <button v-show='showSkillsPost2' @click='showSkillsPost2=!showSkillsPost2'>Annuler</button>

                    </div>
                    <div class='edit-post-position'>
                        <h5>Troisième Post</h5>
                        <p>{{ allSkillsPost.thirdPost }}</p>
                        <textarea v-show='showSkillsPost3' v-model='editSkillsPost3' type='textarea' aria-describedby="thirdPostHelp" name='thirdPost' placeholder='Modifier le troisième post'></textarea>
                        <button v-show='!showSkillsPost3' @click='showSkillsPost3=!showSkillsPost3'>Modifier</button>
                        <button v-show='showSkillsPost3' @click='showSkillsPost3=!showSkillsPost3'>Annuler</button>

                    </div>
                    <div class='edit-post-position'>
                        <h5>Quatrième Post</h5>
                        <p>{{ allSkillsPost.fourthPost }}</p>
                        <textarea v-show='showSkillsPost4' v-model='editSkillsPost4' type='textarea' aria-describedby="fourthPostHelp" name='fourthPost' placeholder='Modifier le quatrième post'></textarea>
                        <button v-show='!showSkillsPost4' @click='showSkillsPost4=!showSkillsPost4'>Modifier</button>
                        <button v-show='showSkillsPost4' @click='showSkillsPost4=!showSkillsPost4'>Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-show='editPostsCompleted'>
            <h4 class='success-posts'>Vos modifications ont bien été prises en compte.</h4>
        </div>
    </div>
</template>

<script>

 export default {
    name: 'EditPostsWebSite',
    // props:{
    //     'listEditWebSite':Array,
    // },
    data(){
    return{
        token:localStorage.getItem('token'),
        // show Static website
            allHomePosts:{},
            allWorkplacePosts:{},
            allSkillsPosts:{},

            hideHomePosts:false,
            hideWorkplacePosts:false,
            hideSkillsPosts:false,
        // Hide and Show Placeholder Edit Posts
            editPostsCompleted:false,

            showHomePost1:false,
            showHomePost2:false,
            showHomePost3:false,
            showHomePost4:false,

            showWorkplacePost1:false,
            showWorkplacePost2:false,
            showWorkplacePost3:false,
            showWorkplacePost4:false,

            showSkillsPost1:false,
            showSkillsPost2:false,
            showSkillsPost3:false,
            showSkillsPost4:false,
        // edit posts v-models
            editHomePost1:'',
            editHomePost2:'',
            editHomePost3:'',
            editHomePost4:'',

            editWorkplacePost1:'',
            editWorkplacePost2:'',
            editWorkplacePost3:'',
            editWorkplacePost4:'',

            editSkillsPost1:'',
            editSkillsPost2:'',
            editSkillsPost3:'',
            editSkillsPost4:'',
            // showStaticWebsite:false,

            // allPosts:{},
            // hideAllImage:false,

            // homePosts:{},
            // workplacePosts:{},
            // skillsPosts:{},
            // showPosts:false,
        // image Modal
            isModalEditPostVisble:false,

    }
    },

    methods: {
        homePosts(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/post/1').then ((response) =>{
                    this.allHomePosts=response.data
                    console.log(this.allHomePosts)
                    this.hideHomePosts=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        workplacePosts(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/post/2').then ((response) =>{
                    this.allWorkplacePosts=response.data
                    console.log(this.allWorkplacePosts)
                    this.hideWorkplacePosts=true

                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        skillsPosts(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get('api/post/3').then ((response) =>{
                    this.allSkillsPosts=response.data
                    console.log(this.allSkillsPosts)
                    this.hideSkillsPosts=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        editHomePosts(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/post/1', {
                    firstPost : this.editHomePost1,
                    secondPost: this.editHomePost2,
                    thirdPost : this.editHomePost3,
                    fourthPost: this.editHomePost4
                }).then ((response) =>{
                    this.emptyEditInputs()
                    this.closeEditInputs()
                    this.hideHomePosts=false
                    this.editPostsCompleted=true
                    console.log(closEditInput())


                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        editWorkplacePosts(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/post/2', {
                    firstPost : this.editWorkplacePost1,
                    secondPost: this.editWorkplacePost2,
                    thirdPost : this.editWorkplacePost3,
                    fourthPost: this.editWorkplacePost4
                }).then ((response) =>{
                    this.emptyEditInputs()
                    this.closeEditInputs()
                    this.hideWorkplacePosts=false
                    this.editPostsCompleted=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
         editSkillsPosts(){
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/post/3', {
                    firstPost : this.editSkillsPost1,
                    secondPost: this.editSkillsPost2,
                    thirdPost : this.editSkillsPost3,
                    fourthPost: this.editSkillsPost4
                }).then ((response) =>{
                    this.emptyEditInputs()
                    this.closeEditInputs()
                    this.hideSkillsPosts=false
                    this.editPostsCompleted=true
                }).catch ((errors) => {
                    console.log(errors);
                })
            })
        },
        closeEditInputs(){
            this.showHomePost1=false
            this.showHomePost2=false
            this.showHomePost3=false
            this.showHomePost4=false

            this.showWorkplacePost1=false
            this.showWorkplacePost2=false
            this.showWorkplacePost3=false
            this.showWorkplacePost4=false

            this.showSkillsPost1=false
            this.showSkillsPost2=false
            this.showSkillsPost3=false
            this.showSkillsPost4=false
        },
        emptyEditInputs(){
            this.editHomePost1=''
            this.editHomePost2=''
            this.editHomePost3=''
            this.editHomePost4=''

            this.editWorkplacePost1=''
            this.editWorkplacePost2=''
            this.editWorkplacePost3=''
            this.editWorkplacePost4=''

            this.editSkillsPost1=''
            this.editSkillsPost2=''
            this.editSkillsPost3=''
            this.editSkillsPost4=''
        },
        closeModal() {
            this.isModalEditPostVisble=false;
        },
    },
    computed: {

    },
    mounted(){

        console.log('Orders Mounted')
    }
 }

</script>
