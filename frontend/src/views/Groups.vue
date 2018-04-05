<template>
  <div id="groups" class="view-content">
    <div class="section-header">
      <h1>Группы</h1>
      <el-button class="refresh" size="mini" icon="el-icon-refresh" :loading="storeLoading"
                 :disabled="storeLoading" @click="fetchGroups()" />
    </div>
    <el-row :gutter="10" justify="space-between">
      <el-col :md="18">
        <card-group v-for="group in groups" :key="group.id" :group="group" />
      </el-col>
      <!-- TODO Widget component for Groups.vue -->
      <el-col :md="6" class="hidden-sm-and-down">
        <right-column />
      </el-col>
    </el-row>

    <!-- DIALOGS -->

    <el-dialog title="Добавить группу" :visible.sync="dialogCreate" width="40%">
      <span>
        <el-input placeholder="ID, ссылка на группу" v-model="groupLink" />
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogCreate = false">Отмена</el-button>
        <el-button type="primary" @click="fetchCreateGroup()" :loading="loading" :disabled="loading">Добавить</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import RightColumn from '../components/groups/RightColumn'
import CardGroup from '../components/groups/Card'
import axios from 'axios'

export default {
  components: {
    RightColumn, CardGroup
  },
  data () {
    return {
      groupLink: '',
      loading: false,
      dialogCreate: false
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
    }
  },
  methods: {
    fetchCreateGroup () {
      this.loading = true

      // TODO Parse id from link, etc (this.groupLink)
      // TODO UserTokenID param

      axios.post('groups', {
        group_id: this.groupLink
      })
        .then(res => {
          this.loading = false
        })
        .catch(() => {
          this.loading = false
        })
    },
    fetchGroups () {
      this.$store.dispatch('fetchGroups')
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
