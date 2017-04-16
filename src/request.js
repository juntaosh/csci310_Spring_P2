// recorded id
var rId = [];
var rNames = [];

var allLyrics = [];

// recorded map of trackid to track_id
var rTrack2lyrics = new Map();

// recorded map of track_id to track_name
var rTrackid2Name = new Map();

// variable to check if it is a new search or add search
var isAdding = false;

// default funciton on btn to check if search or add button clicked
$(document).ready(function(){
	$("#btn-search").click(function(){
		isAdding = false;
		console.log("Searching");
	});
	$("#btn-add").click(function(){
		isAdding = true;
		console.log("Adding")
	});
});

// Autocomplete Default Function
$( function() {
		$( "#artistSearch" ).autocomplete({
			source: function( request, response ) {
			$.ajax({
				data:{
					apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
					q_artist: request.term,
					format:"jsonp",
					callback:"jsonp_callback"
				},
				url: "http://api.musixmatch.com/ws/1.1/artist.search",
				dataType: "jsonp",
				jsonpCallback: 'jsonp_callback',
				success: function(data){
					var suggestionlist=[];
					var tmp = data.message.body.artist_list;
					if(tmp.length!=0){
						var length = 5;
						if(tmp.length < 5) length = tmp.length;
						for(var i = 0; i < length; i++){
							var name = tmp[i].artist.artist_name;
							var country;
							if(tmp[i].artist.artist_country){
								country = tmp[i].artist.artist_country;
							} else {
								country = "unknown";
							}
							suggestionlist.push(name + "|         " + country);
						}
					}
					response(suggestionlist);
				}
			});
			},
			minLength: 2,
		});
	});

// Get The Artist Id
function getArtist(){
	var artistSearch = document.getElementById("artistSearch").value;
	artistSearch = (artistSearch.split("|"))[0];
	$.ajax({
		type: "GET",
		data:{
			apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
			q_artist: artistSearch,
			page_size:10,
			format:"jsonp",
			callback:"jsonp_callback"
		},
		url: "http://api.musixmatch.com/ws/1.1/artist.search",
		dataType: "jsonp",
		jsonpCallback: 'jsonp_callback',
		contentType: 'application/json',
		async: false,
		success: function(data){
			var tmp = data.message.body.artist_list;
			var isExisted = false;
			for(var i = 0; i < tmp.length; i++){
				var name = tmp[i].artist.artist_name;
				if(name.toLowerCase() == artistSearch.toLowerCase()){
					var id = tmp[i].artist.artist_id;
					// if is not adding but searching, empty the record Artist id and allLyrics lists
					if(!isAdding){
						rId = [];
						rNames = [];
						allLyrics = [];
					}
					rId.push(id);
					getAllAlbums(id);
					rNames.push(tmp[i].artist.artist_name);
					var namestr = "";
					for(var i = 0; i < rNames.length; i++){
						if(i == rNames.length-1){
							namestr += rNames[i];
						} else {
							namestr += rNames[i] + " + ";	
						}
					}
					document.getElementById("titleword").innerHTML = namestr;
					isExisted = true;
					break;
				}
			}
			if(!isExisted){
				//Generate Error Word Cloud
				var wordlist = [["No Such Artist", 80]];
				generateWordCloud(wordlist);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	});
}


function parseLyrics(allLyrics){
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url:'./src/frequencySort.php',
		data:{
			lyrics: allLyrics
		},
		success: function(returned){
			var wordlist = [];
			var length = returned.length > 250 ? 250 : returned.length;
			//var div = returned[0].count;
			for(var i = 0; i < length; i++){
				/*if(lastcount != returned[i].count) {
					size-=2;
					lastcount=returned[i].count;
				}*/
				wordlist.push([returned[i].word, (Math.sqrt(returned[i].count))*8]);
			};
			//console.log(wordlist);
			if(wordlist){
				generateWordCloud(wordlist);
			} else {
				//Generate No Result Word Cloud
				var wordlist = [["No Searching Result", 80]];
				generateWordCloud(wordlist);
			}
		},
		error: function(){
			console.log("ERROR");
		}
	});
}

