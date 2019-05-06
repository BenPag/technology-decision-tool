<template>
  <div class="row">
    <div class="col-12">
      <h2 class="mt-4">Verlauf</h2>
    </div>
    <div class="col-12">
      <table 
        v-if="history" 
        class="table table-hover table-bordered mt-2">
        <thead>
          <tr>
            <th>Link</th>
            <th>Thema</th>
            <th>Quellen-Typ</th>
            <th>Nützlich</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in history"
            :key="item.id">
            <td v-if="item.link">{{ item.link }}</td>
            <td v-if="item.subject">{{ item.subject.name }}</td>
            <td v-if="item.sourceType">{{ item.sourceType.name }}</td>
            <td>
              <div
                v-if="item.vote === 1"
                class="btn btn-success">
                <fa icon="thumbs-up" />
              </div>
              <div
                v-else
                class="btn btn-danger">
                <fa icon="thumbs-down" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <h3 
        v-else 
        class="mt-2">Kein Verlauf vorhanden</h3>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: 'SourceTrackingHistory',
    computed: mapState({
      history: state => state.sources.all,
    })
  }
</script>
