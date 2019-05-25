<template>

    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
    <v-flex>
    
  
    <v-toolbar flat color="white">
        <v-toolbar-title>Jasa Service</v-toolbar-title>
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
            <v-btn color="primary" dark class="mb-2" v-on="on">New Service</v-btn>
          </template>
          
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Nama_Service" label="Nama Service" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field  v-model="editedItem.Tarif" label="Tarif" :rules="[rules.required,rules.notZero,rules.tooMuch]"></v-text-field>
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
        :items="service"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
         
          <td >{{ props.item.Nama_Service }}</td>
          <td >Rp. {{ props.item.Tarif }}</td>
         
          <td class=" layout px-0">
            <v-icon
              small
              class="mr-2"
              @click="editItem(props.item)"
            >
              edit
            </v-icon>
            <v-icon
              small
              @click="deleteItem(props.item)"
            >
              delete
            </v-icon>
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
      
      { text: 'Nama Service', value: 'Nama_Service', sortable: true },
      { text: 'Harga', value: 'Tarif', sortable: true },      
      { text: 'Actions', value: 'id', sortable: false }
    ],
    service: [],
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
    
    fetchservice() {
      axios.get('/8786/api/service')
      .then(response => this.service = response.data)
    },
    
    initialize() {
      this.fetchservice();
    },

    editItem (item) {
      this.editedIndex = this.service.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.service.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.service.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/service/'+item.id)
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

        axios.patch('/8786/api/service/'+this.editedItem.id,{
          Nama_Service:this.editedItem.Nama_Service,
           Tarif:this.editedItem.Tarif
           })
        .then(response => {
          console.log(response);
        })
       
        Object.assign(this.service[this.editedIndex], this.editedItem)
      } else {
        console.log('created Data');
        axios.post('/8786/api/service',{Nama_Service:this.editedItem.Nama_Service, Tarif:this.editedItem.Tarif})
        .then(response => {
          console.log(response);
        })
        this.service.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>