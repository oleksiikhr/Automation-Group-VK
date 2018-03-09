<template>
  <div id="groups" class="view-content">
    <h1>Группы</h1>
    <el-row :gutter="10" justify="space-between">
      <el-col :span="18">
        <card-group v-for="group in groups" :key="group.id" :group="group" />
      </el-col>
      <el-col :span="6" class="hidden-xs-only">
        Test2
      </el-col>
    </el-row>
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
