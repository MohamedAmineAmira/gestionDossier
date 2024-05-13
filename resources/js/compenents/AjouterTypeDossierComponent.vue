<template>
<div class="bloc-modale" v-if="revele">
    <div class="overlay"  v-on:click="toggleModale"></div>
    <div class="col-8">
        <div class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
                <div class="modal-header">  
                <h5 class="modal-title" >Nouveau Type Dossier</h5>
                <div v-on:click="toggleModale">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                        <form action="" method="post" class=""> 
                                <div class="form-group">
                                    <div class="col-sm-11"> 
                                         <label for="message-text" class="col-form-label">Nom Type Dossier:</label>
                                        <div class="input-group">
                                            <input type="text"   class="form-control" v-model="addData.nom">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-11">
                                         <label for="message-text" class="col-form-label">Description:</label> 
                                        <div class="input-group">
                                            <textarea type="textarea"  class="form-control" v-model="addData.description" rows="3"/>
                                        </div>
                                    </div>
                                </div>
                        </form>  
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  @click="emitAddData" >Enregistrer</button>
                    <button type="button" class="btn btn-secondary" v-on:click="toggleModale">Annuler</button>
                </div>
            </div>
        </div>
    </div>
        
    
</div>       
</template>
<script>
    export default {
        name:'ModaleTypeDossier',
        props :['revele','toggleModale'],
        data(){
            return{
                addData:{
                    nom:undefined,
                    description:undefined,
                }    
            }

        },
        methods:{
            emitAddData() {
                this.$emit('Enregisterer-Type-Dossier', {Data : this.addData });
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