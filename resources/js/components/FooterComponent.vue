<template>
<div class='footer-background' id='footer'>
    <div class='footer-container'>
        <div class='footer-flex-first-child'>
            <h1>Gepetto</h1>
            <router-link to='/' class='nav-iconeHover'><img src="storage/images/logo-cerf.png" alt="logo"></router-link>
        </div>
        <div class='footer-flex-second-child'>
            <h3>Liens Rapides</h3>
            <div class='footer-second-child-position'>
                <div class='footer-sub-container'>
                     <li class='no-bullet'><router-link to='/'><h5>Accueil</h5></router-link></li>
                    <li class='no-bullet'><router-link to='/workplace'><h5>Notre Entreprise</h5></router-link></li>
                    <li class='no-bullet'><router-link to='/technique'><h5>Notre Savoir-faire</h5></router-link></li>
                </div>
                <div class='footer-sub-container'>
                    <li class='no-bullet'><router-link to='/mentions-legales'><h5>Mentions Légales</h5></router-link></li>
                    <li class='no-bullet'><router-link to='/politique-de-confidentialite'><h5>Politique de Confidentialité</h5></router-link></li>

                </div>
            </div>
        </div>
        <div class='footer-flex-third-child'>
            <h3>Nous contacter</h3>
            <div class='footer-second-child-position'>
                <div class='footer-sub-container'>
                    <li class='no-bullet'><h5>Téléphone : 06********</h5></li>
                    <li class='no-bullet'><h5>Mail : contact@gepetto.com</h5></li>
                    <li class='no-bullet'><h5>Adresse : Loin de chez vous</h5></li>
                </div>
                <!-- <div class='footer-sub-container'>
                    <li class='no-bullet'><h5></h5></li>
                    <li class='no-bullet'><h5></h5></li> -->

                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
</template>
