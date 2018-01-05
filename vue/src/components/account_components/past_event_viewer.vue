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
        this.$router.push('/account_page/past_event_viewer/past_event_info:' + row.id)
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
        type: 'past'
      }
      this.$http.post(getAllEvents, postData).then(response => {
        var that = this
        response.data.forEach(function(event) {
          var obj = {
            id: event.id,
            title: event.title,
            date: event.date,
            type: event.event_type,
          }
          that.events.push(obj)
        })
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
