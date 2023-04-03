<template>
  <v-card>
    <v-tabs v-model="tab" bg-color="primary">
      <v-tab value="one">Fruits</v-tab>
      <v-tab value="two">
        <v-badge :content="counter" color="info" inline>
          <v-card-text>Favourites</v-card-text>
        </v-badge>
      </v-tab>
    </v-tabs>

    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="one">
          <List :fruits="fruits" @refresh="refetchFavourites"></List>
        </v-window-item>
        <v-window-item value="two">
          <Favourite :favs="favourites"></Favourite>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>

<script>
import List from "./components/List.vue";
import Favourite from "./components/Favourite.vue";
const API_URL = `http://127.0.0.1:8000`;

export default {
  name: "App",
  components: {
    List,
    Favourite,
  },
  data: () => ({
    fruits: [],
    favourites: [],
    counter: null,
    tab: "one",
  }),
  created() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      let data = await (await fetch(`${API_URL}/fruits`)).json();
      this.fruits = data;
      this.refetchFavourites()
    },
    async refetchFavourites() {
      this.favourites = Array.from(
        (await (await fetch(`${API_URL}/favourites`)).json())?.map(
          (el) => el["fruit"]
        )
      );
      this.counter = this.favourites?.length;
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 10px;
}
table {
  position: relative;
  border: 2px solid #42b983;
  border-radius: 3px;
  background-color: #fff;
  width: 100%;
  padding: 5px;
  padding-top: 4%;
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