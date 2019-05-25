<template>  
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Tahun</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-model="year" label="Tahun" type="text" :rules="[rules.required]" ></v-text-field>

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
              <span class="headline">Laporan Pengeluaran {{this.year}}</span>
            </v-card-title>  
            <v-card-text>
              <table style="width:100%" border="bold">
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Total</th>
                      </tr>
                      <template v-for="(data, i) in cek">
                        <tr :key="i">
                          <td>{{i}}</td>
                          <td>{{bulan[i]}}</td>
                          <td>Rp. {{!!data.Total? data.Total:0}}</td>
                        </tr>
                      </template>
                      <tr>
                          <td colspan="2" align="right">Total</td>
                          <td>Rp.  </td>
                      </tr>
                    </table>               
                <v-btn color="primary" @click="printMe">Print</v-btn>
            </v-card-text>
          </v-card>
          </v-dialog>
        </v-layout>

        <!-- PRINT -->

    <div v-show="false" id="printMe">
      <div class="ma-3">              
        <div style="text-align: center">                  
            <p class="headline">ATMA AUTO</p>
            <p class="" >MOTORCYCLE SPAREPARTS AND SERVICES</p>
            <p class="">Jl. Babarsari No. 43 Yogyakarta 552181</p>
            <p class="">Telp. (0274)487711</p>
            <p class="">http://www.atmaauto.com</p>
            <hr>
            <br>
            <p class="title">LAPORAN PENGELUARAN</p>
             <div style="text-align: left">                  
                 <p>Tahun: {{this.year}}</p>
              </div>                                  
        </div>
            <br>
            <div class="text-xs-center">
              <table style="width:100%" border="bold">
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Total</th>
                      </tr>
                      <template v-for="(data, i) in cek">
                        <tr :key="i">
                          <td>{{i}}</td>
                          <td>{{bulan[i]}}</td>
                          <td>Rp. {{!!data.Total? data.Total:0}}</td>
                        </tr>
                      </template>
                      <tr>
                          <td colspan="2" align="right">Total</td>
                          <td>Rp.  </td>
                      </tr>
                </table>
          </div>
      </div>
    </div>


      </v-container>
    
</template>


<script>
  export default {
    props: ['nextUrl'],
    data: () => ({
      outcome: [],
      cek: [],
      year: "",
      bulan: ['bulan','Jan','Feb','Mar','Apr','May','June','July','Aug','Sep','Oct','Nov','Des'],
           
      rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong'
      },
      dialog: false,
      editedItem: {  
    },
   
    }),
    computed: {
        formTitle () {
      return this.editedIndex === -1 ? 'Data User' : 'Data Tidak Ditemukan'
    },

    },
    methods:{
        printMe(){
            this.$htmlToPaper('printMe');
        },
        cari(){
            this.dialog = true;
            axios.get('/8786/api/laporan/outcome/'+ this.year)
            .then(response =>{
              this.outcome = response.data
              this.cek = this.outcome.outcome;
              console.log(this.cek);
              })
        },
        
    }
  }
</script>