<template>
   <div>
         <div class="row" >
            <div class="col-md-12">
                  <div class="table-data__tool">
                     <div class="table-data__tool-left">
                         <div class="overview-wrap">
                           <h2 class="title-1">Tableau des Clients</h2>
                         </div> 
                     </div>
                     <div class="table-data__tool-right">
                           <div v-on:click="toggleModale" class="au-btn au-btn-icon au-btn--blue"   >
                             <i class="zmdi zmdi-account-add"></i> Ajouter Client 
                           </div>
                     </div>
                  </div>
                  <div  class="table-responsive table--no-card m-b-30">
                     <table  class="table table-borderless table-striped table-earning">
                           <thead>
                              <tr>
                                 <th>Nom</th>
                                 <th>Prénom</th>
                                 <th>Email</th>
                                 <th>Téléphone</th>
                                 <th>options</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr v-for="client in clients" :key="client.id" class="tr-shadow" >
                                 <td>{{client.nom}}</td>
                                 <td>{{client.prenom}}</td>
                                 <td>
                                    <span class="block-email"  >{{client.email}} </span>
                                 </td>
                                
                                 <td>{{client.tel}}</td>
                                 <td>
                                       <div class="table-data-feature">
                                          <div class="item" data-toggle="tooltip" data-placement="top" title="Modifier" v-on:click="toggleModaleEdit" @click="showEditClient(client)">
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
     
    <modale v-bind:revele="revele" v-bind:toggleModale="toggleModale" v-on:Enregisterer-Client="SubmitAddData"></modale>
    <modaleEdit v-bind:modifier="modifier" v-bind:edit="edit" v-bind:toggleModaleEdit="toggleModaleEdit" v-on:Modifier-Client="EditData"  ></modaleEdit>
   </div>
</template>
<script>
    import ModaleClient from './AjouterClientComponent.vue';
    import ModaleEditClient from './ModifierClientComponent.vue';
export default{
   components:{
    'modale' :ModaleClient,
    'modaleEdit':ModaleEditClient
    },
   data(){
      return {
        revele:false ,
        modifier:false,
        clients:[] ,
        addData :null,
        edit:{
            id:'',
            nom:'',
            prenom:'',
            email:'',
            tel:''
        },
        id:'',
        }
    },
   methods :{
    toggleModale : function(){
        this.revele = !this.revele;
   },
   toggleModaleEdit : function(){
        this.modifier = !this.modifier;
   },
    async SubmitAddData(payload) {
        this.addData = payload.Data ;
        const response = await this.callApi('post','/api/client/create',this.addData);
            if(response.status == 200){
                this.toggleModale();
                this.clients = response.data ;
                this.$toast.open({
                    message: 'Client Bien Enregitré',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la creation de Client',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }
        

    },
    async EditData(payload){
        this.edit = payload.EditData ;
        const response = await this.callApi('put','/api/client/edit/'+this.edit.id,this.edit);
          if(response.status == 200){
                this.toggleModaleEdit();
                this.clients = response.data ;
                this.$toast.open({
                    message: 'Client Bien Modifié',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la modification de Client',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }
    },
    showEditClient(client){

        this.edit.id = client.id ;
        this.edit.nom = client.nom;
        this.edit.prenom = client.prenom;
        this.edit.email = client.email ;
        this.edit.tel = client.tel;
        

    }
    
   },
   computed:{
       async getClient(){
         const response = await this.callApi('get','/api/clients');
         if(response.status == 200){
            this.clients = response.data;
            
           
         }
        
       } 
   },
   mounted(){
      this.getClient; 
   }

}
</script>
