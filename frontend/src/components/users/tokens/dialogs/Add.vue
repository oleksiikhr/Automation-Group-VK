<!--
  EMIT:
    @added - added a new user token (response from the server)
    @error - error from server
-->
<template>
  <el-dialog title="Добавить токен пользователя" :visible.sync="dialog" width="40%">
    <div>
      <el-form :model="form" label-width="100px">
        <el-form-item label="Название">
          <el-input v-model="form.name" />
        </el-form-item>
        <el-form-item label="Токен">
          <el-input v-model="form.token" />
        </el-form-item>
        <el-form-item label="Описание">
          <el-input v-model="form.description" type="textarea" />
        </el-form-item>
      </el-form>
    </div>
    <span slot="footer" class="dialog-footer">
        <el-button @click="dialog = false">Отмена</el-button>
        <el-button type="primary" @click="fetchAdd()" :loading="loading" :disabled="loading">
          Добавить
        </el-button>
      </span>
  </el-dialog>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    dialog: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      form: {},
      loading: false
    }
  },
  methods: {
    fetchAdd () {
      this.loading = true

      axios.post('users/tokens', this.form)
        .then(res => {
          this.$emit('added', res.data)
          this.form = {}
          this.loading = false
        })
        .catch(err => {
          this.$emit('error', err.response.data)
          this.loading = false
        })
    }
  }
}
</script>
