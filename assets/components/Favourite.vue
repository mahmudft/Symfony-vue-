<template>
  <div v-if="favs?.length">
  <v-banner
      lines="one"
      color="deep-purple-accent-4"
      class="my-4"
    >
      <v-banner-text>
        Total Nutritions: {{count.toFixed(2)}}
      </v-banner-text>
    </v-banner>
    <!-- <div v-for="element in favs" :key="element.name"> -->
    <v-container class="bg-surface-variant">
      <v-row no-gutters>
        <v-col v-for="element in favs" :key="element.name" cols="12" sm="4">
          <v-card class="mx-auto" max-width="344" variant="outlined">
            <v-card-item>
              <v-card-title>Fruit: {{ element.name }}</v-card-title>

              <v-card-subtitle>
                <v-icon icon="mdi-{{element.name}}"></v-icon>
              </v-card-subtitle>
            </v-card-item>

            <v-card-title>Nutritions</v-card-title>

            <div class="px-4">
              <v-chip-group
                v-model="selection"
                v-for="(value, name) in element.nutritions"
                :key="name"
              >
                <v-chip>{{ name }}: {{ value }}</v-chip>
              </v-chip-group>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <!-- </div> -->
  </div>
  <p v-else>No Favourites.</p>
</template>
<script>
export default {
  name: "Favourite",
  props: {
    favs: Array,
  },
  data: () => ({
    count: 0
  }),
  created() {
    this.totalNutritions();
  },
  computed: {},
  methods: {
    totalNutritions() {
      let total = this.favs.map((el) => el["nutritions"]);
      total.forEach((element) => {
        for (const property in element) {
          this.count += element[property];
        }
      });
      
    },
  },
};
</script>