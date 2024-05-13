import { createRouter , createWebHistory } from "vue-router";

import HomeCompenent from "C:/laragon/www/gestiondossier/resources/js/compenents/HomeCompenent.vue";
import DossierComponent from "C:/laragon/www/gestiondossier/resources/js/compenents/DossierComponent.vue";
import ClientComponent from "C:/laragon/www/gestiondossier/resources/js/compenents/ClientComponent.vue";
import TypeDossierComponent from "C:/laragon/www/gestiondossier/resources/js/compenents/TypeDossierComponent.vue";
import TypeFichierComponent from "C:/laragon/www/gestiondossier/resources/js/compenents/TypeFichierComponent.vue";
import AjouterDossierComponent from "C:/laragon/www/gestiondossier/resources/js/compenents/template/AjouterDossierComponent.vue";
import ModifierDossierComponent from "C:/laragon/www/gestiondossier/resources/js/compenents/ModifierDossierComponent.vue";

const routes = [
    {
        path:'/',
        component : HomeCompenent,
        name : 'home.index'
    },
    {
        path:'/dossier',
        component : DossierComponent,
        name : 'dossier.index'
    },
    {
        path:'/AjouterDossier',
        component : AjouterDossierComponent,
        name : 'AjouterDossier.index'
    },
    {
        path:'/client',
        component : ClientComponent,
        name : 'client.index'
    },
    {
        path:'/typedossier',
        component : TypeDossierComponent,
        name : 'typedossier.index'
    },
    {
        path:'/typefichier',
        component : TypeFichierComponent,
        name : 'typefichier.index'
    },
    {
        path:'/ModifierDossier/:id',
        component :ModifierDossierComponent ,
        name : 'modifierdossier.index',
        props: true
    }
];
 export default createRouter ({
    history : createWebHistory(),
    routes
 })