<template>

    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
    <v-flex>
    
  
    <v-toolbar flat color="white">
        <v-toolbar-title>Kelola Kustomer</v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
              <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
            <v-btn color="primary" dark class="mb-2" v-on="on">New Kustomer</v-btn>
          </template>
          
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Nama_Kustomer" label="Nama Kustomer" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Alamat_Kustomer" label="Alamat Kustomer" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Telepon_Kustomer" label="Contact Kustomer" :rules="[rules.required, rules.number, rules.notZero]"></v-text-field>
                  </v-flex>
                  
                </v-layout>
              </v-container>
            </v-card-text>  
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>


        </v-dialog>
      </v-toolbar>
      <v-data-table
        :headers="headers"
        :items="kustomer"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
         
          <td >{{ props.item.Nama_Kustomer }}</td>
          <td >{{ props.item.Alamat_Kustomer }}</td>
          <td >{{ props.item.Telepon_Kustomer }}</td>
         
          <td class=" layout px-0">
            <v-icon small class="mr-2" @click="editItem(props.item)"> edit </v-icon>
            <v-icon small @click="deleteItem(props.item)">delete</v-icon>
            
          </td>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
         <v-alert v-slot:no-results :value="true" color="error" icon="warning">
          Your search for "{{ search }}" found no results.
          </v-alert>
      </v-data-table>

    </v-flex>
    </v-layout>
</template>

<script>
export default {

  
    
  data: () => ({

    rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong',
        number: v => /^[0-9]*$/.test(v) || 'Angka tidak valid',
        notZero: v => v > 0 || 'Tidak boleh 0',
        tooMuch: v => v < 999999999 || 'Nilai terlalu besar!',
      },

    isLoggedIn: localStorage.getItem('jwt') != null,

    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },

    dialog: false,
    search: '',
    headers: [
      
      { text: 'Nama Kustomer', value: 'Nama_Kustomer', sortable: true },
      { text: 'Alamat Kustomer', value: 'Alamat_Kustomer', sortable: true },
      { text: 'Kontak', value: 'Telepon_Kustomer', sortable: true },      
      { text: 'Actions', value: 'id', sortable: false }
    ],
    kustomer: [],
    editedIndex: -1,
    editedItem: {
     
    },
    defaultItem: {
      
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    }
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  created () {
    this.initialize()
  },

  methods: {
    
    
    fetchkustomer() {
      axios.get('/8786/api/kustomer')
      .then(response => this.kustomer = response.data)
    },
    
    initialize() {
      this.fetchkustomer();
    },

    editItem (item) {
      this.editedIndex = this.kustomer.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.kustomer.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.kustomer.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/kustomer/'+item.id)
        .then(response => {
          console.log(response);
        })
    },

  
    close () {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    save () {
      if (this.editedIndex > -1) {
        console.log('Edited Data');

        axios.patch('/8786/api/kustomer/'+this.editedItem.id,{
         Nama_Kustomer:this.editedItem.Nama_Kustomer,
         Alamat_Kustomer:this.editedItem.Alamat_Kustomer,
         Telepon_Kustomer:this.editedItem.Telepon_Kustomer
         })
        .then(response => {
          console.log(response);
        })
       
        Object.assign(this.kustomer[this.editedIndex], this.editedItem)
      } else {
        console.log('created Data');
        axios.post('/8786/api/kustomer',{
            Nama_Kustomer:this.editedItem.Nama_Kustomer,
            Alamat_Kustomer:this.editedItem.Alamat_Kustomer,
            Telepon_Kustomer:this.editedItem.Telepon_Kustomer
            })
        .then(response => {
          console.log(response);
        })
        this.kustomer.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>