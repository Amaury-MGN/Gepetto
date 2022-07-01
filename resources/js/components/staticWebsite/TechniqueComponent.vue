<template>
    <div>
        <div class='nav-false-background'></div>
        <div>
            <h1 class='title-static'>Notre Savoir-Faire</h1>
        </div>
        <!-- <button @click='workplaceImgs'>Test</button> -->
        <div v-for='post in posts' :key='post.id'>
            <div v-for='img in imgs' :key='img.id'>
                    <div class='container-static posts-images-static'>
                        <div class='home-imgStatic1'>
                            <img :src='img.firstImage' class='home-imgStatic1'>
                        </div>
                        <div class='home-posts1'>{{ post.firstPost }}</div>
                    </div>

                    <div class='container-static posts-images-static2'>
                        <div class='home-imgStatic2'>
                            <img :src='img.secondImage' class='home-imgStatic1'>
                        </div>
                    <div class='home-posts2'>
                        {{ post.secondPost }}
                        </div>
                    </div>
                    <div class='container-static posts-images-static'>
                        <div class='home-imgStatic1'>
                            <img :src='img.thirdImage' class='home-imgStatic1'>
                        </div>
                    <div class='home-posts1'>
                        {{ post.thirdPost }}</div>
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
            skillsPosts(){
                axios.get('api/post/3').then((response) => {
                    this.posts=response.data
                    console.log(this.posts)

                }).catch((errors) => {
                    console.log(errors)
                })
            },
            skillsImgs(){
                 axios.get('api/imagesWebsite/3').then((response) => {
                    this.imgs=response.data
                    console.log(this.posts)

                }).catch((errors) => {
                    console.log(errors)
                })
            }
        },

        mounted() {
            this.skillsPosts()
            this.skillsImgs()
            console.log('Component mounted.')
        },

    }
</script>
