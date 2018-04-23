<!--
  EMIT:
    @added - added a new group
    @error - error from server
-->
<template>
  <el-dialog title="Добавить группу" :visible.sync="inDialog" width="40%">
    <div>
      <el-form :model="form" label-position="top">
        <el-form-item label="ID, ссылка на группу">
          <el-input v-model="form.input" />
        </el-form-item>
      </el-form>
    </div>
    <span slot="footer" class="dialog-footer">
        <el-button @click="inDialog = false">Отмена</el-button>
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
      inDialog: false,
      loading: false
    }
  },
  methods: {
    fetchAdd () {
      this.loading = true

      // TODO parse: form.input (get id from link*)

      axios.post('groups', {
        id: +this.form.input
      })
        .then(res => {
          this.$emit('added', res.data)
          this.form = {}
          this.inDialog = false
          this.loading = false
        })
        .catch(err => {
          this.$emit('error', err.response.data)
          this.loading = false
        })
    }
  },
  watch: {
    dialog () {
      this.inDialog = true
    }
  }
}
</script>
