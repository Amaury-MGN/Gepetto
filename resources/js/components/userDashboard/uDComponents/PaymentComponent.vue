  <template>
   <div>
        <div class='nav-false-background'></div>
        <div class='background-auth'>
            <div class='main-title-auth'>
                <h1>GEPETTO</h1>
            </div>
            <div class='title-auth'>
                <h2>Paiement</h2>
            </div>
            <div class='table-display-user validate-informations-user' v-show='successPayment'>
                <h5> Paiement réalisé avec succès.</h5>
            </div>
            <div class='table-display-user validate-informations-user' v-show='successPayment'>
                <h5>Veuillez cliquer sur <router-link to='/'>le lien</router-link> pour retourner vers l'Accueil</h5>
            </div>
            <div class='infos-users-flex-container' v-show='informationsAreVisible'>
                <div class='table-display-user'>
                    <div class='infos-users-categories-user'><h5>Numéro du Devis :</h5></div>
                    <div class='infos-users-data-user'><h5>{{ estimate.estimateNumber }}</h5></div>
                </div>
                <div class='table-display-user'>
                    <div class='infos-users-categories-user'><h5>Nombre souhaité :</h5></div>
                    <div class='infos-users-data-user'><h5>{{ estimate.estimateItemNumber }}</h5></div>
                </div>
                <div class='table-display-user'>
                    <div class='infos-users-categories-user'><h5>Prix T.T.C. :</h5></div>
                    <div class='infos-users-data-user'><h5>{{ estimatePrice.estimateAdminPrice }} €</h5></div>
                </div>
                <div class="loader" v-if="loading">
                    <span class="helper"></span>
                    <i class="loaderImg fa fa-circle-o-notch fa-spin" style="font-size:48px"></i>
                </div>
                <div class='form-confirmation-user-data' v-show='!loadingIsVisible'>
                    <a @click='hidePayment=!hidePayment'><h5 class='validate-informations-user'>Payer par CB</h5></a>
                </div>
            </div>
            <div class='payment-stripe infos-users-flex-container' v-show='hidePayment&&!loadingIsVisible'>
                <form id="payment-form" v-on:submit.prevent="submitPaymentMethod()">
                    <fieldset :disabled="loading">
                        <input id="card-holder-name" type="text" placeholder='Entrez vos noms et prénom'>
                        <div id="card-element"><!--Stripe.js injects the Card Element--></div>
                        <button id="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Payer Maintenant</span>
                        </button>
                        <p id="card-error" role="alert"></p>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
        name:'dashboard',

        data() {
        return {
            id: this.$route.params.id,
            stripeAPIToken:'pk_test_51Ji2hqDPUhX8Apb5L5tiu8SdMy1DcilER6eV78sao5WXVDUfMqqWw4C3rz97QxTpKO8trX86nM4QyNmE3Na0e8Y100P8ej5olk',
            stripe: '',
            elements: '',
            card: '',
            name:'',
            addPaymentStatusError: '',
            hidePayment:false,
            estimate:{},
            estimatePrice:{},
            user:{},
            // loading
            success: false,
            error: false,
            loading: false,
            loadingIsVisible:false,
            successPayment:false,
            informationsAreVisible:true
        }
    },
    created(){
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get(`api/estimates/${this.id}`
            ).then ((response) =>{
                this.estimate = response.data.data
                console.log(this.estimate)

                axios.get(`api/user/${this.estimate.user_id}`
                ).then ((response) =>{
                    this.user = response.data.user
                    // console.log(this.user, 'test')
                }).catch ((errors) => {
                    console.log(errors);
                })

            }).catch ((errors) => {
                console.log(errors);

            })
        }),
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get(`api/estimateAdminFile/${this.id}`
            ).then ((response) =>{
                this.estimatePrice = response.data.data
                // console.log(this.estimatePrice)
            }).catch ((errors) => {
                console.log(errors);

            })
        })
    },
    methods: {
        includeStripe( URL, callback ){
            let documentTag = document, tag = 'script',
            object = documentTag.createElement(tag),
            scriptTag = documentTag.getElementsByTagName(tag)[0];
            object.src = '//' + URL;
            if (callback) { object.addEventListener('load', function (e) { callback(null, e); }, false); }
            scriptTag.parentNode.insertBefore(object, scriptTag);
        },
        configureStripe(){
            this.stripe = Stripe( this.stripeAPIToken );

            this.elements = this.stripe.elements();
            this.card = this.elements.create('card');
            this.card.mount('#card-element');
        },
        submitPaymentMethod(){
            const cardHolderName = document.getElementById('card-holder-name');
            let cardError = document.getElementById('card-error');
            const estimateId = this.id;
            // this.loading = true;

           this.stripe.createPaymentMethod({
                type: 'card',
                card: this.card,
                billing_details: { name: cardHolderName.value,
                }
            }).then(function(result) {
                if (result.error) {
                    cardError.textContent=result.error.message;
                    this.loading = false;
                    console.log(this.loading);
                } else {
                    console.log(result.data,'The card has been verified successfully')
                    this.loading=true;
                    this.loadingIsVisible=true;
                    let paymentMethods=result.paymentMethod
                    let paymentId=result.paymentMethod.id
                    axios.get('/sanctum/csrf-cookie').then(response => {
                        axios.post('api/stripe', {
                            paymentMethods,
                            paymentId,
                            estimateId,
                        }).then ((response) => {
                            console.log(response, this.loading)
                            let paymentValidation='Oui'

                            axios.patch(`api/estimates/${estimateId}`, {
                                paymentValidation,
                            }).then ((response) => {
                                console.log(response, this.loading)

                                axios.post(`api/orders`, {
                                estimateId,
                                }).then ((response) => {
                                    console.log(response,'Votre commande a bien été enregistrée', this.loading)
                                    // this.success = true;
                                    this.loading = false;
                                    this.successPayment=true;
                                    this.informationsAreVisible=false;
                                    // this.$router.push('/')
                                }).catch ((errors) => {
                                    console.log(errors.response);
                                    this.loading = false;

                                })

                            }).catch ((errors) => {
                                console.log(errors.response);
                                this.loading = false;
                            })

                        }).catch ((errors) => {
                            console.log(errors.response);
                            this.loading = false;
                        })
                    })
                }
            }.bind(this));
        },
        // submitPaymentMethod(){
        //     const estimateId = this.id;
        //     const cardHolderName = document.getElementById('card-holder-name');
        //     let cardError = document.getElementById('card-error');
        //     let nameError = document.getElementById('card-error');
        //     // this.loading = true;
        //     this.stripe.createPaymentMethod({
        //         type: 'card',
        //         card: this.card,
        //         billing_details: { name: cardHolderName.value,
        //         }
        //     })
        //     .then(function(result) {
        //         if (result.error) {
        //             cardError.textContent=result.error.message;
        //             console.log(this.loading)
        //         } else {
        //             console.log(result.data,'The card has been verified successfully')
        //             let paymentMethods=result.paymentMethod
        //             let paymentId=result.paymentMethod.id
        //             axios.get('/sanctum/csrf-cookie').then(response => {
        //                 axios.post('api/stripe', {
        //                     paymentMethods,
        //                     paymentId,
        //                     estimateId,
        //                 }).then ((response) => {
        //                     console.log(response)
        //                     let paymentValidation='Oui'

        //                     axios.patch(`api/estimates/${estimateId}`, {
        //                         paymentValidation,
        //                     }).then ((response) => {
        //                         console.log(response)

        //                         axios.post(`api/orders`, {
        //                         estimateId,
        //                         }).then ((response) => {
        //                             console.log(response,'Votre commande a bien été enregistrée')
        //                             // this.success = true;
        //                             // this.loading = false;
        //                             // this.$router.push('/')
        //                         }).catch ((errors) => {
        //                             console.log(errors.response);
        //                             // this.error = true;
        //                             // this.loading = false;
        //                         })

        //                     }).catch ((errors) => {
        //                         console.log(errors.response);
        //                     })

        //                 }).catch ((errors) => {
        //                     // console.log(errors.response);
        //                 })
        //             })
        //         }
        //     });
        // },
        reset() {
            this.success = false;
            this.error = false;
            for (let field in this.formData) {
                this.formData[field] = null;
        }
        }
    },
    mounted() {
        this.includeStripe('js.stripe.com/v3/', function(){
            this.configureStripe();
        }.bind(this) );
        console.log('Component mounted.')
    }

}
</script>
