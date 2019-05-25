<template>  
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Ganti Password</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="lock" v-model="oldPass" label="Password Lama" type="password" ></v-text-field>
                  <v-text-field prepend-icon="lock" v-model="newPass" label="Password Baru" id="password" type="password"></v-text-field>
                  <v-text-field prepend-icon="lock" label="Password Baru"  type="password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="gantiPassword">Ganti Password</v-btn>
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
      email: undefined,
      password: undefined,
      //id: this.user.id,
     
      rules: {
        email: v => (v || '').match(/@/) || 'Please enter a valid email',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
          'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'This field is required'
      }
    }),
    methods:{
        gantiPassword(){

          axios.patch('/api/pegawai/gantipassword/'  , {
            newPass: this.password,
            //password: this.password
            })
            console('pass diganti');
            
        },
    }
  }
</script>


 