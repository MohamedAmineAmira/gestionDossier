<template>
   <div>
         <div class="row">
            <div class="col-md-12">
                  <!-- DATA TABLE -->

                  <div class="table-data__tool">
                     <div class="table-data__tool-left">
                         <div class="overview-wrap">
                           <h2 class="title-1">Tableau des Dossiers</h2>
                         </div> 
                     </div>
                     <div class="table-data__tool-right">
                        <router-link :to="{ name: 'AjouterDossier.index' }">
                           <button class="au-btn au-btn-icon au-btn--blue">
                              <i class="zmdi zmdi-plus"></i>Ajouter Dossier
                           </button>
                        </router-link>
                     </div>
                  </div>
                  <div class="main">
                     <div class="form-group has-search">
                      <span class="fa fa-search form-control-feedback"></span>
                     <input type="text" class="form-control" placeholder="Search" v-model="search"  >
                  </div>
                  </div>
                  <div  class="table-responsive table--no-card m-b-30">
                     <table  class="table table-borderless table-striped table-earning">
                           <thead>
                              <tr>
                                 <th>Réf</th>
                                 <th>Email-Client</th>
                                 <th>statue</th>
                                 <th>date_dépôt_p</th>
                                 <th>options</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr v-for="dossier in filteredDossiers" :key="dossier.id" class="tr-shadow" >
                                 <td>{{dossier.id}}</td>
                                 <td>
                                    <span class="block-email"  >{{emails[dossier.id]}} </span>
                                 </td>
                                 <td>
                                       <span class="status--process" >{{dossier.statue}}</span>
                                 </td>
                                 <td>{{dossier.date_depot_prevu}}</td>
                                 <td>
                                       <div class="table-data-feature">
                                             <div class="item" data-toggle="tooltip" data-placement="top" title="Déposer"  @click="getTypeFichier(dossier.id)"  v-on:click="toggleModale" >
                                                <i class="zmdi zmdi-upload"></i>
                                             </div>
                                          <router-link :to="{ name: 'modifierdossier.index' , params: { id: dossier.id }  }">
                                             <div class="item" data-toggle="tooltip" data-placement="top" title="Modifier"  >
                                                <i class="zmdi zmdi-edit"></i>
                                             </div>
                                          </router-link>
                                          <button class="item" data-toggle="tooltip" data-placement="top" title="Supprimer" @click="getIdDossier(dossier.id)" v-on:click="toggleModaleSupp">
                                             <i class="zmdi zmdi-delete"></i>
                                          </button>
                                       </div>
                                 </td>
                              
                              </tr> 
                              <tr class="spacer"></tr>
                              <tr class="spacer"></tr>
                              <tr class="spacer"></tr>
                           </tbody>
                     </table>
                  </div>
         </div>

      </div>
      <modale v-bind:revele="revele" v-bind:files="files" v-bind:TypeFichier="TypeFichier" v-bind:date_ech="date_ech"   v-bind:metaData="metaData"  v-bind:type_fichier="type_fichier" v-bind:form="form" v-bind:toggleModale="toggleModale" v-on:Televerser-Fichier="EmitData"  ></modale>
      <modaleSupp v-bind:dossiers="dossiers" v-bind:supprimer='supprimer' v-bind:id_dossier="id_dossier" v-bind:toggleModaleSupp="toggleModaleSupp" v-on:Supprimer-Dossier="SuppDossier"></modaleSupp>
   </div>
</template>
<script>
import ModaleTeleverser from './TeleverserFichiersComponent.vue';
import ModaleDeleteDossier from './SupprimerDossierComponent.vue';
export default{
   components:{
    'modale' : ModaleTeleverser,
    'modaleSupp':ModaleDeleteDossier,
    },
   data(){
      return {
         search:'',
         revele:false,
         supprimer:false,
         type_fichier:[],
         dossiers:[],
         emails :{
            id : ''
         },
         form:null,
         id_dossier:'',
         date_ech:null,
         files:null,
         TypeFichier:null,
         metaData:[],
      }
   },
   methods: {
      
      async getTypeFichier(id){
            this.id_dossier = id;
            const response = await this.callApi('get','/api/typeFichierMetaData/'+id);
            if(response.status == 200){
                this.type_fichier =Object.values( response.data) ;
                console.log( this.type_fichier);
            }
            this.getMetaData();
      },
      toggleModale : function(){
         this.revele = !this.revele;
         this.nbFichier = 0 ;
         this.date_ech =[];
         this.files=[],
         this.TypeFichier=[],
         this.form =new FormData();
         this.form.append('id_dossier',this.id_dossier);
         this.form.append('nbFichier',this.nbFichier);
      },
      getIdDossier(id){
         this.id_dossier = id ;
      },
      toggleModaleSupp : function()
      {
         this.supprimer = !this.supprimer;
      },
      async getMetaData(){
         const response = await this.callApi('get','/api/MetaData/'+this.id_dossier);
              if(response.status == 200){
                this.metaData =response.data ;
            } 
      },
      async EmitData(payload) {

         this.form = payload.Data ;
         for(var p of this.form){
                console.log(p);
            }
         
         const config = { headers: { 'Content-Type': 'multipart/form-data' } };
         const response = await this.callApi('post','/api/MetaData',this.form,config);
         console.log(response.data);
               if(response.status == 200){
                  this.toggleModale();
                  this.$toast.open({
                     message: 'Fichiers Bien Déposé',
                     type :'success' ,
                     position :'top-right',
                     duration : 3000
                  });
               
               }
               else {
                  this.$toast.open({
                     message: 'Il y a des errurs dans le dépot des Fichiers',
                     type :'error' ,
                     position :'top-right',
                     duration : 3000
                  });

               }
   },
   SuppDossier(payload){
      this.dossiers = payload.Data;
      this.toggleModaleSupp();
   }
   
   },
   computed:{
      filteredDossiers(){
         return this.dossiers.filter((dossier)=>{
            if (this.search != ''){
               if(dossier.id == this.search){
               return dossier;
               }
               if(this.emails[dossier.client_id] == this.search){
                  return dossier
               }
               if(dossier.statue == this.search){
               return dossier;
               }
            }
            else {
               return dossier
            }
         });
      },
       async getDossier(){
         const response = await this.callApi('get','/api/dossiers');
         if(response.status == 200){
            this.dossiers = response.data;
           
         }
         this.getEmailClient ;
      },
      async getEmailClient(){
         for (var i =0; i<this.dossiers.length ; i++  ){
            var id = this.dossiers[i].client_id ;
            const response = await  this.callApi('get','/api/clients/'+id);
            if(response.status == 200){
               this.emails[this.dossiers[i].id]= response.data;  
            }
         }   

      },

   },
   mounted(){
      this.getDossier;
      
   }

}
</script>
<style>
/* Styles for wrapping the search box */

.main {
    width: 100%;
    margin: 10px auto;
}

/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
</style>