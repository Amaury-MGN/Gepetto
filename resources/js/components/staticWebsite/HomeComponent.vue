<template>
    <div>
        <div v-for='post in posts' :key='post.id'>
            <div v-for='img in imgs' :key='img.id'>
                <div class='home-background-image'>
                    <!-- <div class='nav-false-background'></div> -->
                    <div class='title-font'>
                        <h1 class='title'>Gepetto</h1>
                        <h3 class='subtitle'>{{ post.firstPost }}</h3>
                    </div>
                </div>
                <div class='home-posts-img-flex'>
                    <div class='home-contents-display1'>
                        <div >
                            <img :src='img.firstImage' class='home-imgStatic1'>
                        </div>
                        <div class='home-posts1'>
                            <p>{{ post.secondPost }}</p>
                        </div>
                    </div>
                </div>
                <div class='home-posts-img-flex'>
                    <div class='home-contents-display2'>
                        <div class='home-posts2'>
                            <p>{{ post.thirdPost }}</p>
                        </div>
                        <div>
                            <img :src='img.secondImage' class='home-imgStatic2'>
                        </div>
                    </div>
                </div>
                <div class='home-posts-img-flex'>
                    <div class='home-contents-display1'>
                        <div>
                            <img :src='img.thirdImage' class='home-imgStatic1'>
                        </div>
                        <div class='home-posts1'>
                            <p>{{ post.fourthPost }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return{
                posts:{},
                imgs:{},
            }
        },
        methods: {
            homePosts(){
                axios.get('api/post/1').then((response) => {
                    this.posts=response.data
                    console.log(this.posts)

                }).catch((errors) => {
                    console.log(errors)
                })
            },
            homeImgs(){
                 axios.get('api/imagesWebsite/1').then((response) => {
                    this.imgs=response.data
                    console.log(this.posts)

                }).catch((errors) => {
                    console.log(errors)
                })
            }
        },

        mounted() {
            this.homePosts()
            this.homeImgs()
            console.log('Component mounted.')
        },
    }

</script>


