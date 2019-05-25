<template>  
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Register</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-model="Nama" label="Nama"  type="text" :rules="[rules.required]"></v-text-field>
                  <v-text-field prepend-icon="person" v-model="email" label="Email" type="text" :rules="[rules.required, rules.email]"></v-text-field>
                  <v-text-field prepend-icon="lock" v-model="password" label="Password" id="password" type="password" :rules="[rules.required, rules.password]"></v-text-field>
                  <v-text-field prepend-icon="person" v-model="Alamat" label="Alamat" type="text" :rules="[rules.required]" ></v-text-field>
                  <v-text-field prepend-icon="person" v-model="Gaji" label="Gaji" type="text" :rules="[rules.required, rules.number, rules.notZero, rules.tooMuch]" ></v-text-field>
                  <v-select  prepend-icon="person"    v-model="Role"  :items="items"  label="Role"  :rules="[rules.required]" ></v-select>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="register">Register</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
        
      </v-container>
    
</template>


<script>


  export default {
   props: ['nextUrl'],
   data: () => ({

      Nama: undefined,
      email: undefined,
      Alamat: undefined,
      Gaji: undefined,
      Role: undefined,
      password: undefined,

      items:['CS', 'Kasir', 'Montir'],

      rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong',
        number: v => /^[0-9]*$/.test(v) || 'Angka tidak valid',
        notZero: v => v > 0 || 'Tidak boleh 0',
        tooMuch: v => v < 999999999 || 'Nilai terlalu besar!',
      },
      
      
      datas(){
        return{
          Nama: "",
          email: "",
          password: "",
          Alamat: "",
          Gaji: "",
          Role: "",
        }

      }
    }),
    methods:
      {
          register()
          {
             let Nama = this.Nama
             let email = this.email
             let password = this.password
             let Alamat =  this.Alamat
             let Gaji =  this.Gaji
             let Role  = this.Role
              axios.post('/api/register/', {
                Nama,
                email,
                password,
                Alamat,
                Gaji,
                Role
             
                }).then(response => {
                  this.$router.push(('/login'))                    
                    console.log('created Data');
     
          });
    }
  }
}
</script>
