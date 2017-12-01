

<script>
    export default {
        resource: null,
        data () {
            return {
                countTracks: null,
                status: null,
                tracks : [],
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
        mounted() {
            this.resource = this.$resource('/tracks{/id}');
            this.resource.get().then((response) => {
                this.tracks = response.body;
                this.countTracks = this.tracks.length;

                // Add the activated property for toggle in the temlate
                this.tracks.forEach(function (el) {
                    Vue.set(el, 'activated', false);
                    Vue.set(el, 'date', dateformat(el.start, 'yyyy-mm-dd'));
                });

                // Set the default values
                this.editedtrack.start = (this.dates.length) ? this.dates[this.dates.length -1].start : '';
                this.editedtrack.date = dateformat(new Date(), 'yyyy-mm-dd');
            })
        },
        computed: {
            dates: function () {
                return this.tracks.map( (b) => {
                    b.start = dateformat(b.start, "HH:MM");
                    if (b.end){
                        b.end = dateformat(b.end, "HH:MM");
                    }
                    return b
                });
            }
        },
        methods: {
            sendTrack : function () {
                // In case of a new track, check if the last one is still running
                if (null === this.status) {
                    let lastDate = this.dates[this.dates.length -1];
                    if ( lastDate.end === null){
                        this.resource.save({id: lastDate.id, end: dateformat(new Date(), "HH:MM")}).then((response) => {
                            this.dates[this.dates.length -1].end = response.end
                        });
                    }
                }
                this.resource.save(this.editedtrack).then((response) => {
                    console.log(response);
                });
            }
        }
    }
</script>
