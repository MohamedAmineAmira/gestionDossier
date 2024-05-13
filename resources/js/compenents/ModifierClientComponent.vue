<template>
<div class="bloc-modale" v-if="modifier">
    <div class="overlay"  v-on:click="toggleModaleEdit"></div>
        
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" ><i class="zmdi zmdi-account-box"></i>  Modifier Client</h5>
                    <div v-on:click="toggleModaleEdit">
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
                                                <input type="text" placeholder="Nom" class="form-control" v-model="edit.nom">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
                                            <div class="input-group">
                                                <input type="text" id="username2" name="prenom" placeholder="Prénom" class="form-control" v-model="edit.prenom">
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
                                            <input type="email" id="email2" name="email" placeholder="Email" class="form-control" v-model="edit.email">
                                            <div class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12"> 
                                        <div class="input-group">
                                            <input type="text" id="tel" name="tel" placeholder="Téléphone" class="form-control" v-model="edit.tel">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>  
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  @click="emitEditData" >Modifier</button>
                    <button type="button" class="btn btn-secondary" v-on:click="toggleModaleEdit">Annuler</button>
                </div>
                
            </div>
        </div> 
    
</div>
    
    
</template>
<script>
    export default {
        name:'ModaleEditClient',
        props :['modifier','edit','toggleModaleEdit'],
        data(){
            return{   
            }

        },
        methods:{
            emitEditData(){
                this.$emit('Modifier-Client', {EditData : this.edit });
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