<template>
  <div class="panel">
    <h4>Waveform</h4>
    <TheWaveform label="User" :data="data.user" color="#ff5800"/>
    <TheWaveform label="Customer" :data="data.customer" color="#008c57"/>
  </div>
</template>

<script setup>
import TheWaveform from '../components/TheWaveform.vue';

defineProps({
  data: {
    type: Object,
    required: true
  }
})
</script>

<style scoped>
div{
  flex-grow: 1;
}

h4 {
  margin: 0 0 30px 0;
  text-align: center;
  font-weight: bold;
}
</style>
