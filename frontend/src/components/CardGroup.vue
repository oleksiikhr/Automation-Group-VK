<template>
  <div class="card-group el-card">
    <div class="header">
      <div class="left">
        <i class="material-icons">people_outline</i>
        <span>1000 / 526</span>
      </div>
      <div class="right">
        <div class="time">
          <span>{{ timestampFromNow('2018-01-26 04:07:31') }}</span>
          <a title="Обновить" @click="fetchUpdateGroup(group)">
            <i class="material-icons">refresh</i>
          </a>
        </div>
        <a :class="'deactivated ' + (group.deactivated ? 'on' : 'off')"
           :title="group.deactivated ? 'Не активный' : 'Активный'"
            @click="fetchChangeStatusGroup(group)"
        ></a>
      </div>
    </div>
    <div class="body">

    </div>
    <div class="footer">

    </div>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  props: {
    group: {
      type: Object,
      required: true
    }
  },
  methods: {
    fetchChangeStatusGroup (group) {
      // TODO this.$store.commit('')
      console.log(group)
    },
    fetchUpdateGroup (group) {
      // TODO this.$store.commit('')
      console.log(group)
    },
    timestampFromNow (time) {
      return moment(time).fromNow()
    }
  }
}
</script>

<style lang="scss" scoped>
.card-group {
  border: 1px solid #e6e6e6;
  margin-bottom: 15px;
  padding: 10px;
}

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  i {
    font-size: 19px;
  }
}

.left {
  display: flex;
  align-items: center;
  > span {
    text-indent: 5px;
  }
}

.right {
  display: flex;
  align-items: center;
  > .time {
    display: flex;
    align-items: center;
    > a {
      margin-left: 8px;
      cursor: pointer;
      font-size: 0;
      transition: .3s;
      &:hover {
        background: #545c64;
        border-radius: 50%;
        color: #fff;
      }
    }
  }
}

.deactivated {
  width: 13px;
  height: 13px;
  border-radius: 50%;
  margin-left: 8px;
  cursor: pointer;
  transition: .3s;
  &:hover {
    background: #545c64 !important;
  }
  &.off {
    background: #3ca01b;
  }
  &.on {
    background: #e43232;
  }
}
</style>
