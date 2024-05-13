<template>
    <div class="bloc-modale" v-if="supprimer">
        <div class="overlay"  v-on:click="toggleModaleSupp"></div>
        <div class="col-8">
            <div class="modal-dialog " role="document">
               <div class="modal-content">
                    <div class="modal-header">  
                    <h5 class="modal-title" >Supprimer Dossier</h5>
                    <div v-on:click="toggleModaleSupp">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                   <p>Êtes-vous sûr de vouloir supprimer ce Dossier ?</p>         
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" v-on:click="toggleModaleSupp">Annuler</button>
                        <button type="button" class="btn btn-danger"  @click="supprimerDossier" >Oui, Supprimer</button>
                </div>
                </div>
            </div>
        </div>
            
        
    </div>       
    </template>
    <script>
        export default {
            name:'ModaleDeleteDossier',
            props :['dossiers','supprimer','id_dossier','toggleModaleSupp'],
            data(){
                return{    
                }
            },
            methods:{
            async supprimerDossier(){
                    const response = await this.callApi('get','/api/dossiers/delete/'+this.id_dossier);
                    if(response.status == 200){
                        this.$emit('Supprimer-Dossier', {Data : response.data });
                    }
                    
                }
            }
           
        }
    </script>
    <style>
        .bloc-modale{
            position: fixed;
            top:0;
            bottom:0;
            left: 0;
            right:0;
            display:flex;
            justify-content: center;
            align-items: center;
            z-index: 4;
        }
        .overlay{
            background:rgba(0,0,0,0.5);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right:0;
           
            
        }
        
    
    </style>