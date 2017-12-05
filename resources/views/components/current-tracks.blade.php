<current-tracks inline-template>
    <div class="container">
        <div class="content" v-show="countTracks > 0">
            <ul>
                <li
                    is="single-track"
                    v-for="(track, key) in tracks"
                    :key="track.id"
                    :track="track"
                    :status="status"
                    @@stop="stopTrack"
                    @deletetrack="deleteTrack"
                >
                </li>
            </ul>
        </div>
        <div class="content" v-show="countTracks == 0">
            {{ trans('tracks.no_tracks_found') }}
        </div>

        <div class="form">
            <input name="date" type="date" v-model="editedtrack.date">
            <input name="start" type="time" v-model="editedStart">
            <input name="end" type="time" v-model="editedEnd">
            <input name="comment" type="text" v-model="editedtrack.comment">
            <input name="category" type="text" v-model="editedtrack.category">
            <input type="button" @click="sendInputTrack" value="{{ trans('tracks.add_button') }}">
        </div>
        <div class="errors" v-show="errors">
            <div class="error" v-for="(error, key, index) in errors">
                @{{ error[0] }}
            </div>
        </div>
    </div>
</current-tracks>