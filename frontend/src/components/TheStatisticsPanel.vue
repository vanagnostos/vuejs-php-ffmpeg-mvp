<template>
  <div class="panel">
    <h4>Statistics</h4>
    <ul>
      <li :class="userTalkColor">
        <span>User Talk Percentage:</span><span>{{ userTalkPercentage }}</span>
      </li>
      <li :class="userUserMonologueColor">
        <span>Longest User Monologue:</span><span>{{ longestUserMonologue }}</span>
      </li>
      <li :class="customerMonologueColor">
        <span>Longest Customer Monologue:</span><span>{{ longestCustomerMonologue }}</span>
      </li>
    </ul>
  </div>
</template>

<script setup>
defineProps({
  data: {
    type: Object,
    required: true
  }
})
</script>

<script>
export default {
  computed: {
    userTalkPercentage() {
      return this.formatValue(this.data.user_talk_percentage, '%');
    },
    longestUserMonologue() {
      return this.formatValue(this.data.longest_user_monologue, 's');
    },
    longestCustomerMonologue() {
      return this.formatValue(this.data.longest_customer_monologue, 's');
    },
    userTalkColor() {
      return this.data.user_talk_percentage > 50 ? 'good' : 'bad';
    },
    customerMonologueColor() {
      return this.data.longest_customer_monologue > 60 ? 'good' : 'bad';
    },
    userUserMonologueColor() {
      return this.data.longest_user_monologue < 60 ? 'good' : 'bad';
    }
  },
  methods: {
    formatValue(value, suffix) {
      if (value === undefined) {
        return '';
      }
      return value.toFixed(2) + suffix;
    }
  }
}
</script>

<style scoped>
div {
  width: 340px;
}

ul{
  padding: 0;
}

li {
  display: flex;
  list-style-type: none;
  margin-bottom: 10px;
  padding: 10px;
  background: #fff;
  border-radius: 10px;
}

li:last-child{
  margin-bottom: 0;
}

li.good {
  color: #008c57;
}

li.bad {
  color: #ff5800;
}

li span{
  flex-grow: 1;
}

li span:last-child{
  width: 60px;
  text-align: right;
}

h4 {
  text-align: center;
  font-weight: bold;
  margin: 0 0 20px 0;
}
</style>
