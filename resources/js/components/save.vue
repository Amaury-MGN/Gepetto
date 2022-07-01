<template>
    <div>
        <form id="payment-form" v-on:submit.prevent="submitPaymentMethod()">
            <input id="card-holder-name" type="text">
            <div id="card-element"><!--Stripe.js injects the Card Element--></div>
            <button id="submit">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Pay now</span>
            </button>
            <p id="card-error" role="alert"></p>
            <p class="result-message hidden">
                Payment succeeded, see the result in your
                <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
            </p>
        </form>
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
            addPaymentStatusError: ''
        }
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
            const estimateId = this.id;
            const cardHolderName = document.getElementById('card-holder-name');
            var cardError = document.getElementById('card-error');
            var nameError = document.getElementById('card-error');

            this.stripe.createPaymentMethod({
                type: 'card',
                card: this.card,
                billing_details: { name: cardHolderName.value,
                }
            })
            .then(function(result) {
                if (result.error) {
                    cardError.textContent=result.error.message;
                    console.log(cardError)
                } else {
                    console.log(estimateId,'The card has been verified successfully')
                    let paymentMethods=result.paymentMethod
                    let paymentId=result.paymentMethod.id
                    axios.get('/sanctum/csrf-cookie').then(response => {
                        axios.post('api/stripe', {
                            paymentMethods,
                            paymentId,
                            estimateId,
                        }).then ((response) => {
                            console.log(response)
                        }).catch ((errors) => {
                            console.log(errors.response);
                        })
                    })
                }
            });
        },
    },
    mounted() {
        this.includeStripe('js.stripe.com/v3/', function(){
            this.configureStripe();
        }.bind(this) );
        console.log('Component mounted.')
    }

}
</script>
