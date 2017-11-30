

<script>
    export default {
        resource: null,
        data () {
            return {
                countTracks: null,
                tracks : []
            }
        },
        mounted() {
            this.resource = this.$resource('/tracks{/id}');
            this.resource.get().then((response) => {
                this.tracks = response.body;
                this.countTracks = this.tracks.length;
            })
        }
    }
</script>
