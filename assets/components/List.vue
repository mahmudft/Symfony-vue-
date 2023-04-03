<template>
  <v-container v-if="fruits?.length">
    <v-row>
      <v-col cols="12" md="4">
        <v-select
          v-model="typeModal"
          :items="items"
          :rules="[(v) => !!v || 'Item is required']"
          label="Select type"
          required
        ></v-select>
      </v-col>

      <v-col cols="12" md="4">
        <v-text-field
          v-model="searchWord"
          :rules="nameRules"
          :counter="10"
          label="Search Word"
          required
        ></v-text-field>
      </v-col>
      <v-col>
        <v-btn color="warning" class="mt-4" block @click="refetchQueries()">
          Search
        </v-btn>
      </v-col>
    </v-row>
    <table>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Genus</th>
          <th class="text-left">Family</th>
          <th class="text-left">Order</th>
          <th class="text-left">Total Nutritions</th>
          <th class="text-left"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in frt" :key="item.id">
          <td>{{ item.name }}</td>
          <td>{{ item.genus }}</td>
          <td>{{ item.family }}</td>
          <td>{{ item.order }}</td>
          <td>{{ calculateNutritions(item.nutritions) }}</td>
          <td>
            <v-btn size="small" @click="addToFavourite(item.id)">Add</v-btn>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="text-center">
      <v-pagination
        v-model="page"
        :length="length"
        rounded="circle"
      ></v-pagination>
    </div>
  </v-container>
  <p v-else>No matches found.</p>
</template>


<script>
import Swal from "sweetalert2";
const API_URL = `http://127.0.0.1:8000`;

export default {
  name: "List",
  components: {},
  data() {
    return {
      favourites: [],
      items: ["all", "name", "family"],
      searchWord: "",
      frt: [],
      page: 1,
      length: 4,
      typeModal: "",
    };
  },
  props: ["fruits"],
  created() {
    this.frt = this.fruits;
  },
  watch: {
    fruits: {
      handler() {
        this.frt = [...this.fruits].slice(0, 10);
      },
    },
    page: {
      handler() {
        let data = [...this.fruits];
        this.length = data.length / 10;
        this.frt = data.slice((this.page - 1) * 10, this.page * 10);
      },
    },
  },
  methods: {
    async addToFavourite(id) {
      await fetch(`${API_URL}/favourites/${id}`, { method: "POST" })
        .then((res) => res.json())
        .then((res) => {
          Swal.fire({
            icon: "info",
            text: res,
          });
          this.$emit("refresh");
        })
        .catch((res) => {
          Swal.fire({
            icon: "error",
            text: res,
          });
        });
    },
    calculateNutritions(data) {
      let count = 0;
      for (const property in data) {
        count += data[property];
      }
      return count.toFixed(2);
    },
    middleFilter(value) {
      if (this.searchWord) {
        if (this.typeModal == "name") {
          return value.name
            .toLowerCase()
            .includes(this.searchWord.toLowerCase())
            ? true
            : false;
        } else if (this.typeModal == "family") {
          return value.family
            .toLowerCase()
            .includes(this.searchWord.toLowerCase())
            ? true
            : false;
        } else {
          return true;
        }
      } else {
        return true;
      }
    },
    refetchQueries() {
      let fruits = [...this.fruits];
      this.frt = fruits.filter(this.middleFilter);
    },
  },
};
</script>

<style>
table {
  position: relative;
  border: 2px solid #42b983;
  border-radius: 3px;
  background-color: #fff;
  width: 100%;
  padding: 5px;
  padding-top: 2%;
}
thead {
  position: sticky;
}
th {
  background-color: #42b983;
  color: rgba(255, 255, 255, 0.66);
  cursor: pointer;
  user-select: none;
}

td {
  background-color: #f9f9f9;
}

th,
td {
  min-width: 120px;
  padding: 10px 20px;
}

th.active {
  color: #fff;
}
/* 
th.active .arrow {
  opacity: 1;
} */

/* .arrow {
  display: inline-block;
  vertical-align: middle;
  width: 0;
  height: 0;
  margin-left: 5px;
  opacity: 0.66;
}

.arrow.asc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-bottom: 4px solid #fff;
}

.arrow.dsc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #fff;
} */
</style>