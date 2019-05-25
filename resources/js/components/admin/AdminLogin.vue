<template>  
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Login</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-model="email" label="Email" type="text" id="email" :rules="[rules.required, rules.email]" ></v-text-field>
                  <v-text-field prepend-icon="lock" v-model="password" label="Password" id="password" type="password" :rules="[rules.required, rules.password]"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" id="btn-login" @click="login">Login</v-btn>
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
      user_type: undefined,
     
      rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong'
      }
    }),
    methods:{
        login(){
          axios.post('/8786/api/login', {
            email: this.email,
            password: this.password
            }).then(response => {
                            let user = response.data.user
                            localStorage.setItem('user', JSON.stringify(user))
                            localStorage.setItem('jwt', response.data.token)
                            this.user_type = user.is_admin
                            

                            if (localStorage.getItem('jwt') != null) {
                                this.$emit('loggedIn')
                                if(this.user_type == 1){
                                  this.$router.push(('/admin'))
                                }else{
                                  this.$router.push(('/karyawan'))
                                }
                                // if (this.$route.params.nextUrl != null) {
                                //     this.$router.push(this.$route.params.nextUrl)
                                // } else {
                                //     this.$router.push(('/admin'))
                                // }
                            }
                        });
            
        }
    }
  }
</script>


 