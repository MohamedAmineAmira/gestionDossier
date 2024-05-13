<template>
    <div >
         <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Modifier Dossier  </strong> 
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Client</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <v-select v-model="editData.selectedClient" label="email" :options="clients"  placeholder="Sélectionner un client" v></v-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Type Dossier</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <v-select v-model="editData.selectedDossier" label="nom" :options="typedossiers"  placeholder="Sélectionner un type de dossier" v></v-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="disabledSelect" class=" form-control-label">Statue Dossier</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <v-select  v-model="editData.statue" :options="['En préparation','Prêt','Déposé','Incomplet','Accepté','Réfusé','Clôturé']" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="multiple-select" class=" form-control-label">Types Fichiers</label>
                                </div>
                                <div class="col col-md-9" inline="true">
                                    <v-select v-model="editData.selectedFichier.fichier" multiple label="nom" :options="typefichiers" placeholder="Sélectionner les types des fichiers" v></v-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Date Dépôt Prévue </label>
                                </div>
                                <div class="col col-md-9" inline="true" >
                                         <Datepicker v-model="editData.date" :enableTimePicker="false" placeholder="Sélectionner une date"  />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="textarea-input" class=" form-control-label">Description</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea v-model="editData.description" name="textarea-input" id="textarea-input" rows="3" placeholder="Content..." class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <router-link :to="{ name: 'dossier.index' }">
                                    <button type="submit" class="btn btn-primary" @click="editDossier()">
                                        Modifier Dossier
                                    </button>
                                </router-link>
                            </div>
                            <div class="form-group col-md-2">
                                <router-link :to="{ name: 'dossier.index' }">
                                    <button type="reset" class="btn btn-danger">
                                        Annuler
                                    </button>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
         </div>       
    </div>
    
</template>
<script>
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import moment from 'moment';
    
    export default {
        components: { Datepicker },
        props:{
            id:{required: true}
        },
        data() {
            return {
                editData :{
                    selectedClient:undefined,
                    selectedDossier:undefined,
                    selectedFichier:{
                        fichier:undefined
                    },
                    date:null,
                    description:undefined,
                    statue:null,
                  

                },
                clients :[],
                typedossiers :[],
                typefichiers :[],
            };
        
        },
        computed:{
       async getClient(){
            const response = await this.callApi('get','/api/clients/emails');
            if(response.status == 200){
                this.clients = response.data;
           
            }
        },
        async getTypeDossier(){
            const response = await this.callApi('get','/api/typedossiers/noms');
            if(response.status == 200){
                this.typedossiers = response.data;
               
             }  
        },
        async getTypeFichier(){
            const response = await this.callApi('get','/api/typefichiers');
            if(response.status == 200){
                this.typefichiers = response.data;
            }  
        }

        },
        methods :{
        async editDossier(){
            this.editData.date = moment(this.editData.date).format("yyyy-MM-DD");
            const response = await this.callApi('put','/api/dossier/edit/'+this.id,this.editData);
            if(response.status == 200){
                this.$toast.open({
                    message: 'Dossier Bien Modifié',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la modification de dossier',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }

        },
        async getDossier(){
            const response = await this.callApi('get','/api/dossiers/'+this.id);
            if(response.status == 200){
                var dossier = response.data ;
                this.editData.date = dossier.date_depot_prevu ;
                this.editData.statue = dossier.statue ;
                this.editData.description =dossier.description;
                this.getEmailClient(dossier.client_id);
                this.getNomTypeDossier(dossier.type_dossier_id);
                this.getNomsTypeFichier(dossier.id);

            } 

        },
        async getEmailClient(id){
            const response = await this.callApi('get','/api/clients/'+id);
            if(response.status == 200){
                this.editData.selectedClient = response.data ;
            }
        },
        async getNomTypeDossier(id){
            const response = await this.callApi('get','/api/typedossiers/'+id);
            if(response.status == 200){
                this.editData.selectedDossier = response.data.nom ;
            }
        },
        async getNomsTypeFichier (id){
      
            const response = await this.callApi('get','/api/dossiertypefichier/'+id);
            if(response.status == 200){
                var fichiers = response.data ;
                this.editData.selectedFichier.fichier =[];
                for (var i=0  ;i< fichiers.length ;i++)
                {
                  this.editData.selectedFichier.fichier[i] =fichiers[i];  

                }
            }
        }

        },
         mounted(){
            this.getDossier();
            this.getClient;
            this.getTypeDossier;
            this.getTypeFichier;
      
        }
    }
</script>
