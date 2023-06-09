<template>
  <div>
    <h4>{{ label }}</h4>
    <div class="bar">
      <template v-for="(item) in chunks">
        <span :style="{width: item.width + '%'}" :class="{talk: item.talk}"></span>
      </template>
    </div>
  </div>
</template>

<script setup>
//, backgroundColor: item.talk ? color : ''
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
  computed: {
    chunks() {
      if (!this.data.length) {
        return [];
      }
      const total  = this.data[this.data.length - 1][1] - this.data[0][0],
            chunks = [];
      for (let i = 0; i < this.data.length; i++) {
        let chunk = this.data[i];
        chunks.push(
            this.chunk(
                this.width(chunk[0], chunk[1], total),
                true
            )
        );
        if (this.data[i + 1]) {
          let nextChunk = this.data[i + 1];
          chunks.push(
              this.chunk(
                  this.width(chunk[1], nextChunk[0], total),
                  false
              )
          );
        }
      }
      return chunks;
    }
  },
  methods: {
    chunk(width, talk){
      return {
        width: width.toFixed(2),
        talk: talk
      };
    },
    width(start, stop, total){
      return (100 * (stop - start) / total);
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
  height: 100%;
}

.bar .talk{
  background-color: v-bind(color);
}
</style>
