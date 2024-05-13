<template>
    <div>
        <div class="bloc-modale" v-if="revele">
            <div class="overlay"  v-on:click="toggleModale"></div>
             <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" ><i class="zmdi zmdi-upload"></i> Televerser Fichiers  </h5>
                        <div v-on:click="toggleModale">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                        <div class="modal-body">
                            <div v-for="(fichier, key, index) in type_fichier " >
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <strong>{{fichier.nom}}</strong> 
                                    </div>
                                    <div  class="col-md-5">
                                        <input type="file" id="file-input" name="file-input"  class="form-control-file" @change="handleFileUpload( $event.target.files,index,key)">
                                    </div>
                                    <div v-if="index != undefined " class="col col-md-3">
                                        <Datepicker v-model="date_ech[index]"  :enableTimePicker="false" placeholder="Date d'échéance" @closed="formatDate(index)" autoApply />
                                    </div >
                                    <div v-if="index == undefined " class="col col-md-3">
                                        <Datepicker v-model="date_ech[key]"  :enableTimePicker="false" placeholder="Date d'échéance" @closed="formatDate(key)" autoApply />
                                    </div >
                                    <div class="col-md-1" >
                                        <button disabled type="button" class="btn btn-outline-success btn-lg" data-placement="top" title="Télécharger"><i class="zmdi zmdi-download"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>
                            <div v-for=" (metaData , index) in metaData" :key="metaData.id" >
                                <div v-if="metaData.date_ech != undefined ">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <strong>{{metaData.nom_type_fichier}}</strong>
                                        </div>
                                        <div class="col-md-4">
                                            {{metaData.nom_fichier}} 
                                        </div>
                                        <div class="col col-md-3">
                                            <Datepicker disabled  v-model="metaData.date_ech"  :enableTimePicker="false" placeholder="Date d'échéance"  />
                                        </div >
                                            <div class="col-md-1">
                                            <button type="button" class="btn btn-outline-success btn-lg" data-placement="top" title="Modifier" @click="Edit(index)"><a></a> <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-1" >
                                            <button type="button" class="btn btn-outline-success btn-lg" data-placement="top" title="Télécharger" @click="download(index)"><i class="zmdi zmdi-download"></i>
                                            </button>
                                        </div>
                                    </div>  
                                </div>   
                            </div>  
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-primary"  @click="emitData" >Enregistrer</button>
                        <button type="button" class="btn btn-secondary" v-on:click="toggleModale">Annuler</button>
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
export default{
    components: { Datepicker },
    name:'ModaleTeleverser',
    props :['revele','type_fichier','TypeFichier','files','date_ech','form','toggleModale','metaData'],
    data() {
        return {
           
        }
    },
    methods:{
        handleFileUpload(fileList , index ,key) {
            if(index == undefined ){
                this.files[key]= fileList[0];
                this.TypeFichier[key]= this.type_fichier[key]['nom'];
            }
            else{
                this.files[index]= fileList[0];
                this.TypeFichier[index]= this.type_fichier[key]['nom'];
            }
           
           
        },

        formatDate(index ){
            if (this.date_ech != undefined)
            {
                this.date_ech[index]=moment( this.date_ech[index]).format("yyyy-MM-DD");
            }
        },
        async Edit(index){ 
            this.type_fichier.push({"nom":this.metaData[index].nom_type_fichier })
            const response = await this.callApi('post','/api/MetaData/delete',this.metaData[index]);
                if(response.status == 200){
                    this.metaData[index] = {} ;
                }
        },
        emitData(){
            var nb = this.date_ech.length;
            for(var i=0 ; i<this.date_ech.length ;i++){
                if (this.date_ech[i] != undefined)
                    {
                        this.form.append('dates[]',this.date_ech[i]);
                        this.form.append('files[]',this.files[i]);
                        this.form.append('typeFichiers[]',this.TypeFichier[i]);
                    }
                    else
                    {
                        nb--;
                    }
            }
            this.form.set('nbFichier',nb);


            this.$emit('Televerser-Fichier', {Data : this.form });
        },
        async download(index){
            const response = await this.callApiGet(this.metaData[index].id);
               // create file link in browser's memory
                const href = URL.createObjectURL(response.data);

                // create "a" HTLM element with href to file & click
                const link = document.createElement('a');
                link.href = href;
                link.setAttribute('download', this.metaData[index].nom_fichier); //or any other extension
                document.body.appendChild(link);
                link.click();

                // clean up "a" element & remove ObjectURL
                document.body.removeChild(link);
                
                 }
    },

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