
export default {
    data(){
        return{

        }
    },
    methods: {
        async callApi(method , url , objet){
           try {
            return await axios({
                method: method,
                url: url,
                data: objet
            });
           } catch (e) {
            return e.response;
           }
        },
        async callApiGet(id){
            try {
             return await axios({
                url: 'http://gestiondossier.test/api/MetaData/download/'+id,
                method: 'GET',
                responseType: 'blob',
             });
            } catch (e) {
             return e.response;
            }
         }
    
    }
}