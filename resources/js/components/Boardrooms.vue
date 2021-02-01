<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header " >
                        <h2>Salas registradas
                        <a class="btn btn-elevate btn-success float-right btn-circle"
                           @click="modalType=true, showModal()" v-if="admin">Nueva sala</a>
                        </h2>
                    </div>

                    <div class="card-body row justify-content-center">

                        <div class="card col-md-5 bg-primary mr-2 ml-2 mt-2" v-for="boardroom in boardrooms" :key="boardroom.id">
                            <div class="card-header font-weight-bold"><h5>{{boardroom.name}}
                                <a class="btn btn-danger btn-elevate btn-circle btn-icon float-right ml-3" v-if="admin"
                                   @click="deleteBoardroom(boardroom.id)" title="Borrar"><i class="fas fa-trash"></i>
                                </a>
                                &nbsp
                                <a class="btn btn-warning btn-elevate btn-circle btn-icon float-right " title="Editar" v-if="admin"
                                       @click="modalType=false, showModal(boardroom)"><i class="far fa-edit"></i>
                                </a>
                            </h5>
                            </div>
                            <br>
                            <table class="table">
                                <tbody>
                                <tr v-for="reservation in boardroom.reservations" :key="boardrooms.id" >
                                    <th scope="row">{{reservation.start_hour}}</th>
                                    <th >{{reservation.end_hour}}</th>
                                    <td>
                                        <a class="btn btn-danger btn-elevate btn-circle btn-icon float-right ml-3" v-if="admin"
                                           @click="deleteReservation(reservation.id)" title="Borrar"><i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
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
                    reservations:[],
                },
                authUser:{
                    id:'',
                    name:'',
                },
                admin:'',
            }
        },
        computed:{
            descriptionFieldClasses: function () {
                if (this.reservation.user_id===this.auth.id) {
                    return [
                        'bg-warning',
                    ];
                }
            }
        },
        methods:{
            async getBoardrooms(){
                axios.get('delete-reservations');
                const response=await axios.get('boardroom');
                const auth=await axios.get('get-auth');
                this.boardrooms = response.data;
                this.authUser = auth.data;
                if(this.authUser.user_type_id===1) {
                    this.admin=true;
                }
                else {
                    this.admin=false;
                }

            },
            async deleteBoardroom(id){
                const response=await axios.delete('/boardroom/'+id);
                this.getBoardrooms();
            },
            async deleteReservation(id){
                const response=await axios.delete('/reservation/'+id);
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
        },
        created(){
            this.getBoardrooms();
        },

    }
</script>
<style>
    .show{
        display: list-item;
        opacity: 1;

    }
</style>

