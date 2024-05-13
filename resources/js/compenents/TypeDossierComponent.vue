<template>
   <div>
         <div class="row">
            <div class="col-md-12">
                  <div class="table-data__tool">
                     <div class="table-data__tool-left">
                         <div class="overview-wrap">
                           <h2 class="title-1">Tableau des Types Dossiers</h2>
                         </div> 
                     </div>
                     <div class="table-data__tool-right">
                        <div v-on:click="toggleModale" class="au-btn au-btn-icon au-btn--blue"  >
                              <i class="zmdi zmdi-plus"></i>Ajouter Type Dossier 
                        </div>
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
                              <tr v-for="typedossier in typedossiers" :key="typedossier.id" class="tr-shadow" >
                                 <td>{{typedossier.id}}</td>
                                 <td>{{typedossier.nom}}</td>
                                 <td>
                                    <span class="block-email"  >{{typedossier.description}} </span>
                                 </td>
                                
                                 <td>
                                      <div class="table-data-feature">
                                         <div class="item" data-toggle="tooltip" data-placement="top" title="Modifier" v-on:click="toggleModaleEdit" @click="showEditTypeDossier(typedossier)">
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

      <modale v-bind:revele="revele" v-bind:toggleModale="toggleModale" v-on:Enregisterer-Type-Dossier="SubmitAddData"></modale>
      <modaleEdit v-bind:modifier="modifier" v-bind:edit="edit" v-bind:toggleModaleEdit="toggleModaleEdit" v-on:Modifier-TypeDossier="EditData"  ></modaleEdit>
   </div>
</template>
<script>
   import ModaleTypeDossier from './AjouterTypeDossierComponent.vue' ;
   import ModaleEditTypeDossier from './ModifierTypeDossierComponent.vue';
export default{
    components:{
    'modale' :ModaleTypeDossier,
    'modaleEdit':ModaleEditTypeDossier,
   },
   data(){
      return {
         typedossiers:[],
         revele:false ,
         modifier:false,
         addData :null,
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
        const response = await this.callApi('post','/api/typedossier/create',this.addData);
            if(response.status == 200){
                this.toggleModale();
                this.typedossiers = response.data ;
                this.$toast.open({
                    message: 'Type Dossier Bien Enregitré',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la creation de type de dossier',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }
        

    },
    showEditTypeDossier(typedossier){
  
      this.edit.id= typedossier.id ;
      this.edit.nom =typedossier.nom ;
      this.edit.description = typedossier.description ;
    
    },
   async EditData(payload){
        this.edit = payload.EditData ;
        const response = await this.callApi('put','/api/typedossier/edit/'+this.edit.id,this.edit);
          if(response.status == 200){
                this.toggleModaleEdit();
                this.typedossiers = response.data ;
                this.$toast.open({
                    message: 'Type Dossier Bien Modifié',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la modification de type dossier',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }
   }
   },
   computed:{
       async getTypeDossier(){
         const response = await this.callApi('get','/api/typedossiers');
         if(response.status == 200){
            this.typedossiers = response.data;
           
         }
        
       } 
   },
   mounted(){
      this.getTypeDossier;
      
   }

}
</script>