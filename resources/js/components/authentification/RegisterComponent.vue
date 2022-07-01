<template>
    <div>
        <div class='nav-false-background'></div>
        <div class='main-title-auth'>
            <h1>GEPETTO</h1>
        </div>
        <div>
            <h2 class='title-auth'>S'enregistrer</h2>
        </div>
        <div class='container-auth'>
            <form class='form-auth'>
                <div>
                    <div>
                        <div><label for="inputFirstname">Prénom</label></div>
                        <div><input type="text" aria-describedby="firstnameHelp" placeholder="Entrez votre prénom" name='inputFirstname' v-model="firstname"></div>
                        <div><p v-text='errors.firstname'></p></div>
                    </div>
                    <div>
                        <div><label for="inputLastname">Nom de Famille</label></div>
                        <div><input type="text" aria-describedby="lastnameHelp" placeholder="Entrez votre nom de famille" name='inputLastname' v-model="lastname"></div>
                        <div><p v-text='errors.lastname'></p></div>
                    </div>
                    <div>
                        <div><label for="inputCompany">Nom de votre entreprise<br>(facultatif)</label></div>
                        <div><input type="text" aria-describedby="companyHelp" placeholder="Entrez le nom de votre entreprise" name='inputCompany' v-model="company"></div>
                        <div><p v-text='errors.company'></p></div>
                    </div>
                    <div>
                        <div><label for="inputPhoneNumber">Numéro de téléphone<br>(facultatif)</label></div>
                        <div><input type="tel" aria-describedby="phoneNumberHelp" placeholder="Entrez votre numéro de Téléphone" name='inputPhoneNumber' v-model="phoneNumber"></div>
                        <div><p v-text='errors.pseudonym'></p></div>
                    </div>
                </div>
                <div>
                    <div>
                        <div><label for="inputPseudonym">Nom d'utilisateur</label></div>
                        <div><input type="text" aria-describedby="pseudonymHelp" placeholder="Entrez votre nom d'utilisateur" name='inputPseudonym' v-model="pseudonym"></div>
                        <div><p v-text='errors.pseudonym'></p></div>
                    </div>
                    <div>
                        <div><label for="inputEmail">Adresse email</label></div>
                        <div><input type="email" aria-describedby="emailHelp" placeholder="Entrez votre adresse mail" name='inputEmail' v-model="email"></div>
                        <div><p v-text='errors.email'></p></div>
                    </div>
                    <div>
                        <div><label for="inputPassword">Password</label></div>
                        <div><input type="password" aria-describedby="passwordHelp" placeholder="Entrez votre mot de passe" name='inputPassword' v-model="password"></div>
                        <div><p v-text='errors.password'></p></div>
                    </div>
                    <div>
                        <div><label for="inputConfirmedPassword">Mot de passe</label></div>
                        <div><input type="password" aria-describedby="confirmedPasswordHelp" placeholder="Confirmez votre mot de passe" name='inputConfirmedPassword' v-model="passwordConfirmation"></div>
                        <div><p v-text='errors.c_password'></p></div>
                    </div>
                    <input type='submit' placeholder='Enregistrer' @click='userRegister' >
                    <div>
                        <router-link to="/login" class='link-auth'>J'ai déjà un compte</router-link>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                firstname:'',
                lastname:'',
                company:'',
                phoneNumber:'',
                pseudonym:'',
                email:'',
                password:'',
                passwordConfirmation:'',
                errors:''
            }
        },
        methods: {

            userRegister(e){
                e.preventDefault();
                axios.post('api/auth/register', {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    company: this.company,
                    phoneNumber: this.phoneNumber,
                    pseudonym: this.pseudonym,
                    email: this.email,
                    password: this.password,
                    passwordConfirmation: this.passwordConfirmation

                }).then((response) => {
                    console.log(response)
                    this.firstname = this.lastname = this.company = this.phoneNumber =this.pseudonym = this.email = this.password = this.passwordConfirmation =''
                    this.errors=''
                    this.$router.push('/login')

                }).catch ((errors) => {
                    this.errors = errors.response.data.errors;
                    console.log(errors);
                });

            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