// Get lyrics from Musixmatch by track_id array
function getLyrics(track_ids, length){
	var constlength = length;
	for(var i = 0; i < constlength; i++){
	var id = track_ids[i];
	$.ajax({
		type: "GET",
		data: {
			apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
			track_id: id,
			format:"jsonp",
		},
		async: false,
		url: "http://api.musixmatch.com/ws/1.1/track.lyrics.get",
		dataType: "jsonp",
		contentType: 'application/json',
		success: function(data) {
			if(data.message.body.lyrics.lyrics_language == 'en'){
				var lyrics = data.message.body.lyrics.lyrics_body;
				lyrics = lyrics.replace('...', '');
				lyrics = lyrics.replace('******* This Lyrics is NOT for Commercial use *******', '');
				lyrics = lyrics.replace('(1409614335039)','');
				//lryics = lyrics.replace(/\,/g , '');
				lyrics = lyrics.replace(/\n/g, ' ');
				rTrack2lyrics.set(track_ids[constlength-length], lyrics);
				allLyrics.push(lyrics);
			}
			// since ajax is synchronous, unable to change local variable, have to use this alternative way
			if(length==1){
				allLyrics.join();
				parseLyrics(allLyrics);
				if(Storage){
					var jsonresult = [];
					rTrack2lyrics.forEach(function(value,key){
						jsonresult.push({id:key, val: value});
					});
					var jsonObj = JSON.stringify(jsonresult);
					localStorage.setItem('rTrack2lyrics', jsonObj);
				}
			} else {
				length--;
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	});
	}
};

// get All Tracks from All Albums
function getTracks(album_ids, length){
	var track_ids = [];
	var constlength = length;
	for(var i = 0; i < constlength;i++){
		var id = album_ids[i];
		$.ajax({
			type: "GET",
			data:{
				apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
				album_id: id,
				page_size:100,
				format:"jsonp",	
			},
			url: "http://api.musixmatch.com/ws/1.1/album.tracks.get",
			dataType: "jsonp",
			contentType: 'application/json',
			async: false,
			success: function(data){
				var tmp = data.message.body.track_list;
				for(var j = 0; j < tmp.length; j++){
					if(tmp[j].track.has_lyrics==1)	track_ids.push(tmp[j].track.track_id);
					rTrackid2Name.set(tmp[j].track.track_id, tmp[j].track.track_name);
				}
				// since ajax is synchronous, unable to change local variable, have to use this alternative way
				if(length==1) {
					// store to localStorage for the later use
					if(Storage){
						var jsonresult = [];
						rTrackid2Name.forEach(function(value,key){
							jsonresult.push({id:key, val: value});
						});
						var jsonObj = JSON.stringify(jsonresult);
						localStorage.setItem('rTrackid2Name', jsonObj);
					}
					getLyrics(track_ids, track_ids.length);
				}else {
					length--;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
	
	}
}

// Get All Albums by the artist id
function getAllAlbums(artist_id){
	var track_ids = [];
	$.ajax({
		type: "GET",
		data:{
			apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
			artist_id: artist_id,
			page_size:100,
			format:"jsonp",
			callback:"jsonp_callback"
		},
		url: "http://api.musixmatch.com/ws/1.1/artist.albums.get",
		dataType: "jsonp",
		jsonpCallback: 'jsonp_callback',
		contentType: 'application/json',
		success: function(data){
			var albums = data.message.body.album_list;
			var album_ids = [];
			if(albums){
				for(var i = 0; i < albums.length; i++){
					album_ids.push(albums[i].album.album_id);
				}
				getTracks(album_ids, album_ids.length);
			}
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	});
}

// generateWordCloud by given wordlist[[word,value],[]...]
function generateWordCloud(wordlist){
	var options = {};
	options.list=wordlist;
	options.gridSize=Math.round(16 * $('#mycanvas').width() / 1024);
	options.weigtfactor=function(size){
		return Math.pow(size, 2.3) * $('#mycanvas').width() / 1024;
	};
	options.fontFamily='Times, serif';
	options.color='#000000';
	options.rotateRatio=0;
	options.rotationSteps=1;
	options.backgroundColor='#808080';
	options.drawOufofBound=false;
	options.click=function(item, dimension, event){
		window.open("Song_list.html?word="+item[0] + "&artist_id=" + rId);
	};
	WordCloud(document.getElementById('mycanvas'), options);
}

// The following is for the use of lyrics.html
function showLyricsByTrackID(track_id, word){
	$.ajax({
			type: "GET",
			data:{
				apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
				track_id: track_id,
				page_size:100,
				format:"jsonp",	
			},
			async: false,
			url: "http://api.musixmatch.com/ws/1.1/track.lyrics.get",
			dataType: "jsonp",
			contentType: 'application/json',
			success: function(data){
				console.log(data);
				if(data.message.body.lyrics.lyrics_language == 'en'){
					var lyrics = data.message.body.lyrics.lyrics_body;
					lyrics = lyrics.replace('...', '');
					lyrics = lyrics.replace('******* This Lyrics is NOT for Commercial use *******', '');
					lyrics = lyrics.replace('(1409614111551)','');
					lyrics = lyrics.replace(/\n/g, ' ');
					document.getElementById("lyrics_text").innerHTML = lyrics;
					highlight(word);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
}
function showSongTitle(track_id){
	$.ajax({
		type: "GET",
		data:{
				apikey:"dddfcf2ec4ec455403ad9a631c2ee8e9",
				track_id: track_id,
				page_size:100,
				format:"jsonp",	
			},
		async: false,
		url: "http://api.musixmatch.com/ws/1.1/track.get",
		dataType: "jsonp",
		contentType: 'application/json',
		success: function(data){
			console.log(data);
			document.getElementById("song_title").innerHTML = data.message.body.track.track_name;
			document.getElementById("artist_name").innerHTML = data.message.body.track.artist_name;
		},
		error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
		}
	});
}

// hight light the specific word
function highlight(text){
			var inputText = document.getElementById("lyrics_text");
			inputText.style.fontSize= "meduim";
    		var innerHTML = inputText.innerHTML;
    		var index = innerHTML.indexOf(text);
    		console.log(innerHTML);
    		if ( index >= 0 )
    		{ 	console.log("yoyo");
        		innerHTML = innerHTML.substring(0,index) + "<span class='highlight'>" + innerHTML.substring(index,index+text.length) + "</span>" + innerHTML.substring(index + text.length);
        		inputText.innerHTML = innerHTML;
    		}
}

