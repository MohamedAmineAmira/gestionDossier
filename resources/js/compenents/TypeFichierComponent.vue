<template>
   <div>
         <div class="row">
            <div class="col-md-12">
                  <!-- DATA TABLE -->

                  <div class="table-data__tool">
                     <div class="table-data__tool-left">
                         <div class="overview-wrap">
                           <h2 class="title-1">Tableau des Types Fichiers</h2>
                         </div> 
                     </div>
                     <div class="table-data__tool-right">
                           <button v-on:click="toggleModale" class="au-btn au-btn-icon au-btn--blue">
                              <i class="zmdi zmdi-plus"></i>Ajouter Type Fichier
                           </button>
                     </div>
                  </div>
                  <div  class="table-responsive table--no-card m-b-30">
                     <table  class="table table-borderless table-striped table-earning">
                           <thead>
                              <tr>
                                 <th>Réf</th>
                                 <th>Nom</th>
                                 <th>Description</th>
                                 <th>options</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr v-for="typefichier in typefichiers" :key="typefichier.id" class="tr-shadow" >
                                 <td>{{typefichier.id}}</td>
                                 <td>{{typefichier.nom}}</td>
                                 <td>
                                    <span class="block-email"  >{{typefichier.description}} </span>
                                 </td>
                                
                                 <td>
                                       <div class="table-data-feature">
                                          <div class="item" data-toggle="tooltip" data-placement="top" title="Modifier" v-on:click="toggleModaleEdit" @click="showEditTypeFichier(typefichier)">
                                             <i class="zmdi zmdi-edit"></i>
                                          </div>
                                          <button class="item" data-toggle="tooltip" data-placement="top" title="Supprimer">
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
   <modale v-bind:revele="revele" v-bind:toggleModale="toggleModale" v-on:Enregisterer-Type-Fichier="SubmitAddData"></modale>   
    <modaleEdit v-bind:modifier="modifier" v-bind:edit="edit" v-bind:toggleModaleEdit="toggleModaleEdit" v-on:Modifier-TypeFichier="EditData"  ></modaleEdit>
   </div>
</template>
<script>
   import ModaleTypeFichier from './AjouterTypeFichierComponent.vue' ;
   import ModaleEditTypeFichier from './ModifierTypeFichierComponent.vue';
export default{
    components:{
    'modale' :ModaleTypeFichier,
    'modaleEdit':ModaleEditTypeFichier,
   },
   data(){
      return {
         typefichiers:[],
         revele:false ,
         addData :null,
         modifier: false,
         edit:{
            id:'',
            nom:'',
            description:''
         }

      }
   },
   methods: {
       toggleModale : function(){
        this.revele = !this.revele;
      },
      toggleModaleEdit : function(){
        this.modifier = !this.modifier;
      },
      async SubmitAddData(payload) {
        this.addData = payload.Data ;
        const response = await this.callApi('post','/api/typefichier/create',this.addData);
            if(response.status == 200){
                this.toggleModale();
                this.typefichiers = response.data ;
                this.$toast.open({
                    message: 'Type Fichier Bien Enregitré',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la creation de type de fichier',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }
        

    },
    showEditTypeFichier(typefichier){
 
      this.edit.id= typefichier.id ;
      this.edit.nom =typefichier.nom ;
      this.edit.description = typefichier.description ;
     
    },
     async EditData(payload){
        this.edit = payload.EditData ;
        const response = await this.callApi('put','/api/typefichier/edit/'+this.edit.id,this.edit);
          if(response.status == 200){
                this.toggleModaleEdit();
                this.typefichiers = response.data ;
                this.$toast.open({
                    message: 'Type Fichier Bien Modifié',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la modification de type fichier',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }
   }
   },
   computed:{
       async getTypeFichier(){
         const response = await this.callApi('get','/api/typefichiers');
         if(response.status == 200){
            this.typefichiers = response.data;
           
         }
        
       } 
   },
   mounted(){
      this.getTypeFichier;    
   }

}
</script>