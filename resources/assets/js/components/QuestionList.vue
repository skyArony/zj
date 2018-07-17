<template>
  <div>
    <slot></slot>
  </div>
</template>

<script>
import { ContainerMixin } from "vue-slicksort";

export default {
  mixins: [ContainerMixin],
}
</script>

