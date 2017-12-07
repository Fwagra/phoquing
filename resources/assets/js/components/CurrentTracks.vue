

<script>
    import SingleTrack from './SingleTrack.vue'
    import Stats from './Stats.vue'
    export default {
        resource: null,
        data () {
            return {
                errors: '',
                countTracks: null,
                status: null,
                tracks : [],
                currentTime : '',
                editedStart : '',
                editedEnd : '',
                editedtrack : {
                    date: '',
                    category: '',
                    comment: '',
                    end: '',
                    start: '',
                    id: '',
                    total: '0',
                }
            }
        },
        components: {
           'single-track': SingleTrack,
           'stats': Stats,
        },
        mounted() {

            this.resource = this.$resource('/tracks{/id}');
            this.resource.get().then((response) => {
                this.tracks = response.body;
                this.countTracks = this.tracks.length;

                // Add the activated property for toggle in the template
                this.addProperties();

                // Set the default values
                this.editedtrack.start = (this.tracks.length) ? this.tracks[this.tracks.length -1].start : '';
                this.editedtrack.date = dateformat(new Date(), this.$yearFormat);
                this.editedStartDefault();
            })
        },
        updated: function () {
            this.countTracks = this.tracks.length;
            this.addProperties();
        },
        methods: {
            // Send the provided track to DB and refresh the list
            sendTrack : function (trackToSend) {
                this.resource.save(trackToSend).then((response) => {
                    if (response.status === 200) {
                        let sentTrack = response.body;
                        let trackIndex = this.indexById(sentTrack.id)
                        if (trackIndex >= 0) {
                           this.tracks.splice(trackIndex, 1, sentTrack);
                        } else {
                            this.tracks.push(sentTrack);
                        }
                        this.emptyEditedTrack();
                    }
                }, (response) => {
                    this.errors = response.body.errors;
                });
            },
            // Send the temporary track to DB
            sendInputTrack: function () {

                if (this.editedtrack.id === null)
                    this.status = 'edition';
                // In case of a new track, check if the last one is still running
                if (!this.status && this.tracks.length) {
                    let lastTrack = this.tracks[this.tracks.length -1];
                    if (!lastTrack.end){
                        this.stopTrack(lastTrack);
                    }
                }

                this.sendTrack(this.editedtrack);


            },
            // Set the end time of a track
            stopTrack: function (val) {

                let i = this.indexById(val.id);
                let endDate = dateformat(new Date());
                // If the current time is inferior than the start time, rewrite it
                if (endDate < dateformat(this.tracks[i].start)){
                    let newEndDate = new Date(this.tracks[i].start);
                    newEndDate.setMinutes(newEndDate.getMinutes() + 1);
                    this.tracks[i].end = dateformat(newEndDate);
                } else {
                    this.tracks[i].end = endDate;
                }
                this.sendTrack(this.tracks[i]);

            },
            editTrack: function (val) {
                this.status = "edition";
                for (let property in this.editedtrack) {
                    if (val.hasOwnProperty(property))
                        this.editedtrack[property] = val[property];
                }

                this.editedStart = dateformat(val.start, this.$hourFormat);
                if (val.end)
                    this.editedEnd = dateformat(val.end, this.$hourFormat);

            },
            deleteTrack: function (val) {
                this.resource.delete({id: val.id}).then((response) => {
                    if (response.status === 200) {
                        let i =  this.indexById(val.id);
                        this.tracks.splice(i, 1);
                    }
                }, (response) => {
                    this.errors = response.body.errors;
                });
            },
            cancelEditTrack: function () {
                this.status = '';
                this.emptyEditedTrack();
            },
            // Reset values of temporary track
            emptyEditedTrack: function() {
                this.status =
                this.editedtrack.category =
                this.editedtrack.id =
                this.editedtrack.end =
                this.editedEnd =
                this.errors =
                this.editedtrack.comment = "";
                this.editedtrack.date = dateformat(new Date(), this.$yearFormat);
                this.editedStartDefault();
            },
            // Add new properties to the track list
            addProperties:function() {
                let format = this.$yearFormat;
                this.tracks.forEach(function (el) {
                    Vue.set(el, 'date', dateformat(el.start, format));
                    if (!el.end) {
                        Vue.set(el, 'end', '');
                    }
                }, this);
            },
            // Return the index of track by its id
            indexById: function(id) {
                let index = this.tracks.map(tracks => tracks.id).indexOf(id);
                return index;
            },
            // Set the default start time according to the current tracks
            editedStartDefault: function() {

                if (this.tracks.length) {
                    let lastTrack = this.tracks[this.tracks.length -1];
                    if (lastTrack.end){
                        this.editedStart =  dateformat(lastTrack.end, this.$hourFormat);
                    } else {
                        this.editedStart =  dateformat(new Date(), this.$hourFormat);
                    }
                }
                else {
                    this.editedStart =  dateformat(new Date(), this.$hourFormat);
                }
            },
            getTempTotal: function(track) {
                if (track.start && !track.end) {
                    let currentTime = Date.now();
                    let startTime = Date.parse(track.start);
                    return mathPhp.round((currentTime - startTime) / 3600000, 1);
                }
                return 0;
            }
        },
        watch : {
            editedStart: function (val) {
                if  (val) {
                    this.editedtrack.start = dateformat(this.editedtrack.date + ' ' + val);
                } else {
                    this.editedtrack.start = '';
                }
            },
            editedEnd: function (val) {
                if  (val) {
                    this.editedtrack.end = dateformat(this.editedtrack.date + ' ' + val);
                } else {
                    this.editedtrack.end = '';
                }
            }
        }
    }
</script>
