

function songListDisplay(word2Freq){
	var list = document.getElementById("songlist");
	for(var i =0; i < word2Freq.length; i++){
		var entry = document.createElement('li');
			var a = document.createElement('a');
			var str = rTrackid2Name.get(word2Freq[i].key) + '\t';
			str_pad(str,20," ",STR_PAD_RIGHT);
			str += word2Freq[i].value;
			//entry.appendChild(document.createTextNode(str));
			a.textContent = str;
			var address = "lyrics.html?track_id=" + word2Freq[i].key + "&word=" + word;
			console.log(address);
			a.setAttribute("href", address);
			entry.appendChild(a);
		list.appendChild(entry);
	}
	
}
