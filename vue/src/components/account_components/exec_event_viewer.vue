<template>
  <div>
    <vue-good-table :columns="columns" :rows="events" :paginate="true" :lineNumbers="true" :onClick="viewUser" />
  </div>
</template>
<script>
import { getAllEvents } from '../../router/config.js'

export default {
  data() {
    return {
      viewUser: function(row, index) {
        this.$router.push('/account_page/exec_event_viewer/event_info:' + row.id)
        localStorage.setItem("event", row.id)
      },
      events: [],
      columns: [{
          label: 'Title',
          field: 'title',
          type: 'name',
          filterable: true,
        },
        {
          label: 'Event Type',
          field: 'type',
          type: 'name',
          filterable: true,
        },
        {
          label: 'Date',
          field: 'date',
          type: 'date',
          filterable: true,
          inputFormat: 'YYYY/MM/DD',
          outputFormat: 'MMMM Do',
        },
      ],
    }
  },

  methods: {
    loadEvents() {
      var postData = {
        type: 'current'
      }
      this.$http.post(getAllEvents, postData).then(response => {
        var that = this
        var length = Object.keys(response.data[0]).length
        for (var i = 0; i < length; i++) {
          if (length > 1) {
            var obj = {
              id: response.data[0][i].id,
              title: response.data[0][i].title,
              date: response.data[0][i].date,
              type: response.data[0][i].event_type
            }
          } else {
            var obj = {
              id: response.data[0][0].id,
              title: response.data[0][0].title,
              date: response.data[0][0].date,
              type: response.data[0][0].event_type
            }
          }
          that.events.push(obj)
        }
      })
    }
  },
  mounted: function() {
    this.loadEvents()
    if (this.$store.state.user.status != 1) {
      alert('Executive Only Page')
      this.$router.push('/account_page')
    }
  }
}

</script>
