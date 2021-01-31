<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header " >
                        <h2>Salas registradas
                        <a class="btn btn-elevate btn-success float-right btn-circle"
                           @click="modalType=true, showModal()">Nueva sala</a>
                        </h2>
                    </div>

                    <div class="card-body row justify-content-center">

                        <div class="card col-md-5 bg-primary mr-2 ml-2 mt-2" v-for="boardroom in boardrooms" :key="boardroom.id">
                            <div class="card-header font-weight-bold"><h5>{{boardroom.name}}
                                <a class="btn btn-danger btn-elevate btn-circle btn-icon float-right ml-3"
                                   @click="deleteBoardroom(boardroom.id)" title="Borrar"><i class="fas fa-trash"></i>
                                </a>
                                &nbsp;
                                <a class="btn btn-warning btn-elevate btn-circle btn-icon float-right " title="Editar"
                                       @click="modalType=false, showModal(boardroom)"><i class="far fa-edit"></i>
                                </a>
                            </h5>
                            </div>
                            <div class="card-body"><h2>{{clock}}</h2></div>
<!--                            <router-link to="/reservation">Go to Bar</router-link>-->
                            <reservation :id="boardroom.id" :auth_id="authUser.id"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" tabindex="-1" role="dialog" :class="{show:modal} ">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{this.modalTitle}}</h5>
                            <button @click="closeModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control " v-model="boardroom.name"
                                           name="name" value="" required autocomplete="name" autofocus>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button @click="closeModal()" type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cerrar</button>
                            <button @click="saveBoardroom()" type="button" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import reservation from "./reservation";
    export default {
        name: "Boardroom",
        components:{
            reservation,
        },
        data(){
            return{
                clock:'',
                modal:0,
                modalType:'',
                modalTitle:'',
                id:0,
                boardrooms:[
                    this.name='',
                ],
                boardroom: {
                    name:'',
                    created_at:'',
                },
                authUser:{
                    id:'',
                    name:'',
                },
            }
        },
        methods:{
            async getBoardrooms(){
                const response=await axios.get('boardroom');
                const auth=await axios.get('get-auth');
                this.boardrooms = response.data;
                this.authUser = auth.data;

            },
            async deleteBoardroom(id){
                const response=await axios.delete('/boardroom/'+id);
                this.getBoardrooms();
            },
            async showModal(data={}){
                this.modal =1 ;
                if(this.modalType){
                    this.modalTitle="Crear sala";
                    this.boardroom.name = '';
                }
                else {
                    this.modalTitle="Editar sala";
                    this.id = data.id;
                    this.boardroom.name = data.name;
                }
            },
            async closeModal(){
                this.modal =0 ;
            },
            async saveBoardroom(id){
                if(this.modalType) {
                    axios.post('/boardroom',this.boardroom);
                }
                else {
                    axios.put('/boardroom/'+this.id,this.boardroom);
                }
                this.closeModal();
                this.getBoardrooms();
            },
            async moveClock(){
                let momentoActual = new Date();
                let hora = momentoActual.getHours();
                let minuto = momentoActual.getMinutes();
                let segundo = momentoActual.getSeconds();

                this.clock= hora + " : " + minuto + " : " + segundo;



                //La función se tendrá que llamar así misma para que sea dinámica,
                //de esta forma:

                setTimeout(this.moveClock,1000)
            },
        },
        created(){
            this.getBoardrooms();
            this.moveClock();
        },

    }
</script>
<style>
    .show{
        display: list-item;
        opacity: 1;

    }
</style>

