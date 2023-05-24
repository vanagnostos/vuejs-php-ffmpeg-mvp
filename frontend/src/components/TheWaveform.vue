<template>
  <div>
    <h4>{{ label }}</h4>
    <div class="bar">
      <template v-for="(item) in chunks()">
        <span :style="{width: item.width + '%', backgroundColor: item.talk ? color : ''}"></span>
      </template>
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: {
    type: Array,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  color: {
    type: String,
    required: true
  }
})
</script>

<script>
export default {
  methods: {
    chunks() {
      if (!this.data.length) {
        return [];
      }
      const total  = this.data[this.data.length - 1][1] - this.data[0][0],
            chunks = [];
      for (let i = 0; i < this.data.length; i++) {
        let chunk = this.data[i];
        chunks.push({
          width: (100 * (chunk[1] - chunk[0]) / total).toFixed(2),
          talk: true
        });
        if (this.data[i + 1]) {
          let nextChunk = this.data[i + 1];
          chunks.push({
            width: (100 * (nextChunk[0] - chunk[1]) / total).toFixed(2),
            talk: false
          });
        }
      }
      return chunks;
    }
  }
}
</script>

<style scoped>
div {
  display: flex;
  margin-bottom: 40px;
}

h4 {
  width: 100px;
  line-height: 40px;
}

.bar {
  width: 100%;
  height: 40px;
  margin: 0;
}

.bar span {
  width: 100%;
  height: 100%;
}
</style>
