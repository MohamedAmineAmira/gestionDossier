<template>
<div class="bloc-modale" v-if="revele">
    <div class="overlay"  v-on:click="toggleModale"></div>
        
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" ><i class="zmdi zmdi-account-add"></i>  Nouveau Client</h5>
                    <div v-on:click="toggleModale">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                        <form action="" method="post" class="">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-md-6" >
                                            <div class="input-group">
                                                <input type="text" placeholder="Nom" class="form-control" v-model="addData.nom">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
                                            <div class="input-group">
                                                <input type="text" id="username2" name="prenom" placeholder="Prénom" class="form-control" v-model="addData.prenom">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12"> 
                                        <div class="input-group">
                                            <input type="email" id="email2" name="email" placeholder="Email" class="form-control" v-model="addData.email">
                                            <div class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12"> 
                                        <div class="input-group">
                                            <input type="text" id="tel" name="tel" placeholder="Téléphone" class="form-control" v-model="addData.tel">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i> 
                                            </div>
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
    
    
</template>
<script>
    export default {
        name:'ModaleClient',
        props :['revele','toggleModale'],
        data(){
            return{
                addData:{
                    nom:undefined,
                    prenom:undefined,
                    email:undefined,
                    tel:undefined
                }    
            }

        },
        methods:{
            emitAddData() {
                this.$emit('Enregisterer-Client', {Data : this.addData });
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