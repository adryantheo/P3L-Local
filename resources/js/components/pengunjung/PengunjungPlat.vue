<template>
    
        <v-layout align-center justify-center fill-height>
          <v-flex xs12 sm8>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Cari Transaksi dari Nomor Polisi Kamu</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" name="plat" label="Nomor Polisi/ Plat Nomor" type="text" :rules="[rules.plat]"></v-text-field>
                  
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="findNomor">Cari</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      
</template>

<script>
  export default {
    data: () => ({
      agreement: false,
      bio: '',
      dialog: false,
      plat: undefined,
      form: false,
      isLoading: false,
      password: undefined,
      phone: undefined,
      rules: {
        plat: v => (v || '').match(/@/) || 'Plat Nomor yang Anda Masukkan Salah',
        required: v => !!v || 'This field is required'
      }
    }),
    methods:{
        
    }
  }
</script>
