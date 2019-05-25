<template>  
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Cari Kustomer</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-model="Plat_Kendaraan" label="Nomor Polisi" type="text" :rules="[rules.required]" ></v-text-field>

                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="cari">Cari</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>

          <v-dialog v-model="dialog" max-width="800px">
            <template v-slot:activator="{ on }">
            </template>
           <v-card>
            <v-card-title>
              <span class="headline">Hasil Pencarian</span>
            </v-card-title>
  
            <v-card-text>
              <table style="width:100%" border="bold">
                      <tr>
                        <th>Nama Cust</th>
                        <th>Plat Nomor</th>
                        <!-- <th>Status</th> -->
                        <th>Tipe</th>
                        <!-- <th>Service</th>
                        <th>Jumlah</th>
                        <th>Harga</th> -->
                      </tr>
                      <template v-for="(data, i) in kendaraan">
                        <tr :key="i">
                          <td>{{data.kustomers.Nama_Kustomer}}</td>
                          <td>{{data.Plat_kendaraan}}</td>
                           <!-- <td>{{data.transaksi_services.Status}}</td> -->
                          <td>{{data.Tipe}}</td>
                          <!-- <td>{{data.TS.Nama_Service}}</td> -->
                        </tr>
                      </template>
                    </table>
            
              
            </v-card-text>
  
          </v-card>
          </v-dialog>
        </v-layout>
      </v-container>
    
</template>


<script>
  export default {
    props: ['nextUrl'],
    data: () => ({
      kendaraan: [],
      customers: [],
      TS:[],
      Telepon_Kustomer: "",
      Plat_Kendaraan: "",
           
      rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong'
      },
      dialog: false,
      editedItem: {  
    },
    headers: [
      { text: 'Nama Customer', value: 'Nama_Kustomer', sortable: false },
      { text: 'Plat Kendaraan', value: 'Plat_Kendaraan', sortable: false },
      { text: 'Status', value: 'Status', sortable: false },
      { text: 'Tipe Kendaraan', value: 'Tipe', sortable: false },
      { text: 'Nama Service', value: 'Nama_Service', sortable: false },
      { text: 'Jumlah', value: 'Jumlah_Service', sortable: true },
      { text: 'Harga', value: 'Harga', sortable: true },
    ],
    
    }),
    computed: {
        formTitle () {
      return this.editedIndex === -1 ? 'Data User' : 'Data Tidak Ditemukan'
    }

    },
    methods:{
        cari(){
            this.dialog = true;
            axios.get('/8786/api/kendaraan/findKendaraan/'+ this.Plat_Kendaraan)
            .then(response =>{
              this.kendaraan = response.data
              this.customers = this.kendaraan.kustomers;
              this.TS = this.kendaraan.transaksi_services;
              console.log(this.TS);
              })
  
        },
        
    }
  }
</script>


 