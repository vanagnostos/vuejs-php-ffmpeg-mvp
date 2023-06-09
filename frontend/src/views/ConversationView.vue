<template>
  <main>
    <TheWaveformPanel :data="waveformData" v-show="valid"/>
    <TheStatisticsPanel :data="statisticsData" v-show="valid"/>
    <Preloader v-show="busy && !error"/>
    <div class="error" v-if="error">{{ error }}</div>
  </main>
</template>

<script setup>
import Preloader from '../components/Preloader.vue';
import TheStatisticsPanel from '../components/TheStatisticsPanel.vue';
import TheWaveformPanel from '../components/TheWaveformPanel.vue';</script>

<script>
export default {
  data: () => ({
    error: '',
    busy: true,
    data: {
      user: [],
      customer: [],
      user_talk_percentage: 0,
      longest_user_monologue: 0,
      longest_customer_monologue: 0
    }
  }),
  watch:{
    $route: {
      handler (to, from){
        this.fetchData()
      },
      immediate: true
    }
  },
  created() {
    this.$watch(
        () => this.$route.params,
        () => {
          //this.fetchData()
        },
        {
          immediate: true
        }
    )
  },
  computed: {
    valid(){
      return !this.busy && !this.error;
    },
    statisticsData() {
      return {
        user_talk_percentage: this.data.user_talk_percentage,
        longest_user_monologue: this.data.longest_user_monologue,
        longest_customer_monologue: this.data.longest_customer_monologue
      }
    },
    waveformData() {
      return {
        user: this.data.user,
        customer: this.data.customer
      }
    },
  },
  methods: {
    resetState() {
      this.error = '';
      this.busy  = false;
    },
    onError(message) {
      this.resetState();
      this.error = message;
    },
    fetchData() {
      const url     = import.meta.env.VITE_API_BASE_URL + '/v1/waveform/' + this.$route.params.id,
            options = {
              headers: {
                'Accept': 'application/json'
              }
            };
      this.busy     = true;
      fetch(url, options).then(response => {
        response.json().then(response => {
          this.busy = false;
          if (response.status == 'success') {
            this.data = response.data;
            return;
          }
          this.onError(response.message);
        }).catch(() => {
          this.onError('Application error, please try again.');
        });
      }).catch(() => {
        this.onError('Network error, please try again.');
      });
    }
  }
}
</script>

<style scoped>
.preloader {
  margin-top: 30px;
}

.panel {
  padding: 20px;
  background: #EEEEEE;
  border-radius: 20px;
  margin: 40px auto;
}

.error {
  color: red;
}

@media (min-width: 1024px) {
  main {
    display: flex;
    gap: 20px;
    padding-top: 40px;
  }

  .panel {
    margin: 0;
  }
}
</style>
