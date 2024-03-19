import YouTubePlayer from "youtube-player"

const getVideo = ($el) => {
  if (!$el && !$el.length > 0) return;
  return {
    ytid: $el.attr("data-ytid"),
    slug: $el.attr("data-slug")
  }
}

const getPlaylist = ($el, video) => {
  const playlist = [];
  if ($el && $el.length > 0) {
    for(let i=0;i<$el.length;i++) {
      const playlistVideo = getVideo($($el[i]));
      playlist.push(playlistVideo);
    }    
  }
  return playlist;
}

const videoPlayer = () => {
  //Get HTML Elements
  const $videoPlayer = $('.video-player').first();
  const $playlist = $('.playlist-item');  

  // Variables
  let video;
  let playlist;

  // Get Video
  if ($videoPlayer && $videoPlayer.length > 0) {
    video = getVideo($videoPlayer);
    //console.log("play video", video)
  }

  // Get Playlist
  if ($playlist && $playlist.length > 0) {
    playlist = getPlaylist($playlist, video);
    //console.log("playlist", playlist)
  }

  if (video) {
    playVideo(video.ytid, playlist);
  }
}

const playVideo = (ytid, playlist) => {  
  //console.log("playVideo", ytid, playlist)
  let index = -1;
  playlist.map((element, i)=>{
    if (element.ytid == ytid) {
      index = i;
    }
  });

  const getNextVideo = () => {
    index++;
    if (index > playlist.length -1) index = 0;
    return playlist[index];
  }

  const player = YouTubePlayer("player", {
    videoId: ytid
  })

  player.on('stateChange', (event) => {
    // video ended
    if (event.data === 0) {
      console.log("VIDEO ENDED")
      const nextVideo = getNextVideo();
      window.location = "/video/"+nextVideo.slug + window.location.search;            
    }
  })
  
  player.playVideo(); 
}

export default videoPlayer;
