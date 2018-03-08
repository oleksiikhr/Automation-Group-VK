<template>
  <div id="groups">
    <h1>Groups</h1>
    <card-group v-for="group in groups" :key="group.id" :group="group" />
  </div>
</template>

<script>
import CardGroup from '../components/CardGroup'

export default {
  components: {
    CardGroup
  },
  activated () {
    this.$store.dispatch('fetchGroups')
  },
  computed: {
    groups () {
      return this.$store.state.groups.list
    }
  }
}
</script>
