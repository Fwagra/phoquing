<current-tracks inline-template>
    <div class="container">
        <div class="time-container">
            <h2> {{ trans('tracks.tracks_title') }}</h2>
            <div class="content" v-if="countTracks > 0">
                <ul>
                    <li
                        is="single-track"
                        v-for="(track, key) in tracks"
                        :key="track.id"
                        :track="track"
                        :status="status"
                        @@stop="stopTrack"
                        @edit="editTrack"
                        @deletetrack="deleteTrack"
                    >
                    </li>
                </ul>
            </div>
            <div class="content" v-else-if="countTracks == 0">
                {{ trans('tracks.no_tracks_found') }}
            </div>
            <div class="content" v-else>
                {{ trans('tracks.loading_tracks') }}
            </div>
        </div>
        <div class="stats-container">
            <div class="content" v-if="countTracks > 0">
                <h2> {{ trans('tracks.stats_title') }}</h2>
                <stats :tracks="tracks"></stats>
            </div>
        </div>

        <div class="form">
            <input name="date" type="date" v-model="editedtrack.date">
            <input name="start" type="time" v-model="editedStart">
            <input name="end" type="time" v-model="editedEnd">
            <input name="comment" type="text" v-model="editedtrack.comment">
            {{--<input name="category" type="text" v-model="editedtrack.category">--}}
            <autocomplete :selection="editedtrack.category" v-model="editedtrack.category"></autocomplete>
            <input type="button" @click="sendInputTrack" value="{{ trans('tracks.add_button') }}">
            <input v-show="status == 'edition'" type="button" @click="cancelEditTrack" value="{{ trans('tracks.cancel_edit_button') }}">
        </div>
        <div class="errors" v-show="errors">
            <div class="error" v-for="(error, key, index) in errors">
                @{{ error[0] }}
            </div>
        </div>
    </div>
</current-tracks>