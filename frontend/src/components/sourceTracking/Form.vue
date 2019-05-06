<template>
  <div class="row">
    <div class="col-12 mt-2">
      <div class="form-row">
        <div class="form-group col-lg-5">
          <label for="link">Link</label>
          <input
            id="link"
            v-model="source.link"
            name="link"
            type="text"
            class="form-control"
            placeholder="Bitten Link eingeben"
            required>
        </div>
        <div class="form-group col-lg-2">
          <label for="subject">Thema</label>
          <select
            id="subject"
            v-model="source.subject"
            name="subject"
            class="form-control custom-select"
            required>
            <option
              value=""
              disabled>Bitte wählen</option>
            <option
              v-for="subject in subjects"
              :value="subject.id"
              :key="subject.id">{{ subject.name }}</option>
          </select>
        </div>
        <div class="form-group col-lg-2">
          <label for="sourceType">Quellen-Typ</label>
          <select
            id="sourceType"
            v-model="source.sourceType"
            name="sourceType"
            class="form-control"
            required>
            <option
              disabled
              value="">Bitte wählen</option>
            <option
              v-for="sourceType in sourceTypes"
              :value="sourceType.id"
              :key="sourceType.id">{{ sourceType.name }}</option>
          </select>
        </div>
        <div class="form-group col-lg-2">
          <label
            for="vote"
            class="d-block">Nützlich</label>
          <div class="row">
            <div class="col-4 pr-0">
              <button
                :class="btnUpClass"
                type="button"
                class="btn"
                @click="setVote('up')">
                <fa icon="thumbs-up" />
              </button>
            </div>
            <div class="col-4 pl-2">
              <button
                :class="btnDownClass"
                type="button"
                class="btn"
                @click="setVote('down')">
                <fa icon="thumbs-down" />
              </button>
            </div>
            <input
              id="vote"
              :value="source.vote"
              type="radio"
              hidden>
            <div class="col-4" />
          </div>
        </div>
        <div class="form-group col-lg-1">
          <button
            type="button"
            class="btn btn-pico-inverse center-y mt-3"
            @click="storeNewSource">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: 'SourceTrackingForm',
    data () {
      return {
        source: {
          vote: null,
          link: null,
          subject: '',
          sourceType: '',
        },
        btnUpClass: 'btn-outline-success',
        btnDownClass: 'btn-outline-danger',
      }
    },
    computed: mapState({
      subjects: state => state.subjects.all,
      sourceTypes: state => state.sourceTypes.all,
    }),
    methods: {
      setVote (action) {
        if (action === 'up') {
          this.source.vote = 1;
          this.btnUpClass = 'btn-success';
          this.btnDownClass = 'btn-outline-danger'
        } else if (action === 'down') {
          this.source.vote = -1;
          this.btnUpClass = 'btn-outline-success';
          this.btnDownClass = 'btn-danger'
        }
      },
      storeNewSource() {
        this.$store.dispatch('sources/storeNewSource', this.source).then(this.clearInput())
      },
      clearInput() {
        this.source = {
          vote: null,
          link: null,
          subject: '',
          sourceType: '',
        }
      }
    }
  }
</script>
