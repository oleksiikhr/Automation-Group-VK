<!--
  EMIT:
    @added - added a new token
    @error - error from server
-->
<template>
  <div class="right-column user-tokens">
    <!-- TODO get a token through a redirect from VK  -->
    <a @click="dialogs.add = !dialogs.add" class="card">
      <i class="material-icons">add</i>
      <span>Добавить токен</span>
    </a>

    <add-dialog :dialog="dialogs.add" @added="handleAdded" @error="handleError" />
  </div>
</template>

<script>
import AddDialog from './dialogs/Add'

export default {
  components: {
    AddDialog
  },
  data () {
    return {
      dialogs: {
        add: false
      }
    }
  },
  methods: {
    handleAdded (val) {
      this.$emit('added', val)
    },
    handleError (val) {
      this.$emit('error', val)
    }
  }
}
</script>
