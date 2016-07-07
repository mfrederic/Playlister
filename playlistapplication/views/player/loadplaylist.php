<script type="text/javascript">

	var myPlaysliter = new jPlayerPlaylist({
		    jPlayer: "#jquery_jplayer_1",
		    cssSelectorAncestor: "#jp_container_1"
	    }, [], {
		    playlistOptions: {
		    	autoplay: true,
		    	enableRemoveControls: true
		    },
		    autoplay: true,
		    swfPath: "../js",
		    supplied: "mp3",
		    smoothPlayBar: true,
		    keyEnabled: true,
		    audioFullScreen: true, // Allows the audio poster to go full screen via keyboard,
		    size: {
		    	width: 'auto',
		    	height: '100%'
		    }
    });


    $("#jquery_jplayer_1").bind($.jPlayer.event.loadeddata, function(event) {
    	var track_title_container = $('.jp-track-title');
    	if(track_title_container.is(':hidden'))
    		track_title_container.slideDown(200);

    	track = myPlaysliter.current;
    	playlist = myPlaysliter.playlist;
    	track_info = playlist[track];
    	track_title_container.html(track_info.title + ' <span>' + track_info.artist + '</span>');
    });

</script>