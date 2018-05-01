<template>
  <div id="groups" class="view-content">
    <div class="section-header">
      <h1>Группы</h1>
      <el-button class="refresh" size="mini" icon="el-icon-refresh" :loading="storeLoading"
                 :disabled="storeLoading" @click="fetchGroups()" />
    </div>
    <el-row :gutter="10" justify="space-between">
      <el-col :md="18" class="main-content" v-loading="storeLoading">
        <template v-if="!storeLoading">
          <card-group v-for="group in groups" :key="group.id" :group="group" />
          <el-alert v-if="!haveItems" title="Группы отсутствуют" type="warning" show-icon />
        </template>
      </el-col>
      <el-col :md="6">
        <right-column @added="fetchGroups" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import RightColumn from '../components/groups/RightColumn'
import CardGroup from '../components/groups/Card'

export default {
  components: {
    RightColumn, CardGroup
  },
  data () {
    return {
      groupLink: ''
    }
  },
  mounted () {
    this.fetchGroups()
  },
  computed: {
    groups () {
      return this.$store.state.groups.list
    },
    storeLoading () {
      return this.$store.state.groups.loading
    },
    haveItems () {
      return this.groups.length > 0
    }
  },
  methods: {
    fetchGroups () {
      this.$store.dispatch('fetchGroups')
    }
  }
}
</script>

<style lang="scss" scoped>
.main-content {
  min-height: 200px;
}
</style>
