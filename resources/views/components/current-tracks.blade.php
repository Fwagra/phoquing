<current-tracks inline-template>
    <div class="container">
        <div class="content" v-if="countTracks > 0">
            <ul v-for="track in tracks" :key="track.id">
                <li>
                    @{{ track  }}
                </li>
                @{{ track.start }}
            </ul>
        </div>
        <div class="content" v-else-if="countTracks == 0">
            {{ trans('tracks.no_tracks_found') }}
        </div>
        <div class="content" v-else>
            {{ trans('tracks.loading_tracks') }}
        </div>
    </div>
</current-tracks>