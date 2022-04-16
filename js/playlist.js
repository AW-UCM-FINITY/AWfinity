init();

function init(){
    var audio = document.getElementById('audio');
    var playlist = document.getElementById('playlist');
    var tracks = playlist.getElementsByTagName('a');
    audio.volume = 0.10;
    audio.play();
    
    for(var track in tracks) {
      var link = tracks[track];
      if(typeof link === "function" || typeof link === "number") continue;
      
			link.addEventListener('click', function(e) {
      	e.preventDefault();
        var song = this.getAttribute('href');
       	run(song, audio, this);
      });
    }
    
    audio.addEventListener('ended',function(e) {
        for(var track in tracks) {
					var link = tracks[track];
          var nextTrack = parseInt(track) + 1;
        	if(typeof link === "function" || typeof link === "number") continue;
          if(!this.src) this.src = tracks[0];
          if(track == (tracks.length - 1)) nextTrack = 0;
                                	console.log(nextTrack);
        	if(link.getAttribute('href') === this.src) {
          	var nextLink = tracks[nextTrack];
          	run(nextLink.getAttribute('href'), audio, nextLink);
            break;
          }
        }
    });
}

function run(song, audio, link){
				var parent = link.parentElement;

				//quitar el active de todos los elementos de la lista
				var items = parent.parentElement.getElementsByTagName('li');
        for(var item in items) {
					if(items[item].classList)
        		items[item].classList.remove("active");
        }
        
        //agregar active a este elemento
        parent.classList.add("active");
        
        //tocar la cancion
        audio.src = song;
        audio.load();
        audio.play();
}