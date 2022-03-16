<template>
  <div class="message" v-bind:class="{ outgoing: isOutgoing(message), incomming: !isOutgoing(message) }">
    <div v-if="message.type == 'file'" class="block file-block border p-2">
      <img :src="message.file_url" class="img-fluid bg-white" />
    </div>
    <div v-else-if="message.type == 'product'">
      <product-block :product="message.product"></product-block>
    </div>
    <div v-else v-html="message.message" class="block text-block"></div>
  </div>
</template>

<script>
import ProductBlock from './blocks/ProductBlock.vue';
export default {
  components: { ProductBlock },
  props: ["message", "user"],

  methods: {
    // check if is outgoing message
    isOutgoing(message) {
      if (!this.user) {
        return false;
      }
      return message.sender_id == this.user.id ? true : false;
    },
  },
};
</script>