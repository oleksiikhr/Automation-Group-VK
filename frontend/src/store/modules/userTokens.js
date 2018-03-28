const state = {
  list: [],
  selected: {},
  isLoading: true
}

const mutations = {
  SET_USER_TOKENS (state, arr) {
    state.list = arr
  },
  SET_SELECTED_USER_TOKEN (state, obj) {
    state.selected = obj
  }
}

const actions = {

}

export default {
  state, mutations, actions
}
