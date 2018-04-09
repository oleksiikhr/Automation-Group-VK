/**
 * Access rights for the user token.
 *
 * @param $mask
 *
 * @returns {Array}
 *
 * @see https://vk.com/dev/permissions
 */
export function parseFromMask ($mask) {
  let permissions = []

  !!($mask & 1) && permissions.push('notify')
  !!($mask & 2) && permissions.push('friends')
  !!($mask & 4) && permissions.push('photos')
  !!($mask & 8) && permissions.push('audio')
  !!($mask & 16) && permissions.push('video')
  !!($mask & 64) && permissions.push('stories')
  !!($mask & 128) && permissions.push('pages')
  !!($mask & 256) && permissions.push('256')
  !!($mask & 1024) && permissions.push('status')
  !!($mask & 2048) && permissions.push('notes')
  !!($mask & 4096) && permissions.push('messages')
  !!($mask & 8192) && permissions.push('wall')
  !!($mask & 32768) && permissions.push('ads')
  !!($mask & 65536) && permissions.push('offline')
  !!($mask & 131072) && permissions.push('docs')
  !!($mask & 262144) && permissions.push('groups')
  !!($mask & 524288) && permissions.push('notifications')
  !!($mask & 1048576) && permissions.push('stats')
  !!($mask & 4194304) && permissions.push('email')
  !!($mask & 134217728) && permissions.push('market')

  return permissions
}
