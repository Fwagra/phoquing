

<script>
    import SingleTrack from './SingleTrack.vue'
    export default {
        resource: null,
        data () {
            return {
                countTracks: null,
                status: null,
                tracks : [],
                editedStart : '',
                editedEnd : '',
                editedtrack : {
                    date: '',
                    category: '',
                    comment: '',
                    end: '',
                    start: '',
                    id: '',
                    total: '',
                }
            }
        },
        components: {
           'single-track': SingleTrack,
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
                this.editedtrack.date = dateformat(new Date(), 'yyyy-mm-dd');
            })
        },
        updated: function () {
            this.countTracks = this.tracks.length;
            this.addProperties();
        },
        methods: {
            sendTrack : function (trackToSend) {
                this.resource.save(trackToSend).then((response) => {
                    if (response.status === 200) {
                        let sentTrack = response.body;
                        let trackIndex = this.indexById(sentTrack.id)
                        console.log('senttrack' + sentTrack.id );
                        console.log('trackindex' + trackIndex);
                        if (trackIndex >= 0) {
                            console.log('track');
                            console.log(trackIndex);
                           this.tracks[trackIndex] =  sentTrack;
                        } else {
                            console.log('else');
                            this.tracks.push(sentTrack);
                        }
                    }
                }, (response) => {
                    return response;
                });
            },
            sendInputTrack: function () {

                if (this.editedtrack.id === null)
                    this.status = 'edition';

                // In case of a new track, check if the last one is still running
                if (null === this.status && this.tracks.length) {
                    let lastTrack = this.tracks[this.tracks.length -1];
                    console.log('lastTrack '+ lastTrack);
                    if (!lastTrack.end){
                        this.stopTrack(lastTrack);
                    }
                }

                this.sendTrack(this.editedtrack);
//                console.log(sent);
//                if  (sent.body) {
//                    this.tracks.push(sent.body);
                    this.emptyEditedTrack();
//                }

            },
            stopTrack: function (val) {
                let i = this.indexById(val.id);
                this.tracks[i].end = dateformat(new Date());
                let sent = this.sendTrack(this.tracks[i]);
//                if (sent.body){
//                    this.tracks[i] = sent.body;
//                }
            },
            emptyEditedTrack: function() {
                this.status =
                this.editedtrack.category =
                this.editedtrack.id =
                this.editedtrack.start =
                this.editedtrack.end =
                this.editedtrack.comment = "";
                this.editedtrack.date = dateformat(new Date(), 'yyyy-mm-dd');
            },
            addProperties:function() {
                this.tracks.forEach(function (el) {
                    Vue.set(el, 'activated', false);
                    Vue.set(el, 'date', dateformat(el.start, 'yyyy-mm-dd'));
                    if (!el.end) {
                        Vue.set(el, 'end', '');
                    }
                });
            },
            indexById: function(id) {
                let index = this.tracks.map(tracks => tracks.id).indexOf(id);
                return index;
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
