<!--
  EMIT:
    @created - added new group (response from the server)
-->
<template>
  <div class="right-column groups">
    <a @click="create.dialog = true" class="card">
      <i class="material-icons">add</i>
      <span>Добавить группу</span>
    </a>

    <!-- DIALOGS -->

    <el-dialog title="Добавить группу" :visible.sync="create.dialog" width="40%">
      <span>
        <el-input placeholder="ID, ссылка на группу" v-model="create.form.input" />
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="create.dialog = false">Отмена</el-button>
        <el-button type="primary" @click="fetchCreateGroup()" :loading="create.loading" :disabled="create.loading">
          Добавить
        </el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      create: {
        dialog: false,
        loading: false,
        form: {
          input: ''
        }
      }
    }
  },
  computed: {
    userToken () {
      return this.$store.state.userTokens.selected
    }
  },
  methods: {
    fetchCreateGroup () {
      // TODO parse: create.form.input (get id from link*)
      let id

      this.create.loading = true

      axios.post('groups', {
        id: id,
        token_id: this.userToken.id
      })
        .then(res => {
          console.log(res.data)
          this.$emit('created', res.data)
          this.create.dialog = false
          this.create.loading = false
        })
        .catch(() => {
          this.create.loading = false
        })
    }
  }
}
</script>
