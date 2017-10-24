<template>
  <div>
    <div id="changeEventBox">
      <b>Add Event</b>
      <add_event></add_event>
    </div>
    <div id="changeEventBox">
      <b>Edit Event</b>
      <edit_event></edit_event>
    </div>
    <div id="changeEventBox">
      <b>Delete Event</b>
      <delete_event></delete_event>
    </div>
  </div>
</template>
<script>
import add_event from './add_event'
import edit_event from './edit_event'
import delete_event from './delete_event'

export default {
  components: {
    add_event,
    edit_event,
    delete_event
  }
}

</script>
<style>
#changeEventBox {
  border: solid !important;
  padding: 15px;
  width: 30%;
  float: left;
  margin-left: 20px;
}

</style>
