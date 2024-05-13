<template>
    <div >
         <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Nouveau Dossier</strong> 
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Client</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <v-select v-model="addData.selectedClient" label="email" :options="clients"  placeholder="Sélectionner un client" v></v-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Type Dossier</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <v-select v-model="addData.selectedDossier" label="nom" :options="typedossiers"  placeholder="Sélectionner un type de dossier" v></v-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="disabledSelect" class=" form-control-label">Statue Dossier</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select name="disabledSelect" id="disabledSelect" disabled="" class="form-control">
                                        <option value="0">En préparation</option>
                                        <option value="1">......</option>
                                        <option value="2">Option #2</option>
                                        <option value="3">Option #3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="multiple-select" class=" form-control-label">Types Fichiers</label>
                                </div>
                                <div class="col col-md-9" inline="true">
                                    <v-select v-model="addData.selectedFichier.fichier" multiple label="nom" :options="typefichiers" placeholder="Sélectionner les types des fichiers" v></v-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Date Dépôt Prévue </label>
                                </div>
                                <div class="col col-md-9" inline="true" >
                                         <Datepicker v-model="addData.date" :enableTimePicker="false" placeholder="Sélectionner une date"  />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="textarea-input" class=" form-control-label">Description</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea v-model="addData.description" name="textarea-input" id="textarea-input" rows="3" placeholder="Content..." class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <router-link :to="{ name: 'dossier.index' }">
                                    <button type="submit" class="btn btn-primary" @click="SubmitAddData">
                                        Enregistrer Dossier
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
        data() {
            return {
                addData :{
                    selectedClient:undefined,
                    selectedDossier:undefined,
                    selectedFichier:{
                        fichier:undefined
                    },
                    date:null,
                    description:undefined
                  

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
        async SubmitAddData(){
            this.addData.date = moment(this.addData.date).format("yyyy-MM-DD");
            const response = await this.callApi('post','/api/dossier/create',this.addData);
            if(response.status == 200){
                this.$toast.open({
                    message: 'Dossier Bien Enregitré',
                    type :'success' ,
                    position :'top-right',
                    duration : 3000
                });
            
            }
            else {
                this.$toast.open({
                    message: 'Il y a des errurs dans la creation de dossier',
                    type :'error' ,
                    position :'top-right',
                    duration : 3000
                });

            }

            }
        },
         mounted(){
            this.getClient;
            this.getTypeDossier;
            this.getTypeFichier;
      
        }
    }
</script>