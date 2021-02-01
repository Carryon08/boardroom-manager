<template>
    <div class="container">
        <div class="row justify-content-center">

            <a class="btn btn-elevate btn-success float-right btn-circle"
               @click="modalType=true, showModal()">Nueva reserva</a>

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
                                <label for="start_hour" class="col-md-4 col-form-label text-md-right">Hora de incio</label>

                                <div class="col-md-6">
                                    <input id="start_hour" type="time" class="form-control " v-model="reservation.start_hour"
                                           name="start_hour" value="" required autocomplete="start_hour" autofocus>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end_hour" class="col-md-4 col-form-label text-md-right">Hora final</label>

                                <div class="col-md-6">
                                    <input id="end_hour" type="time" class="form-control " v-model="reservation.end_hour"
                                           name="end_hour" value="" required autocomplete="end_hour" autofocus>

                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button @click="closeModal()" type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cerrar</button>
                            <button @click="saveReservation()" type="button" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props:[
          'id','auth_id',
        ],
        data(){
            return{
                modal:0,
                modalType:'',
                modalTitle:'',
                reservation: {
                    start_hour:'',
                    end_hour:'',
                    boardroom_id:'',
                    user_id:'',
                },
                reservations:[

                ],
            }
        },
        methods:{
            getBoardroomReservations(){
                const response= axios.get('/reservation',this.id);
                this.reservations = response.data;
            },
            async showModal(data={}){
                this.modal =1 ;
                this.modalTitle="Crear evento";
                this.reservation.start_hour ='';
                this.reservation.end_hour ='';
                this.reservation.boardroom_id = this.id;
                this.reservation.user_id = this.auth_id;
            },
            async closeModal(){
                this.modal =0 ;
            },
            async saveReservation(id){
                axios.post('/reservation',this.reservation);
                this.closeModal();
            },
        },
        created(){
        },

    }
</script>
<style>
    .show{
        display: list-item;
        opacity: 1;

    }
</style>
