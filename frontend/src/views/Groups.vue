<template>
  <div id="groups" class="view-content">
    <h1>Группы</h1>
    <el-row :gutter="10" justify="space-between">
      <el-col :md="18">
        <card-group v-for="group in groups" :key="group.id" :group="group" />
      </el-col>
      <!-- TODO Widget component for Groups.vue -->
      <el-col :md="6" class="hidden-sm-and-down">
        <router-link to="/groups/add" class="add-group">
          <i class="material-icons">add</i>
          <span>Добавить группу</span>
        </router-link>
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
    // FIXME If groups === null
    this.$store.dispatch('fetchGroups')
  },
  computed: {
    groups () {
      return this.$store.state.groups.list
    }
  }
}
</script>

<style lang="scss" scoped>
.add-group {
  display: flex;
  flex-direction: column;
  border: 1px solid #e6e6e6;
  padding: 20px 10px;
  text-align: center;
  text-decoration: none;
  color: #333;
  transition: .3s;
  > i {
    margin-bottom: 10px;
  }
  > span {
    color: #848484;
  }
  &:hover {
    background: #545c64;
    color: #fff;
    > span {
      color: #afafaf;
    }
  }
}
</style>
